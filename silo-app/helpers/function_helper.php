<?php defined('BASEPATH') OR exit('access denied !');
 /**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files function (helper)
 */
 $CI = & get_instance(); // load semua class codeigniter
 
  function waktu(){
   	  return gmdate('Y-m-d H:i:s',time()+3600*7);
   }
   
 if (!function_exists('get_filesize')){
    
   function get_filesize($file)
   {
   $size = $file*1024;
   $units = array('B','KB','MB','GB','TB', 'PB','EB','ZB','YB');
   $power = $size > 0 ? floor(log($size,1024)):0;
      
   return number_format($size/pow(1024, $power),2,'.',',').' '.$units[$power];

    }
  }
// menampilkan nama user yang sedang login 
if(!function_exists('get_author'))
{
	  function get_author($get = 'username')
	  {
	   global $CI;
	   
	  $get_author = $CI->db->select('username,fullname,id')
	               ->from('blog_user')
	               ->where('id',1)
	               ->get();
	       $get_author = $get_author->row_array();
	       
	       if ($get == 'fullname')
	       {
	          return $get_author['fullname'];
	       }
	       else
	       {
	          return $get_author['username'];
	       }
	    }
   }
   
  // update session key login
  if (!function_exists('update_login'))
  {
     function update_login($string){
	   
	   $encrypt = md5(md5(base64_encode($string)));
	   
	   return $encrypt;
	    
	}
	}
	
	if (!function_exists('cut_string'))
	{
	function cut_string($string, $length = 240, $xss_clean = TRUE)
	{
	   global $CI;
	   // filter string
	   if ($xss_clean)
	   {
	      $data = strip_tags($string);
	      $cut = substr($data, 0, $length);
	      return $cut;
	   }
	   else
	   {
	      $cut = substr($string, 0, $length);
	      return $cut;
	    }
	  }
	}
	
	if (!function_exists('slug_category'))
	{
	   function slug_category($slug)
	   {
	     
	     $pecah = explode('/', $slug);
	     
	     return $pecah[2];
	   
	  }
	}
 ?>