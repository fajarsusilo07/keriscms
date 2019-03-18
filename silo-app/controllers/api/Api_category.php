<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Api_category
  */
  class Api_category extends CI_Controller {
     
     private $rule, $rule2;
     
     public function __construct(){
     	
     	parent::__construct();
        
        $this->load->library(array('form_validation', 'pagination'));
        $this->load->helper('security');
        $this->load->model('blog_category');
        
        if (!$this->input->is_ajax_request() OR (!$this->user->logged())){
           
           show_404();
           
        }
                
     }
     
     public function datacategory($page = 1){
        
        $limit = 10;    // per page
        
        $offset = (int) $page;  
        
        $start_position = ($offset > 1 ) ? ($offset*$limit)-$limit : 0;  // halaman aktif
        $search = xss_clean($this->input->get('q'));   // pencarian 
        
        $count = $this->blog_category->count($search);   // total category
        
        $pagination = $this->pagination_category($count, $search);  // create pagination
        
        $list = $this->blog_category->listcategory($start_position, $search);  // list category
        
        $data = ['list' => $list, 'pagination' => $pagination, 'countAll' => $this->blog_category->count(""), 'count' => $search];
        
        $this->load->view('admin/category/category-result', $data);
        
        
     }
     
     
     public function pagination_category($count = 0, $search = ""){
     	
     	
     	 // konfigurasi pagination
    $keyword = (!empty($search)) ? $search : "";
 
    $config['base_url'] = '/api/api_category/datacategory';
    $config['total_rows'] = $count;
    $config['per_page'] = 10;
    $config['use_page_numbers'] = TRUE;
    $config['uri_segment'] = 4;
  
    // styling pagination dengan bootstrap
    $method = "return getCategory($(this).attr('href'),'$keyword')";  // method onclick javascript
    $config['attributes'] = array('onclick' => $method);
    $config['attributes']['rel'] = FALSE;
    $config['full_tag_open'] = '<div class="my-3">
 <nav> <ul class="pagination">';
    $config['full_tag_close'] 	= '</ul></nav></div>';
    $config['num_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close'] 	= '</span></li>';
    $config['cur_tag_open'] 	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] 	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close'] 	= '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close'] 	= '</span></li>';
    $config['first_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['first_tag_close'] = '</span></li>';
    $config['last_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['last_tag_close'] 	= '</span></li>';
    
       // inisialiasi konfigurasi
       $this->pagination->initialize($config);
       // render 
       return $this->pagination->create_links();
       exit;
       
       
    }
    
    public function create(){
    	
    	 $this->rule = array(
               array('field' => 'name',
                     'label' => 'Nama kategori',
                     'rules' => 'strip_tags|required|max_length[24]|is_unique[blog_category.name]'),
                     array('field' => 'permalink',
                     'label' => 'Slug kategori',
                     'rules' => 'required|strip_tags|max_length[24]|is_unique[blog_category.permalink]'));
   
   $this->form_validation->set_rules($this->rule);  // rule
   
   $this->form_validation->set_message('is_unique', '%s tidak tersedia atau sudah di gunakan.');  
   
   $this->form_validation->set_error_delimiters("",""); // hilangkan karakter "<p>"
   
   if ($this->form_validation->run()){
   	      
      $name = xss_clean($this->input->post('name'));  // Nama kategori
      
      $permalink = strtolower($this->input->post('permalink'));  // permalink          atau slug
      
      $slug = url_title($permalink, 'dash');
      
      $insert = $this->blog_category->insert(['name' => $name, 'permalink' => $slug]);
      
      if (!$insert){
      	
      	  echo json_encode(['status' => 'failure', 'message' => ['name' => '', 'permalink' => '']]);
      	  exit;
  
     }
     
  
  
      else 
        
        
           {
           	
           	  echo json_encode(['status' => 'success', 'message' => ['name' => '', 'permalink' => '']]);
           	  
           	  exit;
           	
           }
     
     
        }
        
         
         else 
         
              {
              	
              	  echo json_encode(['status' => 'validate', 'message' => ['name' => form_error('name'), 'permalink' => form_error('permalink')]]);
              	  
              	  exit;
              	
              }
       
         }
         
         public function edit(){
         
         $this->rule2 = array(
                   array(
                        'field' => 'name',
                        'label' => 'Nama kategori',
                        'rules' => 'strip_tags|required|max_length[24]'),
                        array(
                         'field' => 'permalink',
                         'label' => 'Slug kategori',
                         'rules' => 'strip_tags|required|max_length[24]'));
                         
     $this->form_validation->set_rules($this->rule2);
     
     $this->form_validation->set_error_delimiters("","");  // hilangkan karakter "<p>"
                        
    if ($this->form_validation->run()){
                      
        $id = (int) $this->input->post('id');  // id kategori
        
        $detail = $this->blog_category->detail_category($id);
        
        $name = xss_clean($this->input->post('name'));   // Nama kategori baru
        
        $slug = strtolower(xss_clean($this->input->post('permalink')));
        
        $permalink = url_title($slug, 'dash');    // permalink kategori baru
        
        if ($detail != NULL){
        	
        	  if ($this->blog_category->is_unique_cat('name', $name, $detail['name'])) 
        	     {
        	     	
        	     	echo json_encode(['status' => 'validate', 'message' => ['name' => 'Nama kategori tidak tersedia atau sudah di gunakan.', 'permalink' => '']]);
        	     	exit;
        	     	
        	     	
        	     }
        	     
        	     else if ($this->blog_category->is_unique_cat('permalink', $permalink, $detail['permalink']))
        	          {
        	          	
        	          	
        	          	echo json_encode(['status' => 'validate', 'message' => ['name' => '', 'permalink' => 'Kategori Slug tidak tersedia atau sudah di gunakan.']]);
        	          	exit;
        	          	
        	          	
        	          }
        	          
        	          
        	        else
        	            
        	            
        	             {
        	                	
        	                	$update = ['name' => $name, 'permalink' => $permalink];
        	                	
        	               if ($this->blog_category->update($update, $id)){
        	                		
        	                		echo json_encode(['status' => 'success', 'message' => ['name' => '', 'permalink' => '']]);
        	                		exit;
        	                		
        	                		
        	          }
        	                	 
        	             else
        	                	   {
        	                	         	
        	                	        
        	                	        
        	                	   echo json_encode(['status' => 'failure', 'message' => ['name' => '', 'permalink' => '']]);
        	                	   exit;
        	                	        
        	                	         	
        	                	         	
        	                	   }	
        	                	
        	          }
        	
        	
       }
       
          else
           
                {
                	
                	
                	echo json_encode(['status' => 'failure', 'message' => ['name' => '', 'permalink' => '']]);
                	exit;
                	
                	
                }
                  		
       }
            
          else
            
               {
                  	
                  	echo json_encode(['status' => 'validate', 'message' => ['name' => form_error('name'), 'permalink' => form_error('permalink')]]);
                  	
                  	exit;
                  	
       
        }
    
     }
     
     
     public function delete(){
     	
     	$id = (int) $this->input->post('id');
     	
     	$detail = $this->blog_category->detail_category($id);  
     	
     	if ($detail != NULL){
     		
    		  if ($this->blog_category->delete($id)){
     		  	
     		  	// print_r($_POST); exit;
     	
     		  	echo json_encode(['status' => 'success']);
     		  	exit;
     		  	
     		  	
     		   }
     		   
     		     else
     		           
     		          {
     		          	
     		          	echo json_encode(['status' => 'failure']);
     		          	exit;
     		          	
     		          }
     		
          	}
          	
          	  else
          	      
          	        {
          	        	
          	        	
          	        	echo json_encode(['status' => 'failure']);
          	        	exit;
          	        	
          	        	
            }
     	
       }
     
  }