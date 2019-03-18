<?php defined('BASEPATH') OR exit('access denied !'); 
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files api_account(Controller)
 **/
 class Api_account extends CI_Controller {
    private $account,$form,$rule;
    
    private $path_photo = './file/'; // tentukan lokasi upload file
   
    public function __construct(){
      
      parent::__construct();
      
       $this->load->model('blog_setting'); // load model blog_setting
       $this->load->library('form_validation'); // load public form_validation
       
       $this->account = $this->blog_setting;
       $this->form = $this->form_validation;
      // rules untuk validasi akun 
       $this->rule = array(
                  array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email|max_length[62]'),
                  array(
                        'field' => 'fullname',
                        'label' => 'Nama Lengkap',
                        'rules' => 'required|max_length[32]|strip_tags|ucwords'),
                 array(
                        'field' => 'quote',
                        'label' => 'Kutipan',
                        'rules' => 'max_length[120]|strip_tags'),
                 array(
                        'field' => 'confirpw',
                        'label' => 'Password',
                        'rules' => 'required'));
       
       if (!$this->input->is_ajax_request() OR (!$this->user->logged())){ // jika request bukan dari ajax atau user tidak dalam posisi login
       show_404(); // tampilkan halaman 404 not found
       
       }  
       
    }
    
    
       public function set_account(){
        
       $this->form->set_rules($this->rule); // set rules
       $this->form->set_error_delimiters("",""); // hapus karakter "<p>" dalam pesan error
       if ($this->form->run() == FALSE){
          
           $email_msg = form_error('email'); // pesan error untuk email
           $fullname_msg = form_error('fullname'); // pesan error untuk fullname
           $quote_msg = form_error('quote'); // pesan error untuk quote
           $password_msg = form_error('confirpw'); // pesan error untuk password
           
           $response = array(array('status' => 'validate'), array('email' => $email_msg, 'fullname' => $fullname_msg, 'quote' => $quote_msg, 'password' => $password_msg));  
           echo json_encode($response); 
           exit;
       }
          
          else 
             
               {
                  
                  $email = $this->_cleaner($this->input->post('email')); // email
                  $fullname = $this->_cleaner($this->input->post('fullname')); // fullname
                  $quote = $this->_cleaner($this->input->post('quote')); // quote
                  $pass = $this->input->post('confirpw');
                  $pass_from_db = $this->account->pass_from_user();
                  
                  if (!password_verify($pass,$pass_from_db)){
                    
                    $response = array(array('status' => 'validate'),array('email' => '', 'fullname' => '', 'quote' => '','password' => 'Password salah, silahkan masukan password yang benar untuk memperbaharui akun.')); 
                    
                    echo json_encode($response);
                    exit;
                     
                  }
                  
           else 
                    
                  {
                  
                  if ($this->account->set_account(array('email' => $email, 'fullname' => $fullname, 'quote' => $quote))){   // jika berhasil melakukan query
                     $response = array(array('status' => 'success'),array('email' => '', 'fullname' => '', 'quote' => '','password' => ''));
                        
                        echo json_encode($response);  
                        exit;
                     }
                     
                        else  
                             
                              {
                                 
                                 $response = array(array('status' => 'failure'),array('email' => '', 'fullname' => '', 'quote' => '', 'password' => ''));
                                 
                                 echo json_encode($response);
                                 exit;
                                 
             }             
          }           
       }    
    }
    
    protected function _cleaner($string){
       
       $this->load->helper('security');  // load security helper     
       $xss_clean = xss_clean($string); // Cross Site Script Hack Filtering
       return $xss_clean;
       
    }
    
    public function change_photo(){
      // print_r($_FILES); exit;
      $this->load->library('upload'); // load library upload
      // set agar file dengan extensi gambar saja yang dapat di upload
   $change_photo_rule = [
          'upload_path' => $this->path_photo,
          'max_size' => 2048, 
          'allowed_types' => 'png|jpg|gif|jpeg',
          'file_ext_tolower' => TRUE,
          'max_filename' => 32,
          'max_filename_increment' => 0,
          'encrypt_name' => TRUE
          ];
          
          // initialize rule
          $this->upload->initialize($change_photo_rule);
          if ($this->upload->do_upload('userfile')){
             $image_name = $this->upload->data('file_name'); 
             if ($this->account->change_photo(array('picture' => $image_name))){
               echo json_encode(array('status' => 'success','message' => ''));
                 exit;
             }
               else
                    {
                               
                  echo json_encode(array('status' => 'failure','message' => 'terjadi kesalahan saat memproses data.'));
                 exit;
               }
          }
          
            else  {
               
                   $message = $this->upload->display_errors("","");
                    echo json_encode(array('status' => 'failure','message' => $message));
                    exit;
               
            }      
       
    }
    
    
    public function photo(){
       
       $response = $this->user->avatar();
       echo json_encode(['image' => $response]);
       exit;
    }
    
 }