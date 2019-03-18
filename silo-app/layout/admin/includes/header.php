<?php defined('BASEPATH') OR exit('access denied !');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="description" content="Powerfull CMS Blog By Fajar Susilo">
    
    <meta name="author" content="@Fajar Susilo">

    <title> <?php echo $title;?> </title>

    <!-- Bootstrap core CSS-->
    
    <link href="/asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="/asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
   <!-- SBAdmin CSS Template -->
  <link href="/asset/css/sb-admin.css" rel="stylesheet">
  
  <!-- Highlight CSS -->
  <link rel="stylesheet" href="/asset/vendor/highlight/styles/monokai-sublime.css">
 
   <!-- JQuery Javascript Library -->
   <script type="text/javascript" src="/asset/vendor/jquery/jquery.min.js"></script>
   
   <!-- Bootstrap JavaScript Framework -->
   
   <script type="text/javascript" src="/asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
     
   <!-- SiloAPP Core Javascript-->
   
   <script type="text/javascript" src="/asset/js/fajar.js"></script>
  
   <script type="text/javascript" src="/asset/vendor/slugger/slugger.min.js"></script> 
    
   </head>
   
   <body class="page-top"> 
    <nav class="navbar navbar-expand navbar-dark static-top bg-red shadow">

      <a class="navbar-brand mr-1" href="/admin"> <?php echo CMS_NAME;?> </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
      
   <!-- Navbar -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item ml-1">
          <a href="/admin/setting" class="nav-link text-white">
            <i class="fas fa-cog fa-fw"></i>
          </a>
          
        </li>
        
        <li class="nav-item mx-1">
          <a class="nav-link text-white" href="/admin/post">
            <i class="fas fa-pen fa-fw"></i>
          </a>
          
        </li>
        
          <li class="nav-item mx-1 d-none d-md-block">
          <a class="nav-link text-white" href="/admin/category">
            <i class="fas fa-tags fa-fw"></i>
          </a>
          
        </li>
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw text-white"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item text-dark" href="/admin/account"> Akun </a>
            <a class="dropdown-item text-dark" data-toggle="modal" data-target="#ganti_foto_profil"> Ganti Foto Profil </a>
            <a class="dropdown-item text-dark" data-toggle="modal" data-target="#ganti_password"> Ganti Password </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-dark" href="#" data-toggle="modal" data-target="#logoutModal"> Keluar </a>
          </div>
        </li>
      </ul>

    </nav>  
 
<?php // include sidebar
 require_once(__DIR__.'/sidebar.php'); ?>
 <!-- Content -->
 
 <div class="loading" style="display:none;"></div>
 
 <div id="content-wrapper">
 <div class="container-fluid">
 
 