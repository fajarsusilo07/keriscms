<?php defined('BASEPATH') OR exit('access denied');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files (Setting Ajax)
 **/
 class Api_setting extends CI_Controller {
 
   private $setting, $form, $rule;
        
     public function __construct(){
    
     parent::__construct();
    
    if ((!$this->input->is_ajax_request()) OR (!$this->user->logged())){
         show_404();
    }
   
    $this->load->model('blog_setting');    // load model
    
    $this->load->library('form_validation');    // load library form_validation
    
  $this->setting = $this->blog_setting;
  $this->form = $this->form_validation;

   // rules for form_validation
    $this->rules = array(array(
                             'field' => 'title',
                             'label' => 'Judul Situs',
                             'rules' => 'required|max_length[62]|strip_tags'),
                             array(
                             'field' => 'description',
                             'label' => 'Deskripsi ',
                             'rules' => 'required|max_length[300]|strip_tags'),
                             array(
                             'field' => 'keyword',
                             'label' => 'Kata Kunci',
                             'rules' => 'required|strip_tags|max_length[500]'));
}
   
     public function edit(){
      
       $title = $this->input->post('title', TRUE); // title 
       
       $description = $this->input->post('description', TRUE); // description
       
       $keyword = $this->input->post('keyword', TRUE); // keyword
       
       $post_limit = (int) $this->input->post('post_limit', TRUE); // post_limit
       
       $slugpost = $this->input->post('slugpost', TRUE);
       
 $this->form->set_error_delimiters("","");   // set error delimiter
 $this->form->set_rules($this->rules); // set rules
 
       if ($this->form->run() == FALSE){
        
          // tampilkan pesan error
          $title_msg = form_error('title'); // error untuk title
          $description_msg = form_error('description'); // error untuk description
          $keyword_msg = form_error('keyword'); // error untuk keyword
                    
           $response = array(
                       array('status' => 'validate'),
                       array('title' => $title_msg, 'description' => $description_msg, 'keyword' => $keyword_msg));
                     
                          echo json_encode($response);
                 exit;
      
       }
       else  
       {
            $data = array(
                          'title' => $title,
                          'description' => $description,
                          'keyword' => $keyword,
                          'post_limit' => $post_limit,
                          'slugpost' => $slugpost);
            if ($this->setting->update($data))
            {
                    $response = array(
                       array('status' => 'success'),
                       array('title' => '','description' => '','keyword' => ''));
                          echo json_encode($response);
                          exit;
            } 
           
             else
                    {
            
              $response = array(
                       array('status' => 'failure'),
                       array('title' => '', 'description' => '', 'keyword' => ''));
                       echo json_encode($response);
                       exit;
                          
       }
     }    
   }
 }