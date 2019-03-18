<?php defined('BASEPATH') OR exit('access denied !');?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="author" content="">

    <title> <?php echo CMS_NAME;?> - Login </title>

    <!-- Bootstrap core CSS-->
    <link href="/asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="/asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Bootstrap core JavaScript-->
    <script src="/asset/vendor/jquery/jquery.min.js"></script>
    <script src="/asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        
 <style type="text/css">
.m-email, .m-password, .m-captcha { font-size: small; font-family: monospace;}
:root { --input-padding-x: 1.5rem; --input-padding-y: .75rem; } body { background: #007bff; background: linear-gradient(to right, #00EAFF, #33AEFF); } .card-signin { border: 0; border-radius: 1rem; box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1); } .card-signin .card-title { margin-bottom: 2rem; font-weight: 300; font-size: 1.5rem; } .card-signin .card-body { padding: 2rem; } .form-signin { width: 100%; } .form-signin .btn { font-size: 80%; border-radius: 5rem; letter-spacing: .1rem; font-weight: bold; padding: 1rem; transition: all 0.2s; } .form-label-group { position: relative; margin-bottom: 1rem; } .form-label-group input { height: auto; border-radius: 2rem; } .form-label-group>input, .form-label-group>label { padding: var(--input-padding-y) var(--input-padding-x); } .form-label-group>label { position: absolute; top: 0; left: 0; display: block; width: 100%; margin-bottom: 0; /* Override default `<label>` margin */ line-height: 1.5; color: #495057; border: 1px solid transparent; border-radius: .25rem; transition: all .1s ease-in-out; } .form-label-group input::-webkit-input-placeholder { color: transparent; } .form-label-group input:-ms-input-placeholder { color: transparent; } .form-label-group input::-ms-input-placeholder { color: transparent; } .form-label-group input::-moz-placeholder { color: transparent; } .form-label-group input::placeholder { color: transparent; } .form-label-group input:not(:placeholder-shown) { padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3)); padding-bottom: calc(var(--input-padding-y) / 3); } .form-label-group input:not(:placeholder-shown)~label { padding-top: calc(var(--input-padding-y) / 3); padding-bottom: calc(var(--input-padding-y) / 3); font-size: 12px; color: #777; } .btn-google { color: white; background-color: #ea4335; } .btn-facebook { color: white; background-color: #3b5998; }
</style>
    
    </head>
     
  <body> 

     <div class="container"> 
     <div class="row"> 
     <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
     
     <div class="card card-signin my-5 shadow-lg">
      <div class="card-body"> 
      <h5 class="card-title text-center"> Masuk ke akun </h5>
   
    <form class="form-signin" id="form-login" method="POST"> 
    <div class="form-label-group"> 
    
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address"> 
    <label for="inputEmail">  Email address  </label> 
    </div> 
    
    <span class="form-text text-danger m-email mb-2"></span>
    
    <div class="form-label-group"> 
    
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password"> 
    
    <label for="inputPassword"> Password </label> 
    </div>
    
    <span class="form-text text-danger m-password"></span>
    
    <div class="form-group my-2">
    
    <label for="captcha" id="img-captcha"> <?php echo $captcha;?> </label>
    
    <input type="text" name="captcha" value="" placeholder="confirmation" class="form-control form-control-lg">
    
    <span class="form-text text-danger m-captcha"></span>
    
    </div>
    
  <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="return login()"> Masuk <span class="loader"></span> </button> 
  
  </form> 
  
  
  
  </div> 
   </div> 
 
  
  </div> 
     </div> 
        </div> 
  
 <script style="text/javaScript">
 
    function login(){
      jQuery.ajax({
          url : '/api/api_auth/auth',
          type : 'POST',
          dataType : 'JSON',
          data : jQuery("#form-login").serialize(),
          success : function(data){
             
             if (data.status == "failure")
             {
                          jQuery.each(data.message, function(key, value)
                {
                   jQuery('.card').find('.m-'+key).html(value);
                });
                
             }  
             else 
             {
                         
                         window.location.replace('/admin');
                         
                      }
          },
          error : function(xmlhttp,error,message){
           
          },
          beforeSend : function(){
             jQuery(".loader").html('<i class="fas fa-spinner fa-spin"></i>');
          },
          complete : function(){
             jQuery(".loader").html("");
              create_captcha();
          }
       });
       return false;
    }
    
    function create_captcha()
    {
       jQuery.ajax({
          
          url : '/api/api_auth/get_captcha',
          type: 'GET',
          dataType: 'JSON',
          success: function(response)
          {
             jQuery("#img-captcha").html(response.captcha);
          },
          error: function()
          {
             jQuery("#img-captcha").html('captcha error !');
          },
          beforeSend : function()
          {
             jQuery("#img-captcha").html('loading captcha...')
       }
    })
    }
    </script>

      </body> 
      
  </html>