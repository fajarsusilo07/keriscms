<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @sice 1.0
  * @files Content
  */
 class Content extends CI_Controller 
 {
    
    public function __construct()
    {
       parent::__construct();
       $this->load->helper('download');
    }
    
    public function download($filename = NULL)
    {
       $path = FCPATH.'file/';
       $filepath = file_get_contents($path.$filename);
       if (file_exists($path.$filename))
       {
          
          force_download($filename, $filepath);
       }
       else
       {
          show_404();
       }
    }
 }