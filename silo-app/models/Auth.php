<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @version 1.0
 * @packpage auth
 **/
   class Auth extends CI_Model {
 
    
  	public function login($email, $pass){
 
 //  periksa email atau nama pengguna 
   $c_mail = $this->db->select('email, pass, login')
         ->from('blog_user')
         ->where('email',$email)
         ->get();
  
      //  jika email tidak tersedia   
      if($c_mail->num_rows() == 0){
         
      	 $status = "email";
      	 return $status;
      }    
      else  
      {
     
   /* jika email tersedia, lanjut pencocokan password  */
 	$c_pass=$this->db->select('pass,login')
        	  ->from('blog_user')
        	  ->where('email', $email)
        	  ->get();
      	
      	$r_pass = $c_pass->row_array();
      	
   // jika password tidak sama dengan yang ada di database 
      if(!password_verify($pass,$r_pass['pass'])){
      	   
      	   $status = "password";
      	   return $status;
       }      
       else
       {
       	
        $key = time().$r_pass['email'].$r_pass['pass'];  // perbaharui key session login
        
        $session = update_login($key);  // encrypt 
        
       	$data = array('login' => $session);
       	 
       	$this->db->where('login',$r_pass['login']);
       	$this->db->set($data);
       	
       	$this->db->update('blog_user');
       	
       	$this->session->set_userdata($data);
       
       	 $status = 'success';
       	 
       	 return $status;

           
           }
         
       	}
      
     }
      
      public function reset_pass($new){
         
         $session = $this->session->userdata('login'); // session login
         $data = array('pass' => $new);
         $this->db->where('id',1);
         $this->db->set($data);
         
         if ($this->db->update('blog_user')){
            return true;
         }
         return false;
      }
      
      // return password
      public function verify($email){
         
         $result = $this->db->select('pass')
                  ->from('blog_user')
                  ->where('email',$email)
                  ->get();
                  
                  if ($result->num_rows() > 0){
                     $row = $result->row_array();
                     return $row['pass'];
                  }
                  
                  return;
         
      }
      
  }
   
   