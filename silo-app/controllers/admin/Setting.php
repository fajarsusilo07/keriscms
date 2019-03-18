<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @file Setting (Controller)
 **/
 class Setting extends CI_Controller {
   
   private $setting; // var setting @string
   // @constructor
    public function __construct(){   
    
    parent::__construct();
    
    if (!$this->user->logged()){ 
    
         show_404();
       
    }
    
    $this->load->model('blog_setting'); // load model
    
    $this->load->library('user');
    
    $this->setting = $this->blog_setting;
    
 }
    public function index(){
     
     $data = array('title' => CMS_NAME.' - Setting', 'setting' => $this->setting->get_setting());
     // @template view
     $this->load->view('admin/setting/setting',$data);
    }
 }