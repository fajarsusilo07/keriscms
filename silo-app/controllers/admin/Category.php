<?php defined('BASEPATH') OR exit('access defined !');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @file Panel_category
 */
 class Category extends CI_Controller {	
 
 public function __construct(){
 	
  	parent::__construct();
  	// load model blog_category
  	$this->load->model('blog_category');
    
    if (!$this->user->logged()){
    	
    	  show_404();
    	  
    	  
        }
   
  }
  
  
    public function index(){
  
     $this->load->view('admin/category/category', array('title' => CMS_NAME.' | Category'));
     
    }
    
   }	