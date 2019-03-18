<?php defined("BASEPATH") OR exit("access denied !");
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Search CI_Controller
 */

  class Search extends CI_Controller 
  {
     
     private $limit; // limit
     
     public function __construct()
     {
        parent::__construct();
        
        $this->load->model(array('blog_post', 'blog_setting'));
        
        $this->load->library(array('pagination'));
        
        $this->load->helper('security');
        
        // tentukan limit
        $this->limit = $this->blog_setting->get_setting()['post_limit'];
     }
     
     public function index()
     {
        
        // keyword
        $keyword = xss_clean($this->input->get('q'));
        
        // count search
        $count = $this->blog_post->count($keyword, "publish");
        
        // pagination
        $data['pagination'] = $this->pagination_search($count, $keyword);
        
        // list search 
        $article = $this->blog_post->searchpost(0, "publish", $keyword, $this->limit);
       
       // pencarian tidak di temukan
       if (empty($article))
       {
          $data['post'] = "";
       }
       else
       {
          $data['post'] = $article;
       }
       
        $data['count'] = $this->blog_post->count($keyword, 'publish');
        
        $data['page'] = "search";
        
        $data['keyword_search'] = $keyword;
        
        $this->twig->display('template/search-post', $data);
        
     }
     
     
     public function page($page = 0)
     {
        
        // keyword Search
        $keyword = xss_clean($this->input->get('q'));
        
        // Halaman aktif
        $offset = (int) $page;
        
        // Jumlah hasil pencarian
        $data['count'] = $this->blog_post->count($keyword, 'publish');
        
        $ceil  =  ceil($data['count']/$this->limit);
        
        // Posisi Halaman
        $start = ($offset > 1) ? ($offset*$this->limit)-$this->limit: '0';
        
        if ($start > $ceil)
        {
           $start = ($ceil*$this->limit)-$this->limit;
           
        }
        // list post
        $article = $this->blog_post->searchpost($start, "publish", $keyword, $this->limit);
        
        if (empty($article) OR (empty($keyword)))
        {
           $data['post'] = "";
        }
        else
        {
           // list post
           $data['post'] = $article;
        }
           
           // pagination
           $data['pagination'] = $this->pagination_search($data['count'], $keyword);
           // keyword search
           $data['keyword_search'] = $keyword;
           // page
           $data['page'] = 'pagination';
           
           $this->twig->display('template/search-post', $data);
           
        
     }
     
     private function pagination_search($count, $search)
     {
    
    $config['base_url'] = base_url('search/page');
    $config['total_rows'] = $count;
    $config['per_page'] = $this->limit;
    $config['use_page_numbers'] = TRUE;
    $config['uri_segment'] = 3;
    $config['suffix'] = "?q={$search}";
    $config['attributes']['rel'] = FALSE;
    $config['full_tag_open'] = '<div class="my-3">
 <nav> <ul class="pagination">';
    $config['full_tag_close'] 	= '</ul></nav></div>';
    $config['num_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close'] 	= '</span></li>';
    $config['cur_tag_open'] 	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] 	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open'] 	= '<li class="page-item"><span class="page-link">';
    $config['next_tag_close'] 	= '<span aria-hidden="true"> &raquo;</span></span></li>';
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