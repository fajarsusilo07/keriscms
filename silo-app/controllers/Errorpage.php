<?php defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Errorpage extends CI_Controller {
     
     public function __construct(){
        
        parent::__construct();
     }
     
     public function nofound(){
        
        $data['page'] = '404';
        $this->twig->display('template/404',$data);
        
     }
     
  }