<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @backup Controller 
  */
  class backup extends CI_Controller
  {
     private $message;
     public function __construct()
     {
        parent::__construct();
        
        $this->load->helper('download');
        if (!$this->user->logged())
        {
           show_404();
        }
     }
     // @backup index
     public function index()
     {
        $data['title'] = CMS_NAME.' - Backup ';
        
        $action = strtolower($this->input->post('action', TRUE));
        $backup = $this->input->post('backup', TRUE);
       // print_r($this->input->post()); exit;
       if ($backup == "yes")
       {
          if ($action == "archive")
          {
             if (!$this->backup_file())
             {
                $data['message'] = 'Terjadi kesalahan saat mencadangkan file';
             }
             else
             {
             return $this->save(FCPATH.'backup/backup_file.zip');
             }
          }
          else
          {
             $backup_db = $this->backup_db();
             return force_download('backup_db.zip', $backup_db);
          }
       }
        
        $this->load->view('admin/tools/backup', $data);
     }
     // @function backup file
     private function backup_file()
     {
        $backup_file = FCPATH.'backup/backup_file.zip';
        // @create object
        $zip = new ZipArchive;
        if ($zip->open($backup_file, ZipArchive::CREATE|ZipArchive::OVERWRITE) == TRUE)
        {
           // @get all file
           $glob = FCPATH.'file/*';
           foreach (glob($glob) as $file)
           {
              // @add file
              if (is_file($file) && (basename($file) != 'index.php'))
              {
                 $zip->addFromString(basename($file), @file_get_contents($file));
              }
           }
           return TRUE;
           
        }
        else
        {
           return FALSE;
        }
   
      }
      
  private function backup_db()
  {
     // @load dbutil
     $this->load->dbutil();
     // @CREATE config backup
     $config['tables'] = ['blog_file', 'blog_pages', 'blog_post', 'blog_category'];
     $config['format'] = 'zip';
     $config['filename'] = 'backup_db.sql';
     return $this->dbutil->backup($config);
  }
  private function save($file)
  {
     return (file_exists($file)) ? force_download(basename($file), @file_get_contents($file)) : FALSE;
  }
  
  }