<?php defined('BASEPATH') OR exit('access denied !');?>
 
  </div>
      <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span> &copy; <?php echo CMS_NAME;?>  <div class="text-muted mt-1"> Version <?php echo CMS_VERSION;?>,  Created By <a href="http://facebook.com/fajar.susilo.904" target="_blank"> Fajar Susilo </a> </div> </span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Logout Modal-->
    
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin keluar dari sesi ini ? </div>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body"> Pilih "keluar" untuk melanjutkan dan akan keluar sesi ini.</div>
          <div class="modal-footer">
            <button class="btn btn-dark text-white" type="button" data-dismiss="modal"> Batal </button>
            <a class="btn btn-danger text-white" id="btn-logout"> Keluar </a>
          </div>
        </div>
      </div>
    </div>
    
    
    <!-- Ganti Foto Profile -->
    <div class="modal fade" id="ganti_foto_profil" tabindex="-1" role="dialog" aria-labelledby="ganti_foto_profilLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title" id="ganti_foto_profilLabel"> Ganti Foto Profil </div>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
         <?php echo form_open_multipart('',array('id' => 'form-changePhoto'));?>
<div class="modal-body"> 
     <div id="proses"></div>
  
     <div class="media"> 
     
     <img class="align-self-start mr-3 profil" id="changePhoto" src="<?php echo $this->user->avatar();?>" alt="profile <?php echo $this->user->fullname();?>"> 
     
  <div class="media-body"> 
  <h5 class="mt-1"> <?php echo $this->user->fullname();?> </h5> 
  <p> <?php echo $this->user->quote();?>
 </p> </div> </div>
 
   <div class="custom-file mt-3"> 
     <input type="file" class="custom-file-input" id="userfile" name="userfile"> 
     <label class="custom-file-label" id="loading-upload" for="userfile"> Pilih Gambar </label>
     <div id="message"></div>
     </div>
        
          </div>
          <div class="modal-footer">
            <button class="btn btn-dark text-white" type="button" data-dismiss="modal"> Batal </button>
            <input type="submit" class="btn btn-primary text-white" id="btn-gantiFotoProfil" value="Simpan">
          </div>
              </form>
        </div>
      </div>
    </div>

<!-- Ganti Password -->
    <div class="modal fade" id="ganti_password" tabindex="-1" role="dialog" aria-labelledby="ganti_passwordLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title" id="ganti_passwordLabel"> Ganti Password </div>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          
          <form action="" method="POST" id="form-gantiPassword" role="form">
          
          <div class="modal-body"> 
          
          <div id="alertPassword"></div>
          
          <div class="form-group">
          <label for="old"> Password Lama </label>
          <input type="password" name="old" class="form-control" value="" id="old">
              <div class="password_msg err"></div>
       
          
          </div>
          
          <div class="form-group">
          <label for="new"> Password Baru </label>
          <input type="password" name="new" class="form-control" value="" id="new">
           <div class="newpassword_msg err"></div>
       
          </div>
          
          <div class="form-group">
          <label for="confir"> Konfirmasi Password Baru </label>
          <input type="password" name="confir" class="form-control" value="" id="confir">
          
              <div class="confir_msg err"></div>
       
          
          </div>
          
                
          </div>
          
          <div class="modal-footer">
            <button class="btn btn-danger text-white" type="button" data-dismiss="modal"> Batal </button>
            <button type="button" class="btn btn-primary text-white" id="btn-gantiPassword" onclick="return changePassword()"> Ganti </button>
          </div>
            </form>
        </div>
      </div>
    </div>
   
 <script type="text/javascript">
 
    $("#ganti_foto_profil, #ganti_password").on('hide.bs.modal', function(){
       $("#message").html("");
       $(".err").html("");
    });
    function set_photo(){
       $.getJSON('/api/api_account/photo', function(data){
         $("#changePhoto").attr('src',data.image);
       });
    }
  // ganti photo profil
   $("#btn-gantiFotoProfil").click(function(e){
    e.preventDefault();
    var send = new FormData($("#form-changePhoto")[0]);
    $.ajax({
        url : '/api/api_account/change_photo',
        type: 'POST', 
        dataType: 'JSON', 
        data: send,    
        processData: false,
        contentType: false,
        success : function(data){
           if (data.status == "success"){
              set_photo();
              $("#message").html('<p class="text-left text-success"> Foto profil berhasil di perbaharui. </p>');
           }
             else 
                  {
                
                 $("#message").html('<p class="text-left text-danger">'+data.message+'</p>');
             }
        },
        error : function(){
          
           $("#proses").html('<p class="text-center text-danger"> Terjadi kesalahan saat memproses data. </p>');
        },
        beforeSend : function(){
           $("#loading-upload").html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        },
        complete : function(){
           $("#loading-upload").html("Pilih Gambar");
       }      
    });
    return false;
  });
  
  // ganti password
  function changePassword(){   
  
   $.ajax({
        url :'/api/api_auth/reset_password',
        type : 'POST',
        data : $("#form-gantiPassword").serialize(),
        dataType : 'JSON',
        success : function(data){    
       
       if (data[0].status == "success"){
              $("#alertPassword").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> Password berhasil di perbaharui. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
              $(".err").html("");
           } 
             else if(data[0].status == "failure"){
                     $("#alertPassword").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                  } 
              
              else if (data[0].status == "verify"){
                       
                       $("#alertPassword").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Password lama yang anda masukan salah. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <v>');
                       $(".err").html("");
                    } 
                      
                      else if (data[0].status == "validate") 
                      {
                         
                         $.each(data[1], function(key,value){
                         
                         $("."+key+"_msg").html('<p class="text-danger">'+value+'</p>');
                         });
                         
                      }
                      
                     
        },
        error : function(){
            $("#alertPassword").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
            $(".err").html("");
        },
        beforeSend : function(){
           $(".loading").show();
        },
        complete : function(){
           $(".loading").hide();
        }
     });
        return false;
  }
   </script>
   <script type="text/javascript" src="/asset/js/sb-admin.js"></script>
  </body>

</html>