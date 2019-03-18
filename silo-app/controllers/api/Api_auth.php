<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author Fajar Susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files (api_auth)
 **/
 class Api_auth extends CI_Controller {

/* rule untuk menvalidasi inputan password */
    private $rule=[]; // @var array
/* password baru yang nantinya akan di encrypt menggunakan password_hash BCRYPT*/
    private $new_password; // @var string
    
    private $encrypt; // @var string
    
    private $validation;
    
    private $old_password;
    
    public function __construct(){
       
       parent::__construct();
       
       $this->load->model(array('auth','blog_setting')); // model auth
       $this->load->helper(array('security','captcha'));
       
       $this->load->library('form_validation');
       
       $this->validation = $this->form_validation;
       
       if (!$this->input->is_ajax_request()){   // mencegah request yang bukan dengan 'XMLHttprequest' 
          show_404();
          
       }  
       
       
       /* pengaturan rule untuk validasi */
       $this->rule = array(array(
                                  'field' => 'new',
                                  'label' => 'Password Baru',
                                  'rules' => 'strip_tags|required|max_length[32]|min_length[6]|alpha_numeric'), array(
                                  'field' => 'confir',
                                  'label' => 'Konfirmasi Password Baru',
                                  'rules' => 'required|matches[new]'),array(
                                  'field' => 'old',
                                  'label' => 'Password Lama',
                                  'rules' => 'required'));
     
  }        
 
     public function auth()
     {
        
     if ($this->user->logged())
     {
        show_404();
     }
    
     // hilangkan tag 'p'
     $this->form_validation->set_error_delimiters('','');
     
     // set rule email
     $this->form_validation->set_rules('email', 'Email', 'required|valid_email', array('valid_email' => 'Masukan email dengan benar !'));
     
     // set rule password
     $this->form_validation->set_rules('password', 'Password', 'strip_tags|required');
     
     // set rule password
     $this->form_validation->set_rules('captcha', 'Captcha', 'strip_tags|required|callback__verif_captcha');
     
     if ($this->form_validation->run() == FALSE)
     {
        $response = ['status' => 'failure', 'message' => ['email' => form_error('email'), 'password' => form_error('password'), 'captcha' => form_error('captcha')]];
        
        echo json_encode($response);
        exit;
     }
     else
     {
        $email = strtolower($this->input->post('email', TRUE));  // email
        
        $password = $this->input->post('password', TRUE);  // Password
        
        if ($this->auth->login($email, $password) == "email")
        {
           $response = array('status' => 'failure', 'message' => array('email' => 'Email yang anda masukan salah !', 'password' => '', 'captcha' => ''));
           
           echo json_encode($response);
           exit;
      }
      else if ($this->auth->login($email, $password) == "password")
      {
         $response = array('status' => 'failure', 'message' => array('email' => '', 'password' => 'Password yang anda masukan salah !', 'captcha' => ''));
         
         echo json_encode($response);
         exit;
      }
      else
      {
         echo json_encode(array('status' => 'success', 'message' => array('email' => '', 'password' => '', 'captcha' => '')));
         exit;
      }
    }
  }
   
   public function _verif_captcha(){
      
     if ($this->input->post('captcha') != $this->session->userdata('captcha'))
      {
         $this->form_validation->set_message('_verif_captcha', 'Verifikasi kode captcha salah !');
         
         $this->session->unset_userdata('captcha');
         
         return FALSE;
      }
      else
      {
         $this->session->unset_userdata('captcha');
         
         return TRUE;
      }
   
    }
      
      public function get_captcha(){
         
         $config = array(
         
                     'img_path' => './captcha/',
                     'img_url' => site_url('captcha'),
                     'expiration' => 120,
                     'colors' => array(
                     
                          'background' => array(255, 255, 255),
                          'border' => array(33, 37, 57),
                          'grid' => array(230, 230, 250),
                          'text' => array(0, 0, 0)
                          
                          )
                     );
        $captcha = create_captcha($config);
        
        $this->session->set_userdata('captcha', $captcha['word']);
        
        echo json_encode(['captcha' => $captcha['image']]);
        exit;
                    
   }
   
   // Ganti password
   public function reset_password(){
      
      // jika user tidak dalam posisi login
      if (!$this->user->logged()){
         
         show_404();
      }
      
      
     $this->validation->set_rules($this->rule);
     $this->validation->set_error_delimiters("","");
     
      if ($this->validation->run()){
          
          $this->new_password = xss_clean($this->input->post('new')); // password baru
          $this->encrypt = password_hash($this->new_password, PASSWORD_DEFAULT); // encrypt password baru dengan BCRYPT untuk keamanan          
          $this->old_password = $this->input->post('old');    
                
          $verify = $this->blog_setting->pass_from_user();
          
       if (!password_verify($this->old_password, $verify)){         
          $response = array(array('status' => 'verify'), array('password' => 'Password lama tidak cocok.','newpassword' => '', 'confir' => ''));
          echo json_encode($response);
          
          exit;
          
       }   
       
         else  
         
            {
       
       if ($this->auth->reset_pass($this->encrypt)){
            $response = array(array('status' => 'success'), array('password' => '','newpassword' => '', 'confir' => ''));
            echo json_encode($response);
            exit;
               
            
       }
           else   {
                         $response = array(array('status' => 'failure'), array('password' => '','newpassword' => '', 'confir' => ''));
            echo json_encode($response, JSON_FORCE_OBJECT);
            exit;
                     
                   }
                   
                   }
    
     }
     else
     {
           
                     $msg['newpassword'] = form_error('new');
                     $msg['password'] = form_error('old');
                     $confir = form_error('confir');
                     
                     $response = array(array('status' => 'validate'), array('password' => $msg['password'],'newpassword' => $msg['newpassword'], 'confir' => $confir));
                     
            echo json_encode($response, JSON_FORCE_OBJECT);
            exit;
           
           
                }
  
   }
   
   public function logout(){
      
      if (!$this->user->logged()){
           show_404();
      }
      
      unset($_SESSION);
      session_destroy();
      echo json_encode(array('status' => 'success'));
      exit;
   }

 }