<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author Fajar Susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files account (controller)
 **/
   class Account extends CI_Controller {
       
    private $setting;
    
    public function __construct(){
       
      parent::__construct();
      
       $this->load->model('blog_setting');
       
       if (!$this->user->logged()){
       
           show_404();
     
        }

    }
      
     public function index(){  
     
     $data = ['title' => CMS_NAME.' - Account', 'account' => $this->blog_setting->get_account()];
     
     $this->load->view('admin/setting/account', $data);
     
     
     }
    
  }