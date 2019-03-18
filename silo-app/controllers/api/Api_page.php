<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Api_page (Controller)
  */
  
  class Api_page extends CI_Controller {
     
     private $rule = array();  // rule untuk tambah halaman
     private $rule2 = array();  // rule untuk edit halaman
     
     public function __construct(){
        
        parent::__construct();
        
        $this->load->library(array('form_validation', 'pagination'));  // form_validation library
        $this->load->helper('security');
        $this->load->model('blog_pages'); // model blog_pages
        
        if ((!$this->input->is_ajax_request()) OR (!$this->user->logged())){
           
           show_404();
          
       }
       
      $this->rule = array(
             array('field' => 'name',
              'label' => 'Nama Halaman',
              'rules' => 'strip_tags|required|max_length[32]|is_unique[blog_pages.name]'),
              array('field' => 'permalink',
               'label' => 'Permalink',
               'rules' => 'strip_tags|required|alpha_dash|is_unique[blog_pages.permalink]|max_length[32]'),
               array('field' => 'content',
               'label' => 'Konten',
               'rules' => 'required|max_length[5000]')
            );
            
            $this->rule2 = array(
                   array(
                   'field' => 'name',
                   'label' => 'Nama Halaman',
                   'rules' => 'strip_tags|required|max_length[32]',
                    ),
                   array(
                    'field' => 'permalink',
                    'label' => 'Permalink',
                    'rules' => 'required|max_length[32]'
                    ),
                    array(
                    'field' => 'content',
                    'label' => 'Konten',
                    'rules' => 'required|max_length[5000]')
                  );
     }
     
     public function content($page = 1){
        
        $offset = ($page > 1) ? ($page*10)-10 : 0;   // posisi halaman
        
        $keyword = (!empty($this->input->get('q'))) ? (xss_clean($this->input->get('q'))) : "";  // kata kunci pencarian
       
        $count = $this->blog_pages->count($keyword);
        $countAll = $this->blog_pages->count("");
        
        $data = [
            'page' => $this->blog_pages->listpage($offset, $keyword), 
            'pagination' => $this->pagination_page($count, $keyword),
            'count' => $count,
            'countAll' => $countAll];
        
        $this->load->view('admin/pages/resultpage', $data);
        
     }
     
     private function pagination_page($count = 0, $q = ""){
    
    $keyword = (!empty($q)) ? $q : "";
   // konfigurasi pagination
    $config['base_url'] = '/api/api_page/content';
    $config['total_rows'] = $count;
    $config['per_page'] = 10;
    $config['use_page_numbers'] = TRUE;
    $config['uri_segment'] = 4;
  // konfigurasi tampilan menggunakan bootstrap 4
    $method = "return getPage($(this).attr('href'),'$keyword')";  // method onclick javascript
    
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
        
     }
     
     public function create(){
        
        $this->form_validation->set_error_delimiters("","");
        
        $this->form_validation->set_rules($this->rule);
        
        $this->form_validation->set_message('is_unique','%s tidak tersedia atau sudah di gunakan');
        
        $this->form_validation->set_message('regex_match','%s tidak valid');
        
    if ($this->form_validation->run()){
       
        $name = xss_clean($this->input->post('name'));
        $url = strtolower($this->input->post('permalink'));
        $permalink = url_title($url, 'dash', TRUE);
        $text = $this->input->post('content');
        $content = $this->_sanitaze($text);
         
        $data = ['name' => $name, 'permalink' => $permalink, 'content' => $content];
        
        if ($this->blog_pages->insert($data)){
           
           echo json_encode(['status' => 'success', 'message' => []]);
           exit;
            
        }
           else  
                 {
                    
                    echo json_encode(['status' => 'failure', 'message' => 'Terjadi kesalahan saat memproses data.']);
                    exit;
                    
                 }
        
       }
         else 
              {
          
               $message['name'] = form_error('name');
               $message['permalink'] = form_error('permalink');
               $message['content'] = form_error('content');
               
               echo json_encode(['status' => 'validate', 'message' => ['name' => $message['name'], 'permalink' => $message['permalink'], 'content' => $message['content']]]);
               exit;
          
       }
     }
     
     public function edit()
     {
      // id halaman
      $id = (int) $this->input->post('id');
      // detail halaman
      $detail = $this->blog_pages->detail($id); 
      // hilangkan tag "p"
      $this->form_validation->set_error_delimiters("","");
      // Setting rule
      $this->form_validation->set_rules($this->rule2);
        // start validasi
        if ($this->form_validation->run())
        {
       
        if ($detail != NULL){
           
           // nama halaman baru
           $name = xss_clean($this->input->post('name')); 
           // permalink ke huruf kecil
           $permalink = strtolower($this->input->post('permalink'));
           // slug
           $slug = url_title($permalink, 'dash');
           // konten halaman
           $text = $this->input->post('content');
           $content = $this->_sanitaze($text); // hapus tag javascript
           // data update page
           $update_page = [
                   'name' => $name,
                   'permalink' => $slug,
                   'content' => $content];
                   
         // validasi nama halaman
         if ($this->blog_pages->is_unique('name', $name, $detail['name']))
         {
            echo json_encode(['status' => 'validate', 'message' => ['name' => 'Nama halaman tidak tersedia atau sudah di gunakan', 'slug' => '', 'content' => '']]);
            exit;
         }
         // validasi permalink halaman
         else if ($this->blog_pages->is_unique('permalink', $slug, $detail['permalink']))
         {
            echo json_encode(['status' => 'validate', 'message' => ['name' => '', 'slug' => 'Permalink tidak tersedia atau sudah di gunakan', 'content' => '']]);
            exit;
         }
         else 
         {   // update data
             if ($this->blog_pages->update($update_page, $id))
             {
                echo json_encode(['status' => 'success', 'message' => ['name' => '', 'slug' => '', 'content' => '']]);
                exit;
             }
             else
             {
                // gagal update
                echo json_encode(['status' => 'failure', 'message' => ['name' => '', 'slug' => '', 'content' => '']]);
                exit;
             }
           }
         }
         else
         {
            echo json_encode(['status' => 'failure', 'message' => ['name' => '', 'slug' => '', 'content' => '']]);
            exit;
         }
    
        } 
        else 
        {
           $response = ['status' => 'validate', 
           'message' => ['name' => form_error('name'),
            'slug' => form_error('permalink'),
             'content' => form_error('content')]];
             
             echo json_encode($response);
             exit;
        }
       
     }
     
     public function delete(){
        
        $id = $this->input->post('id');
        $found = $this->blog_pages->detail($id);
        
        if ($found == NULL){
            
            echo json_encode(array('status' => 'failure'));
            exit;
             
        }
        
          else  
                {
                   
                   if ($this->blog_pages->delete($id)){
                      
                      echo json_encode(array('status' => 'success'));
                      exit;
                      
                      
                   }
                   
                    else
                           {
                            
                            echo json_encode(array('status' => 'failure'));
                            exit;
            
              }
             
          }
        
     }
     
     
     
     private function _sanitaze($content){
       
        return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
        
     }
      
  }