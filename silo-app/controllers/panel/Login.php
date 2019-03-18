<?php defined('BASEPATH') OR exit('access denied !');
 /*
  * @Author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Login
  */
  
  class Login extends CI_Controller {
     
     // username atau email	
     	public $username;
     // kata 
     	public $password;
     	
    public function __construct(){
     
  	  	 parent::__construct();
  	  	 
  	  	 $this->load->helper('captcha');
  	  	 
  	   if ($this->user->logged())
  	   {
  	 	 
  	 	  redirect(site_url('admin'));
  	  
  	  }
   }
  	      
    public function index(){
       
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
        
        $data['captcha'] = $captcha['image'];
        
  	$this->load->view('admin/user/login', $data);
  	 	 	 
   }
 }