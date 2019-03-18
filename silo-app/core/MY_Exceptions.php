<?php defined('BASEPATH') OR exit('access denied !');
 /**
 * Exceptions Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Exceptions
 * @author		EllisLab Dev Team
 * @author BCIT
 * @author    Fajar Susilo <silophp@gmail.com>
 * @ fungsi untuk overide show_404
 */
 
 class MY_Exceptions extends  CI_Exceptions {
 	
    public function __construct(){
       
       parent::__construct();
         
    }
    
    public function show_404($page = '', $log_error = TRUE){
       
     $CI = & get_instance();
     
       // untuk CLI
       if (is_cli())
		{
			$heading = 'Not Found';
			$message = 'The controller/method pair you requested was not found.';
		}
		else
		{
			$heading = '404 Page Not Found';
			$message = 'The page you requested was not found.';
		}

		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', $heading.': '.$page);
		}   
		
		     $data['page'] = 404;
		    // set status header
         $CI->output->set_status_header(404);
        
		// include 404 file
	echo $CI->twig->display('template/404',$data, TRUE);
	
	echo $CI->output->get_output();
		exit(4); // EXIT_UNKNOWN_FILE	

       
    }
 
 
 }
 