<?php
/**
  * @author fajar susilo
  * @packpage install
  * @email <silophp@gmail.com>
  */
  
  $title = 'Installation - SiloCMS ';
  require_once(__DIR__.'/header.php'); ?>
  
  <div class="container p-1">
  <div class="row">
  <div class="col-md-10 col-lg-10 mx-auto my-3">
  <div class="alert alert-info"> Welcome to PenulisCMS
this is the page installation for the PenulisCMS
 </div> 
  
  <div id="error-message"></div>
  
  <div class="card shadow-lg border-0">
  <div class="card-header"> fill in all the form below with the correct </div>
  
  <div class="card-body">
  <form action="" id="form-install" method="POST">
  <div class="form-group">
     <label for="host"> Host </label>
     <input type="text" name="host" class="form-control form-control-lg" value="" id="host">
     
     <div id="m-dbhost" class="form-text text-error"></div>
     
     </div>
     
     <div class="form-group">
     <label for="dbname"> Nama database </label>
     <input type="text" name="dbname" class="form-control form-control-lg" value="" id="dbname">
     
     <div id="m-dbname" class="form-text text-error"></div>
     
     </div>
     
     <div class="form-group">
     <label for="dbuser"> Database pengguna </label>
     <input type="text" name="dbuser" class="form-control form-control-lg" value="" id="dbuser">
     
     <div id="m-dbuser" class="form-text text-error"></div>
     
     </div>
     
     <div class="form-group">
     <label for="dbpw"> Password database </label>
     <input type="text" name="dbpass" class="form-control form-control-lg" value="" id="dbpw">
     
     <div id="m-dbpass" class="form-text text-error"></div>
     
     </div>
     
   <div class="form-group">
     <label for="fullname"> Nama lengkap </label>
     <input type="text" name="fullname" class="form-control form-control-lg" value="" id="fullname">
     
     <div id="m-fullname" class="form-text text-error"></div>
     
     </div>
  
  
     <div class="form-group">
     <label for="username"> Nama pengguna </label>
     <input type="text" name="username" class="form-control form-control-lg" value="" id="username">
     
     <div id="m-username" class="form-text text-error"></div>
     
     </div>
      <div class="form-group">
     <label for="email"> Email </label>
     <input type="text" name="email" class="form-control form-control-lg" value="" id="email">
     
     <div id="m-email" class="form-text text-error"></div>
     
     </div>
     
      <div class="form-group">
     <label for="password"> Password </label>
     <input type="text" name="password" class="form-control form-control-lg" value="" id="password">
     
     <div id="m-password" class="form-text text-error"></div>
     
     </div>
     
   <button type="button" class="btn btn-block btn-install btn-lg" id="button"> Install <span id="loader"></span> </button>
   
   </form>
   
   </div>
   
      </div>
      
         </div>
         
            </div>
              
              </div>
              
<?php require_once(__DIR__.'/footer.php');
 ?>
     