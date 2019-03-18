<?php defined('BASEPATH') OR exit('access denied');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @file User (Libraries)
**/
class User {
   
   private $CI;
   
   private $img_user_no_set = '/asset/profile/user-photo.png'; // set default avatar if avatar not update
      
    public function __construct(){
       
       $this->CI = & get_instance();
       
       $this->CI->load->model('blog_setting');
       
     }
     
      public function logged(){
        
        $session = $this->CI->session->userdata('login'); // session login
        $key_from_database = $this->key_login(); // key dari database        
       /* setia saat user login maka key login dari database akan di rubah
        * fungsi untuk update key login ada pada class Model "Auth" */
        // cek keberadaan session, jika session kosong
        if (empty($session) OR ($session == NULL)){
            return FALSE;
         }
            else  
                 {
                    
        // pencocokan antara session dan key login dari database
        if ($session == $key_from_database){
           
           return TRUE;
        }
           else  
                 {           
                    
                    $this->CI->session->unset_userdata('login');  // unset session
                   return FALSE;
                }
        
          }
    
    }
  
    protected function key_login(){
       
       $session = $this->CI->session->userdata('login');
       $res = "SELECT login FROM blog_user WHERE login = '$session'";
       $query = $this->CI->db->query($res);
       
         if ($query->num_rows() > 0){
             $key = $query->row_array();
             return $key['login'];
         }
         return NULL;
    }
  
    public function avatar(){   
    
    $photo = $this->CI->blog_setting->get_photo(); // tampilkan photo profile
    
    if($photo == NULL OR $photo == ""){
       
       return $this->img_user_no_set; 
    }
    return '/file/'.$photo;
}
  
    public function fullname(){
     
    $result = $this->CI->blog_setting->get_account();
    
    return $result['fullname'];
   
    }
    
    public function quote(){
       $result = $this->CI->blog_setting->get_account();
    
    return $result['quote'];

    }
    
    public function user_id(){
       
       $session = $this->CI->session->userdata('login');
       $sql = "SELECT id FROM blog_user WHERE login = '$session'";
       $query = $this->CI->db->query($sql);
       $result = $query->row_array();
       return $result['id'];
    }
 }
 