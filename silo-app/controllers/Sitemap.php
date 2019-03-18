<?php defined('BASEPATH') OR exit('Access denied !');
/*  Generate dinamic sitemap  */
class Sitemap extends CI_Controller {
   
   private $site_url;
   
   public function __construct()
   {
      parent::__construct();
      
      $this->load->model('blog_post');
      
      $this->site_url = "http://www.".str_replace('www.', '', $_SERVER['HTTP_HOST']);
      
   }
   public function index()
   {
      // list sitemap 50
      $list = $this->blog_post->listpost(0, 'publish', 50);
      
        header('Content-type: text/plain; charset="utf-8"', TRUE);
      foreach ($list as $sitemap)
      {
         echo $this->site_url.$sitemap['permalink']."\r\n";
         
      }
   }
}