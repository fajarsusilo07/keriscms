<?php defined('BASEPATH') OR exit('access denied !');

/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.1
  * @file Api_theme
  *
  * Class Menangani request dari ajax untuk template Editor
  **/
  
  class Api_theme extends CI_Controller
  {
     // Lokasi path file file template berada
     private $theme_path = VIEWPATH.'template/'; // @string
     
     // Lokasi path file css berada
     private $css_path = FCPATH.'asset/css/style.css';  // @string
     
     // @constructor
     public function __construct()
     {
        // call method __construct on parent
        parent::__construct();
        
        // mencegah request bukan dari ajax atau user yang tidak login mengakses halaman ini
        if (!$this->input->is_ajax_request() OR (!$this->user->logged()))
        {
           show_404();
        }
        
     }
     // param part @string, default param part index
     // ambil data file template sesuai dengan part
     public function getpart()
     {
        
        $part = $this->input->get('part', TRUE);
        $file = explode('.', $part);
        
        if (strtolower($file[1]) == 'html')
        {
           if (file_exists($content = $this->theme_path.$part))
           {
              $return = @file_get_contents($content);
             
              // output
              echo json_encode(['status' => 'success', 'content' => $return]);
              exit;
              
           }
           else
           {
              echo json_encode(['status' => 'failure', 'content' => '']);
              exit;
           }
     
      }
      else if (strtolower($file[1]) == "css")
      {
         $return = @file_get_contents($this->css_path);
         
         echo json_encode(['status' => 'success', 'content' => $return]);
         exit;
      }
      else
      {
         echo json_encode(['status' => 'failure', 'content' => '']);
         exit;
      }
    }
    
    public function save()
    {
       $part = $this->input->get('part', TRUE);
       $replace = $this->input->post('content');
       
       $file = explode('.', $part);
       
       if ($file[1] == "html")
       {
          if (file_exists($template = $this->theme_path.$part))
          {
             file_put_contents($template, $replace);
             echo json_encode(['status' => 'success']);
             exit;
          }
          else
          {
             echo json_encode(['status' => 'failure']);
             exit;
          }
       }
       else if ($file[1] == "css")
       {
          file_put_contents($this->css_path, $replace);
          echo json_encode(['status' => 'success']);
       }
       else
       {
          echo json_encode(['status' => 'failure']);
          exit;
       }
     }
     
  public function upload()
  {
     // load library upload
     $this->load->library(array('upload', 'themes'));
     
     // configuration upload theme
     $config['upload_path'] = FCPATH.'backup';
     $config['allowed_types'] = "zip";
     $config['file_ext_tolower'] = TRUE;
     $config['max_size'] = 2048;
     $config['max_filename'] = 32;
     $config['encrypt_name'] = TRUE;
     $this->upload->initialize($config);
     
     if ($this->upload->do_upload('upload'))
     {
        $this->themes->zip_name($this->upload->data('full_path'));
        
        if ($this->themes->theme_switch())
         { 
            $response = array('status' => 'success', 'message' => '');
            echo json_encode($response);
            exit;
         }
         else
         {
            $response = array('status' => 'failure', 'message' => 'Template tidak valid !');
            echo json_encode($response);
            exit;
         }
     }
     else
     {
        $response = array('status' => 'failure', 'message' => $this->upload->display_errors('',''));
        echo json_encode($response);
        exit;
     }
     
  }
  }
  