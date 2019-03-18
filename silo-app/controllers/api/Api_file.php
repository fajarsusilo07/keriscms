<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files Api_file 
 **/
 class Api_file extends CI_Controller { 
 
     private $rule = [];
    
     public function __construct(){
        
        parent::__construct();
        
        $this->load->library(array('upload','form_validation','pagination'));
        
        $this->load->helper('security');
        
        $this->load->model('blog_files');
        
       if ((!$this->input->is_ajax_request()) OR (!$this->user->logged())){
           
           show_404(); // halaman 404
           
        } 
       
       $this->rule = [
          [
           'field' => 'filename',
           'label' => 'Nama berkas',
           'rules' => 'strip_tags|required|max_length[32]|alpha_dash'
          ]];
       
     }
     
        public function content($offset = 1){
        
        $search = xss_clean($this->input->get('q')); // pencarian
        $page = (int) $offset;
        $current = ($page > 1) ? ($page*10)-10 :0; // halaman aktif
   
          if (empty($search)){
             
            $file = $this->blog_files->listfile($current);  // list file
           $count = $this->blog_files->count(); // total semua file
           $pageItem = $this->paging($count); 
          
               
        }
           else   
                 {
             
             $file = $this->blog_files->listfile($current, $search);   // list file hasil pencarian
             $count = $this->blog_files->count($search);  // total file hasil pencarian
             $pageItem = $this->paging($count,$search); 
              
           }
    $title = strtoupper(CMS_NAME.' - File'); // judul halaman
    $data = [
        'title' => $title,
        'file' => $file,
        'count' => $count,
        'pagination' => $pageItem];
        $this->load->view('admin/upload/result',$data);
        
        
     }
     
     private function paging($count,$q = ""){
   
 // konfigurasi pagination
    $config['base_url'] = '/api/api_file/content';
    $config['total_rows'] = $count;
    $config['per_page'] = 10;
    $config['use_page_numbers'] = TRUE;
    $config['uri_segment'] = 4;
  // konfigurasi tampilan menggunakan bootstrap 4
    $method = "return getFile($(this).attr('href'),'$q')";  // method onclick javascript
    
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
     
    public function upload(){
    // konfigurasi upload file
    $config = [
            'upload_path' => './file/', 
            'max_size' => 51200,  // 50 MB
            'allowed_types' => 'png|jpg|gif|jpeg|bmp|mp3|apk|mp4|3gp|pdf|docx|doc|xls|odt|odf',
            'file_ext_tolower' => TRUE,
            'max_filename' => 32,
            'max_filename_increment' => 0
          ];
          
          $this->upload->initialize($config);
          
          if ($this->upload->do_upload('userfile')){
             
             $file_name = $this->upload->data('file_name'); // nama file dengan ekstensi
             $file_size = $this->upload->data('file_size'); // ukuran file dalam satuan Kilo Byte (KB)
             $file_type = $this->upload->data('file_type');  // jenis file
             $file_date = waktu(); // waktu unggah file
          
             if ($this->blog_files->add(['filename' => $file_name, 'filetype' => $file_type, 'date' => $file_date, 'size' => $file_size])){
                
                echo json_encode(array('status' => 'success','message' => 'berkas berhasil di unggah.'));
                exit;
             }  
                else 
                       {
                          
                          echo json_encode(array('status' => 'failure','message' => 'Terjadi kesalahan saat memproses data'));
                          exit;
                          
                       }
             
          }
          
            else
            
                 {
               
               $message = $this->upload->display_errors("","");
               echo json_encode(array('status' => 'failure','message' => $message));
               
               exit;
         }
        
     }
     
     public function delete(){
        
      $file_id = (int) $this->input->post('id'); // id files
      $path = FCPATH.'file/';
       
        if ($this->blog_files->isfile($file_id)){
           
           $file = $this->blog_files->isfile($file_id);
       
           if ($this->blog_files->delete($file_id)){
              
              unlink($path.$file['filename']); // unlink file
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
      
      public function rename(){
         
        $file_id = (int) $this->input->post('id'); // id file
       
        $this->form_validation->set_error_delimiters("","");  // hapus tag "<p>"
        $this->form_validation->set_rules($this->rule);
        
       if ($this->form_validation->run() == TRUE){
            
         if ($this->blog_files->isfile($file_id)){    // cek ketersediaan data pada database
            
            $file = $this->blog_files->isfile($file_id);  // tampilan informasi file berdasarkan id
            
            $original = $file['filename']; // original nama file
            $ext = explode('.', $original);  // jenis file
            $extension = $ext[1];
            
            $newfilename = $this->_filter_filename($this->input->post('filename'));  // nama file baru 
         
            $isfile = FCPATH.'file/';
            
            if ((!file_exists($isfile.$newfilename.'.'.$extension)) && ($original != $newfilename.'.'.$extension)){  // jika file dengan nama baru tersedia
               
               if (rename($isfile.$original,$isfile.$newfilename.'.'.$extension)){   // rename file
                  
                  if ($this->blog_files->update(['filename' => $newfilename.'.'.$extension], $file_id)){
                     
                     // update filename pada database
                     echo json_encode(['status' => 'success', 'message' => '']);
                     exit;
                     
                     
                  }
                    else 
                        {  // jika terjadi gagal saat melakukan query
                     rename($isfile.$newfilename.'.'.$extension,$isfile.$original);  // rename file seperti semula
                     echo json_encode(['status' => 'failure','message' => 'Terjadi kesalahan saat memproses data.']);
                     exit;
                       
                       
                    }
                    
                  
               }
               
               else {  // jika terjadi kesalahan saat rename files
               echo json_encode(['status' => 'failure', 'message' => 'Terjadi kesalahan saat memproses data.']);
               exit;
                  
                  
               }
               
            }
            
             else  {
                
                echo json_encode(['status' => 'failure', 'message' => 'Nama berkas sudah ada.']);
                exit;
                
             } 
            
         } 
         
          else {
             
             echo json_encode(['status' => 'failure', 'message' => 'Berkas tidak di temukan.']);
             exit;
             
          }
          
         }
         
            else
                  {
                 
                 echo json_encode(['status' => 'failure', 'message' => form_error('filename')]);
                 
          }
       
      }
      
      private function _filter_filename($filename){
         
         $newfilename = xss_clean($filename);  // xss clean
         $newfilename2 = str_replace('.','_',$newfilename);  // ganti karakter (dot) menjadi underscore
         
         return strtolower($newfilename2);
         
      }
      
   }