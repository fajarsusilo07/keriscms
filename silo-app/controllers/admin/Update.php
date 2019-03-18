<?php defined('BASEPATH') OR exit('access denied !');
/**
  * file Update untuk versi 1.0 upgrade ke versi 1.1
  * penghapusan field 'meta_tag', 'mod_comment' pada table 'blog_setting'
  */
 class  Update extends CI_Controller 
 {
    public function __construct()
    {
       parent::__construct();
       
       $this->load->dbforge();
    }
    
    public function index()
    {
       if (!$this->user->logged())
       {
          show_404();
       }
       
       $history = @file_get_contents(FCPATH.'changelog.txt');
       $text = explode('#', $history);
       foreach ($text as $content)
       {
          $data['changelog'] .= '<p>'.$content;
       }
       
       // jika belum di perbaharui
       if ($this->db->field_exists('meta_tag', 'blog_setting') OR ($this->db->field_exists('mod_comment', 'blog_setting')))
       {
          if ($this->input->get('act') == 'upgrade')
          {
             $this->dbforge->drop_column('blog_setting', 'meta_tag');
             $this->dbforge->drop_column('blog_setting', 'mod_comment');
          }
          
          $data['title'] = CMS_NAME.' - Update to 1.1';
          $this->load->view('admin/tools/upgrade', $data);
       }
       else
       {
          $data['title'] = CMS_NAME.' - SiloCMS is upgraded';
          $this->load->view('admin/tools/upgraded', $data);
          
       }     
    }
 }