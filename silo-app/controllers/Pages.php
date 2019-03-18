<?php defined("BASEPATH") OR exit('Access denied !');

 class Pages extends CI_Controller {
    
    public function __construct()
    {
       parent::__construct();
       
       $this->load->model('blog_pages');
       $this->load->helper('security');
    }
    
    public function view($url = NULL)
    {
       $permalink = xss_clean($url);
       
       $detail = $this->blog_pages->view($permalink);
       
       if ($detail == NULL)
       {
           show_404();
       }
       else
       {
          $data['page'] = "view-page";
          
          $data['pages']['name'] = $detail['name'];
          
          $summary = strip_tags($detail['content']);
          
          $data['pages']['summary'] = substr($summary, 0, 130);
          
          $data['pages']['content'] = $detail['content'];
          
          $this->twig->display('template/pages', $data);
          
       }
    }
 }