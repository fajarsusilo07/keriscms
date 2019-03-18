<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author Fajar Susilo
  * @email <silophp@gmail.com>
  * @since 1.4 
  * @files Themes (Library)
  */
  class Themes
  {
     
     // list file
     private $part;
     // theme backup filename
     private $backup_name = FCPATH.'backup/theme.zip';
     // theme name
     private $_theme_uploaded;
     // extract To
     private $_path_extract = VIEWPATH.'template/';
     
     public function __construct()
     {
        $this->CI = & get_instance();
        $this->CI->load->helper('download');
     
        // list structur template
        $this->part = [
               'index.html' => VIEWPATH.'template/index.html',
               'header.html' => VIEWPATH.'template/header.html',
               'footer.html' => VIEWPATH.'template/footer.html',
               'pages.html' => VIEWPATH.'template/pages.html',
               'post-single.html' => VIEWPATH.'template/post-single.html',
               'search-post.html' => VIEWPATH.'template/search-post.html',
               'post-category.html' => VIEWPATH.'template/post-category.html',
               '404.html' => VIEWPATH.'template/404.html',
               'style.css' => FCPATH.'asset/css/style.css'
               ];
     }
     
     public function backup_themes()
     {
        $zip = new ZipArchive;
        
        if ($zip->open($this->backup_name, ZipArchive::CREATE|ZipArchive::OVERWRITE))
        {
        
        foreach ($this->part as $structur  => $file)
        {
           if (file_exists($file))
           {
              
              $zip->addFromString($structur, @file_get_contents($file));
              
           }
        }
        
        $zip->close();
        $this->get_download();
     }
     else
     {
        return FALSE;
     }
  }
  
  // dowload file
  private function get_download()
  {
    
     if (file_exists(FCPATH.'backup/theme.zip'))
     {
        force_download('theme.zip', @file_get_contents(FCPATH.'backup/theme.zip'));
        
        return TRUE;
     }
     else
     {
        return FALSE;
     }
   
    }
  
  // get full path zip theme name 
  public function zip_name($full_path)
  {
     $this->_theme_uploaded = $full_path;
  }
  
  // switch theme
  public function theme_switch()
  {
     $list = ['index.html', 'header.html', 'footer.html', 'search-post.html', 'post-single.html', 'post-category.html', 'pages.html', '404.html', 'styles.css'];
     
     $zip = new ZipArchive;
     
     if ($zip->open($this->_theme_uploaded))
     {
        for ($i = 0; $i < $zip->numFiles; $i++)
        {
           if (in_array($zip->getNameIndex($i), $list))
           {
              $extract = $zip->extractTo($this->_path_extract);
              
              return ($extract === TRUE) ? unlink($this->_theme_uploaded) : FALSE;
           }
           else
           {
              return FALSE;
           }
        }
     }
     else
     {
        return FALSE;
     }
     
     $zip->close();
  }
  
}