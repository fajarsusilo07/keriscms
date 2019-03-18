<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo
 * @since 1.0
 * @email <silophp@gmail.com>
 * @facebook.com/fajar.susilo.904
 * @ files controller Page
**/
  class Page extends CI_Controller {

   public function __construct(){
      
      parent::__construct();
      
      $this->load->model('blog_pages');
      
     if (!$this->user->logged()){
         show_404();
  
      }
           
   }
   
   public function index(){
      
      $this->load->view('admin/pages/pages',['title' => CMS_NAME.' - Page']);
         
   }
   
 }