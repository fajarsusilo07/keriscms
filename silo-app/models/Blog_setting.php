<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @file Blog_setting (Model)
 **/
 
 class Blog_setting extends CI_Model {
    
    private $login;  // session login
    
    public function __construct(){
       
       parent::__construct();
       
       $this->login = $this->session->userdata('login'); // set key session login
  
  }
  
   public function get_setting(){
      
  // tampilkan pengaturan situs
   
   $this->db->where('id', 1);
   
   $res = $this->db->get('blog_setting');
   
        $result = $res->row_array();
        
        return $result;
        
   }
   
   public function update($data){  // update pengaturan situs
      
      $this->db->where('id', 1);
      $this->db->set($data);
      if ($this->db->update('blog_setting')){
         return TRUE;
      }
      return false;
    }
    
    public function get_account(){
    
     $query = "SELECT email, fullname, quote, username FROM blog_user WHERE login = '$this->login'"; // query tampilkan informasi user
       $result = $this->db->query($query);
       
       return $result->row_array(); 
  
  }
  
  public function get_photo(){
     
     $sql = "SELECT picture FROM blog_user WHERE login = '$this->login'";
     $query = $this->db->query($sql);
     $result = $query->row_array();
     
        if (($query->num_rows() > 0) && (file_exists('./file/'.$result['picture']))){
            
            return $result['picture'];
        }
        
        return NULL;
  }
    
  public function pass_from_user(){
     
     $query = "SELECT pass FROM blog_user WHERE login = '$this->login'";
     $result = $this->db->query($query);
     $result = $result->row_array();
     return $result['pass'];
     
  }
    public function set_account($data){
       
       $this->db->where('login', $this->login);
       $this->db->set($data);
       if ($this->db->update('blog_user')){  // jika query berhasil
          
          return TRUE; 
       }
       return false;  // jika terjadi galat saat melakukan query
    
     }
     
     public function change_photo($data){
        
        $session = $this->session->userdata('login'); // session login
        $this->db->where('login', $session);
        $this->db->set($data);
        
        if ($this->db->update('blog_user')){
           
           return TRUE;
        }
        
        return FALSE;
     }
     
 }