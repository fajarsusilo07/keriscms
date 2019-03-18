<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Blog_panel
  */
 class Post extends CI_Controller {
      
    public function __construct(){
       
     parent::__construct();
    
   $this->load->library('form_validation'); // load library form_validation
   $this->load->helper('security');
    
   $this->load->model(array('blog_post','blog_category'));
     		 
    if (!$this->user->logged()){
      	
      	show_404();
      	
       }
      	
   }
      		 
      		 
   public function index(){
      
      $data = array('title' => CMS_NAME.' - '.'Post');
      
      $this->load->view('admin/post/post', $data);
   
     }
     
     
     
     public function add(){
     	
     	$list = $this->blog_category->allcategory();
     	
     	$this->load->view('admin/post/add', array('title' => CMS_NAME.' | POST - New', 'category' => $list));
     	
     }
     
     
     public function edit($id = 0){
        
       $post_id = (int) $id;  // id post
       $found = $this->db->where('id', $post_id)
                         ->from('blog_post')
                         ->get();
                                    
       if (($post_id == 0) OR ($found->num_rows() == 0)){
          
            show_404();
         }
         
         $row = $found->row_array();
         
         $category = $this->blog_category->allcategory();
         
         $data = ['title' => CMS_NAME.' - Edit Post', 'artikel' => $row, 'category' => $category];
         
         $this->load->view('admin/post/edit', $data);
        
     }

  }