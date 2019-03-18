<?php 
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
 */
 $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://': 'http://';
 $site_url = $http. $_SERVER['HTTP_HOST'];
 ?>
 <!DOCTYPE html>
 <head>
 <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>/asset/vendor/bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>/install/install.css">
 <link rel="stylesheet" href="<?php echo $site_url;?>/asset/vendor/fontawesome-free/css/all.min.css" type="text/css">
 <script src="<?php echo $site_url;?>/asset/vendor/jquery/jquery.min.js"></script>
 <script src="<?php echo $site_url;?>/asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <title> Install - <?php echo $title; ?> </title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 
 <body>
 