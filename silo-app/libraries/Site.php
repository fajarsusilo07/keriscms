<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @files Site (Library)
 **/
   class Site {
      
      private $CI;
      
      public function __construct(){
         
         $this->CI = & get_instance(); // instance semua class system codeigniter
         $this->CI->load->model('blog_post');
         
      }
      
  // tampilkan informasi situs
   public function site($switch=""){
         
         switch ($switch){
            
            case 'title':
            
            return $this->site_title();
            
            break;
            
            case 'description':
            
            return $this->site_description();
            
            break;
            
            case 'keywords':
            
            return $this->site_keyword();
            
            break;
            
            case 'meta_tag':
            
            return $this->site_meta_tag();
            
            break;
            
            case 'author':
            
            return $this->site_author();
            
            break;
            
            default;
            
            log_message('info','parameter tidak ada yang cocok dengan switch.');
                  
            return;
            
         }
         
      }
      
      private function site_author(){   // tampilkan nama pemilik situs
         
         $this->CI->db->select('username,fullname');
         $this->CI->where('id',1);
         $result = $this->CI->get('blog_user')->row();
         
         if (empty($result->fullname)){
            
             return $result->username;
         }
         
         return $result->fullname;
         
      }
      
      private function site_title(){  // tampilkan nama situs
         
         $this->CI->db->select('title');
         $result = $this->CI->db->get('blog_setting')->row();
         
         return $result->title; 
               
      }
      
      private function site_description(){   // tampilkan description situs
         
         $this->CI->db->select('description');
         $result = $this->CI->db->get('blog_setting')->row();
         
         return $result->description;
      }
      
    private function site_keyword(){  // tampilkan keyword situs
       
       $this->CI->db->select('keyword');
       $result = $this->CI->db->get('blog_setting')->row();
       
       return $result->keyword;
    }
    
    private function site_meta_tag(){  // tampilkan meta_tag html
       
       return $this->CI->blog_setting->get_setting()['meta_tag'];
       
   }
  
 }