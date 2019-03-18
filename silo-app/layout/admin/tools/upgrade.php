<?php defined('BASEPATH') OR exit('access denied !');
 require_once(VIEWPATH.'admin/includes/header.php'); ?>
 
  <div class="container">
  <div class="row">
  <div class="col-md-8 mx-auto my-5">
  <div class="alert bg-light"> Upgrade <strong> SiloCMS </strong> ke versi 1.2 .
  <p> ChangeLog </p>
  <?php echo $changelog;?>
  <br> Klik <strong Upgrade </strong>  untuk melanjutkan
  </div>
  
  <a class="btn btn-danger btn-lg" href="?act=upgrade"> Upgrade </a>
  
  </div>
     </div>
        </div>
  
  
<?php require_once(VIEWPATH.'admin/includes/footer.php');