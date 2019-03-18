<?php defined('BASEPATH') OR exit('access alllowed !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files Panel_files
 **/
 class File extends CI_Controller {
   
  public function __construct(){
     
      parent::__construct();
 
     if (!$this->user->logged()){
          show_404(); // halaman 404
          
     }
  }
  
     public function index(){
 
     $this->load->view('admin/upload/files',['title' => CMS_NAME.' - File']);  
 
  }
   
 }