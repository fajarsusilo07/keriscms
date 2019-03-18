<?php defined('BASEPATH') OR exit('access denied');
require_once(VIEWPATH.'admin/includes/header.php'); ?>

<div class="row">

    <div class="col-xs-12 col-md-8"> 
    
    <div class="account-notification"></div>
    
      <div class="card my-5 shadow"> 
         
            <div class="card-header"> Perbaharui Akun </div>
 
  <div class="card-body"> 
  
     <form id="form-account" method="POST" role="form">
     
       <div class="form-group">
       
       <label for="fullname"> Nama Lengkap </label>
       
       <input type="text" name="fullname" class="form-control" value="<?php echo $account['fullname'];?>" id="fullname">
       
       <div class="account-fullname"></div>
       
      </div>
       
      <div class="form-group">
      
       <label for="username"> Nama Pengguna </label>
       
       <input type="text" class="form-control" value="<?php echo $account['username'];?>" readonly="readonly" id="username">
       </div>
       
       <div class="form-group">
       
       <label for="email"> Email </label>
       
       <input type="text" name="email" class="form-control" value="<?php echo $account['email'];?>" id="email">
       
         <div class="account-email"></div>
         
         </div>
       
       <div class="form-group">
       
       <label for="quote"> Kutipan </label>
       
       <textarea name="quote" class="form-control" id="quote" rows="5"></textarea>
         <div class="account-quote"></div>
       </div>
       
     <div class="form-group">
     
     <label for="confirpw"> Konfirmasi Password </label>
     
       <input type="password" name="confirpw" class="form-control" id="confirpw" value="">
       
    <span class="help-block"> Untuk melajutkan proses menyimpan data akun anda silahkan masukan password terlebih dahulu. </span>
    
    <div class="account-password"></div>
    
       </div>
     <button type="button" class="btn btn-primary" id="btn-account"> Simpan </button>
 
   </form>
     
       </div>
       
         </div>
              
              
              </div>
                
                   </div>
                
  <script type="text/javascript">
   
   $(document).ready(function(){
       
   $("#btn-account").on("click", function(e){
      
     e.preventDefault();
     
     $.ajax({
        url : '/api/api_account/set_account',
        
        type : 'POST',
        
        dataType : 'JSON',
        
        data : $("#form-account").serialize(),
        
        success : function(data){
           
         if (data[0].status == "success"){
            
            $(".account-notification").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> Akun berhasil di perbaharui. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
       
         $("#confirpw").val("");
            
         }
         
               else if (data[0].status == "failure"){
                  
            $(".account-notification").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
       
         }
         
               else if(data[0].status == "validate"){
             $.each(data[1], function(key,value){
                $(".account-"+key).html('<p class="text-danger form-text mt-2">'+value+'</p>');
                
             });       
                  
           }
           
          },
          error : function(xmlhttp,status,message){
         
          if (status == "timeout"){
              
             $(".account-notification").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Batas waktu koneksi habis (connection timeout). <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
             
          }
          
              else
                      
                      {
                         
                       $(".account-notification").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                         
                      }
              
         
          },
          
          beforeSend : function(){
             
          $(".loading").show();
          
          },
          
          complete : function(){
             
          $(".loading").hide();
          
          },
          timeout : 8000   // 8 second
          
       
     });
   });
 });
  </script>
  
  
          
<?php require_once(VIEWPATH.'admin/includes/footer.php'); ?>