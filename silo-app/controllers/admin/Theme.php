<?php defined('BASEPATH') OR exit('Access denied !');
/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.1 
  * @files Theme
  */
  class Theme extends CI_Controller 
  {
     public function __construct()
     {
        parent::__construct();
        
        $this->load->library('themes');
        
        // mencegah user tidak login akan di tampilkan page not found
        if (!$this->user->logged())
        {
            show_404();
        }
     }
     
     // editor template
     public function editor()
     {
        $data['title'] = CMS_NAME.' - Theme Editor';
        
        // @action for backup theme
        if ($this->input->post('backup') == "backup")
        {
           if ($this->themes->backup_themes() == TRUE)
           {
              
              $backup = TRUE;
           }
           else
           {
              $backup = FALSE;
              
           }
        } 
        
        $data['backup'] = $backup;
        
        $this->load->view('admin/theme/editor', $data);
     }
     
  }