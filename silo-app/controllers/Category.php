<?php defined("BASEPATH") OR exit('Access denied !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files Category 
 */
 class Category extends CI_Controller {
    
    private $limit;  // limit
    
    public function __construct()
    {
       parent::__construct();
       
       $this->load->model(['blog_post', 'blog_category', 'blog_setting']);
       
       $this->load->helper('security');
       
       $this->load->library('pagination');
       
       $this->limit = $this->blog_setting->get_setting()['post_limit'];
       
    }
    
    public function search($permalink = NULL)
    {
       // Ambil permalink kategori
       $slug = xss_clean($permalink);
       
       // Ambil id kategori
       $category = $this->blog_category->slug_to_id($slug);
       
       if (empty($category) OR ($category == NULL))
       {
          show_404();
       }
       else
       {
          $data['page'] = 'category';
          
          $data['post'] = $this->blog_post->listpost_category(0, $category, $this->limit);
          
          $data['count'] = $this->count($category);
          
          $data['category_name'] = $this->category_name($category);
          
          $data['pagination'] = $this->pagination_category($data['count'], $slug);
          
          $this->twig->display('template/post-category', $data);
          
          
       }
       
    }
    
    public function page($permalink = 0, $page = 0)
    {
       // Ambil permalink kategori
       $slug = xss_clean($permalink);
       // Ambil id kategori
       $id = $this->blog_category->slug_to_id($slug);
       
       if (empty($id) OR ($id == NULL))
       {
          show_404();
       }
       else
       {
          
          $data['count'] = $this->count($id);
          
          $offset = (int) $page;
          
          $ceil = ceil($data['count']/$this->limit);
          
          $start = ($offset > 1) ? ($offset*$this->limit)-$this->limit: '0';
          
          if ($start > $ceil)
          {
             $start = ($ceil*$this->limit)-$this->limit;
          }
          
          $data['page'] = 'pagination';
          
          $data['post'] = $this->blog_post->listpost_category($start, $id, $this->limit);
          
          $data['category_name'] = $this->category_name($id);
          
          $data['pagination'] = $this->pagination_category($data['count'], $slug);
          
          $this->twig->display('template/post-category', $data);
          
    }
    
    }
    
    private function count($id)
    {
       $this->db->like('category', $id);
       
       $count = $this->db->get('blog_post');
       
       return $count->num_rows();
    }
    
    private function category_name($id)
    {
       $this->db->where('id', $id);
       
       $this->db->select('name');
       
       $row = $this->db->get('blog_category');
       
       return $row->row_array()['name'];
       
    }
      private function pagination_category($count, $slug)
      {
         // konfigurasi pagination
    $config['base_url'] = base_url("category/page/{$slug}");
    
    $config['total_rows'] = $count;
    
    $config['per_page'] = $this->limit;
    
    $config['use_page_numbers'] = TRUE;
    
    $config['uri_segment'] = 4;
       
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