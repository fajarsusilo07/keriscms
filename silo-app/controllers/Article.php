<?php defined('BASEPATH') OR exit("access denied !");
 /**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Blog
 **/
   class Article extends CI_Controller {
      
      private $limit;   // limit post per page
      private $rule = [];
      
      
   	   public function __construct(){
   	   parent::__construct();
   	     // load model
   	  	 $this->load->model(array('blog_post', 'blog_category', 'blog_pages', 'blog_setting'));
   	  	 // load library
   	  	 $this->load->library(array('pagination', 'form_validation'));
   	  	 // set post per page
   	  	 $this->limit = $this->blog_setting->get_setting()['post_limit'];
   	  	 
      }
      
    public function index(){
    
    $this->data['page'] = 'index';
    // Total post
    $count = $this->blog_post->count("", "publish");
    // show pagination
    $this->data['pagination'] = $this->link_pagination('article/page', $count);  
    // show article
    $this->data['post'] = $this->blog_post->listpost(0, 'publish', $this->limit);
      // display in view
      $this->twig->display('template/index', $this->data);
      	
     }
    
    public function page($page = 0)
    {
       
       $data['page'] = 'pagination';
       
       $count = $this->blog_post->count('','publish');
       
       $offset = (int) $page;
       
       $current_page = ($offset > 1 ) ? ($offset*$this->limit)-$this->limit: '0';
       
       $ceil = ceil($count/$this->limit);
       
       if ($current_page > $ceil)
       {
          $current_page = ($ceil*$this->limit)-$this->limit;
          
       }
    
       $data['post'] = $this->blog_post->listpost($current_page, 'publish', $this->limit);
       
       $data['pagination'] = $this->link_pagination(base_url('article/page'), $count);
      
      // display in view
      $this->twig->display('template/index', $data);
      
    }
    
    // tampilkan detail post
    public function view()
    {
       $uri = uri_string();
       
       $detail = $this->blog_post->postdetail($uri, "publish");
       if (!$this->user->logged()) {
       // Update Hits
       $this->db->where('id', $detail['id']);
       $this->db->set(['hits' => $detail['hits']+1]);
       $this->db->update('blog_post');
       }
       // Validasi Ketersediaan Artikel
       if ($detail == NULL)
       {
          show_404();
       }
       else
       {
          $data['post'] = $detail;
          // related post
          $this->db->where('status', 1);
          $result = $this->db->get('blog_post')->result_array();
          foreach ($result as $related)
          { 
          $sim = similar_text($detail['title'], $related['title'], $percent);
          if ($percent > 40)
          {
             if ($related['title'] == $detail['title']){ 
                continue;
             }
              $listRelated[] = $related; 
          }
          }
          // jika artikel terkait ada
          if (is_array($listRelated))
          {
            // batasi limit
             $listArray = (count($listRelated) > 8 ) ? array_slice($listRelated, 0, 8) : $listRelated;
             foreach ($listArray as $listPost)
             {
                $dataPost['title'] = $listPost['title'];
                
                $dataPost['permalink'] = $this->blog_post->permalink($listPost['id']);
                
                $dataPost['summary'] = $this->blog_post->summary($listPost['content']);
                
                $dataPost['thumbnail'] = $this->blog_post->thumbnail($listPost['content']);
                
                $dataPost['date'] = $listPost['update'];
            
                $contentRelated[] = $dataPost;
                }
                
                $data['relatedPost'] = $contentRelated;
                
          }
          else
          {
             $data['relatedPost'] = "";
          }
          
          $data['page'] = 'view-post';
         // meta tag 
          $data['title'] = $detail['title'];
          
          $data['description'] = $detail['summary'];
          
          $this->twig->display('template/post-single', $data);
          
       }
       
    }
    
    private function link_pagination($url, $count){
  
  // konfigurasi pagination
    $config['base_url'] = $url;
    
    $config['total_rows'] = $count;
    
    $config['per_page'] = $this->limit;
    
    $config['use_page_numbers'] = TRUE;
    
    $config['uri_segment'] = 3;
    
  // konfigurasi tampilan menggunakan bootstrap 4
    $config['attributes']['rel'] = FALSE;
    $config['full_tag_open'] = '<div class="my-3">
 <nav aria-label="Pagination"> <ul class="pagination pagination-sm">';
    $config['full_tag_close'] 	= '</ul></nav></div>';
    $config['num_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close'] 	= '</span></li>';
    $config['cur_tag_open'] 	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] 	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['next_tag_close'] 	= '<span aria-hidden="true"></span></span></li>';
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
        
     }
  
   }