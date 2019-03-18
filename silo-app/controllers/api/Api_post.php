<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author Fajar Susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files Api_post
 */
 class Api_post extends CI_Controller 
 {
    
    private $rule, $rule2;
    
    public function __construct()
    {
       
       parent::__construct();
       
       $this->load->model(array('blog_post','blog_setting'));
       $this->load->library(array('form_validation','pagination'));
       
       $this->load->helper('security');
         
       // jika request bukan AJAX atau user tidak dalam posisi login
       // tampilkan show_404
     if ((!$this->input->is_ajax_request()) OR (!$this->user->logged()))
      {
       show_404();
      }  
       
       $this->rule = [ 
                          
                          ['field' => 'title',
                          'label' => 'Judul',
                          'rules' => 'strip_tags|required|max_length[160]|is_unique[blog_post.title]'],
                          ['field' => 'content',
                          'label' => 'Konten',
                          'rules' => 'required'],
                          ['field' => 'permalink',
                          'label' => 'Permalink',
                          'rules' => 'strip_tags|required|max_length[160]|is_unique[blog_post.permalink]'],
                          ['field' => 'label[]',
                          'label' => 'Kategori',
                          'rules' => 'required']
                              ];
                              
       $this->rule2 = [  
                       ['field' => 'title',
                       'label' => 'Judul',
                       'rules' => 'strip_tags|required|max_length[160]'],
                       ['field' => 'slug',
                       'label' =>  'Permalink',
                       'rules' => 'strip_tags|required|max_length[160]'],
                       ['field' => 'content',
                       'label' => 'Konten',
                       'rules' => 'required'],
                       ['field' => 'label[]',
                       'label' => 'Kategori',
                       'rules' => 'required']
                ];
       
    }
    
     public function create()
     {
      $this->form_validation->set_message('is_unique',' %s tidak tersedia.');
      
      $this->form_validation->set_error_delimiters("","");  // hapus tag "<p>"
      
      $this->form_validation->set_rules($this->rule);
      
      if ($this->form_validation->run()){
          
          $title = $this->input->post('title', TRUE); // Judul artikel
          
          $permalink = strtolower(url_title($this->input->post('permalink', TRUE),'dash')); // Permalink artikel
          $content = $this->_filter_content($this->input->post('content'));  // konten artikel
          
          $category = implode(',',$this->input->post('label')); // category satukan array menjadi string
          $status = ($this->input->post('status') == 1) ? '1' :0;  // status artikel
          $post_by = $this->user->user_id();
          $date = waktu();  // tanggal 
          $update = waktu();  // perbaharui tanggal
          $content2 = ($this->input->post('nl2br') == 1) ? nl2br($content) :$content;    
          $insert = ['title' => $title, 'permalink' => $permalink, 'content' => $content2, 'category' => $category, 'status' => $status, 'date' => $date, 'update' => $update,'hits' => 0, 'post_by' => $post_by];
          
           if ($this->blog_post->insert($insert)){
             
             echo json_encode(['status' => 'success', 'message' => ['title' => '', 'permalink' => '', 'content' => '','category' => '']]);
             exit;
             
         }
            else
                  {
                     
                   echo json_encode(['status' => 'failure', 'message' => ['title' => '', 'permalink' => '', 'content' => '','category' => '']]);
             exit;
               
            }
          
         }
            
            else   
            
                 {
                    $message['title'] = form_error('title'); // pesan error untuk  Judul artikel
                    $message['permalink'] = form_error('permalink'); // pesan error untuk permalink artikel
                    $message['content'] = form_error('content'); // pesan error untuk konten artikel
                    $message['category'] = form_error('label[]'); // pesan error untuk category
                 
                    echo json_encode(['status' => 'validate', 'message' => ['title' => $message['title'], 'permalink' => $message['permalink'], 'content' => $message['content'], 'category' => $message['category']]]);
                    
             exit;
             
        }             
            
    }
    
    private function _filter_content($content){
       
       // hapus tag head jika ada
       $rule = ['#<head>#is','#</head>#is','#<!doctype html>/is#'];
       $replace = ['','',''];
       
       return preg_replace($rule,$replace,$content);
       
       
    }
    
    
    public function datapost($page = 1){
       
       $limit = 10;  // tentukan limit
       
       $offset = (int) $page;   // no halaman
       $start_position = ($offset > 1 ) ? ($offset*$limit)-$limit : 0;  // mulai halaman dari
       
       $search = xss_clean($this->input->get('q'));   // keyword pencarian
       
       $status = ($this->input->get('u') == 'draft') ? 'draft' : 'publish';  // status post
       
       $count = $this->blog_post->count($search, $status);  // jumlah postingan
       
      if (empty($search)){
          
       $list = $this->blog_post->listpost($start_position, $status);
       
       $pagination = $this->pagination_post($count, $status);  // pagination
      
      }
         
         else
         
               {
                  
                  $list = $this->blog_post->searchpost($start_position, $status, $search);
                  
                  $pagination = $this->pagination_post($count, $status, $search);
                  
               }
      
       $data = ['count' => $count, 'list' => $list, 'pagination' => $pagination];
       
     //  print_r($count); exit;
       $this->load->view('admin/post/postresult', $data);
       
    }
    
    private function pagination_post($count = 0, $u = "publish", $search = ""){

   // konfigurasi pagination
    $keyword = (!empty($search)) ? $search : "";
    $status = ($u == "draft") ? 'draft' : 'publish';
    $config['base_url'] = '/api/api_post/datapost';
    $config['total_rows'] = $count;
    $config['per_page'] = 10;
    $config['use_page_numbers'] = TRUE;
    $config['uri_segment'] = 4;
  
    // styling pagination dengan bootstrap
    $method = "return getPost($(this).attr('href'),'$keyword','$status')";  // method onclick javascript
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
       exit;
    }
    
    
    public function  delete() {
       
       $id = $this->input->post('id', TRUE);
      if ($this->blog_post->delete($id))
       {
          
          echo json_encode(['status' => 'success']);
          exit;
          
       }
 else
       {
          
          echo json_encode(['status' => 'failure']);
          exit;
          
       }
      
     }
     
     public function edit()
     {
        // hilangkan karakter "p"
        $this->form_validation->set_error_delimiters("","");
        // pengaturan validasi form_validation
        $this->form_validation->set_rules($this->rule2);
        
        if ($this->form_validation->run())
        {
        // id artikel 
        $id = (int) $this->input->post('id');
        $result = $this->db->where('id', $id)
                           ->get('blog_post')
                           ->row_array();
                            //print_r($result); exit;

        // judul artikel baru
        $title = $this->input->post('title', TRUE);
        // konversi ke huruf kecil untuk permalink atau slug
        $permalink = strtolower($this->input->post('slug', TRUE));
        // konversi menjadi url seo frendly
        $slug = url_title($permalink, 'dash');
        // konten artikel baru.
        $content = $this->_filter_content($this->input->post('content'));
        // baris baru otomatis
        $nl2br = ($this->input->post('nl2br') == 1) ? nl2br($content) : $content;
        // konversi array menjadi string untuk category
        $category = implode(',', $this->input->post('label'));
        // update tanggal artikel
        $now = waktu();  // waktu sekarang
        $update = ($this->input->post('update') == 1) ? $now : $result['date'];
        // status artikel
        $status = ($this->input->post('status') == 1) ? '1' : '0';
        
        // uodate data
        $post_update = [
              'title' => $title,
              'permalink' => $slug,
              'content' => $nl2br,
              'category' => $category,
              'update' => $update,
              'status' => $status
                 ];
        
        // periksa ketersedian judul artikel                
        if ($this->blog_post->is_unique('title', $result['title'], $title) == TRUE) 
        {
           echo json_encode(['status' => 'validate', 'message' => ['title' => 'Judul Artikel tidak tersedia atau sudah di gunakan', 'slug' => '', 'content' => '', 'category' => '']]);
           exit;
        } 
        // periksa ketersedian permalink atau slug artikel
        elseif ($this->blog_post->is_unique('slug', $result['permalink'], $slug) == TRUE)
        {
           echo json_encode(['status' => 'validate', 'message' => ['title' => '', 'slug' => 'Permalink tidak tersedia atau sudah di gunakan.', 'content', 'category']]);
           exit;
        }
        else
        {  // update data
           if ($this->blog_post->update($id, $post_update))
           {
              echo json_encode(['status' => 'success', 'message' => ['title' => '', 'slug' => '', 'content' => '', 'category' => '']]);
              exit;
           }
           else
           {  
              echo json_encode(['status' => 'failure', 'message' => ['title' => '', 'slug' => '', 'content' => '', 'category' => '']]);
              exit;
           }
        }
     }
     else
     {
        echo json_encode(['status' => 'validate', 'message' => ['title' => form_error('title'), 'slug' => form_error('slug'), 'content' => form_error('content'), 'category' => form_error('label[]')]]);
        exit;
     }
     }
   
  }