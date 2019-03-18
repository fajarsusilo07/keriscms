<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @file Panel_index
 */
 class Dashboard extends CI_Controller {
    
   public function __construct(){
      
      parent::__construct();
     
      $this->load->model(array('blog_post','blog_pages','blog_files', 'blog_category'));
            
      if(!$this->user->logged()){
         
         show_404();
      
      }
   }

     	public function index(){
     	   
      $data['title'] = 'Dashboard';

      // total post
      $data['total_post'] = $this->blog_post->count("","publish");
      // total pages
      $data['total_pages'] = $this->blog_pages->count("");
      // total file
      $data['total_file'] = $this->blog_files->count();
      // total category
      $data['total_category'] = $this->blog_category->count();
      
      
      $this->load->view('admin/dashboard',$data);
    		
     	}
   
    }