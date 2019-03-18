<?php defined('BASEPATH') OR exit('access denied !');
require_once(VIEWPATH.'admin/includes/header.php'); ?>

  <div class="row">
 
  <div class="col-xs-12 col-md-8">
  
  <div class="setting-notification"></div>
   
    <div class="card mb-3 shadow my-3">
    
     <div class="card-header">  Pengaturan </div>
    
    <div class="card-body">
    
    <form action="" method="POST" id="form-setting">
    
    <div class="form-group">
    
    <label for="title"> Judul Situs </label>
    
    <input type="text" name="title" class="form-control" value="<?php echo $setting['title'];?>" id="title">
    
    <div class="setting-title"></div>
    
    </div>
    
    <div class="form-group">
    
    <label for="description"> Deskripsi Situs </label>
    
    <textarea name="description" class="form-control" id="description" rows="5"><?php echo $setting['description'];?></textarea>
    
    <div class="setting-description"></div>
    
    </div>
    
    <div class="form-group">
    
    <label for="keyword"> Kata Kunci </label>
    
    <textarea name="keyword" class="form-control" id="keyword" rows="5"><?php echo $setting['keyword'];?></textarea>
    <div class="setting-keyword"></div>
    
    </div>
    
   <div class="form-group">
   
   <label for="post_limit"> Posting Per Halaman </label>
   
   <select name="post_limit" id="post_limit" class="form-control">
   
   <?php for($i=1; $i <= 15; $i++):?>
   
   <?php if ($setting['post_limit'] == $i):?>
   
   <option value="<?php echo $i;?>" id="option_<?php echo $i;?>" selected="selected"> <?php echo $i;?> </option>
  
  <?php else:?>
  
  <option value="<?php echo $i;?>" id="option_<?php echo $i;?>"> <?php echo $i;?> </option>
  

  <?php endif; endfor;?>
  
   </select>
  
  </div>

    <div class="form-group">
    
    <label for="slugpost"> Slug Post </label>
    
    <select name="slugpost" class="custom-select">
    
    <option value="1" <?php $selected = ($setting['slugpost'] == 1) ? 'selected="selected"': ''; echo $selected;?>> example.com/article/view/username/post-title </option>
    
    <option value="2" <?php $selected = ($setting['slugpost'] == 2) ? 'selected="selected"': ''; echo $selected;?>> example.com/article/view/post-title (Recomended)</option>
    
    <option value="3" <?php $selected = ($setting['slugpost'] == 3) ? 'selected="selected"': ''; echo $selected;?>> example.com/article/view/id-post </option>
    
    </select>
    
    </div>
    
    <button type="button" class="btn btn-md btn-primary" id="btn-setting"> Simpan </button>
    
    </form>
    
    </div>
    
       </div>
       
           </div>
           
              </div>
                
<script type="text/javascript">

 $(document).ready(function(){

 $("#btn-setting").on("click",function(event){
    
    event.preventDefault();
    
    var success = '<div class="alert alert-success alert-dismissible fade show" role="alert"> Pengaturan berhasil di simpan. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>';
    
    var error_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>';
    
    var error_timeout = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Batas waktu koneksi habis (connection timeout). <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>';
    
   $.ajax({
     
       url : '/api/api_setting/edit',   // url
       
       type : 'POST',  // method type
       
       data : $("#form-setting").serialize(),  // data
       
       dataType : 'JSON',  // response data
       
       success : function(data){
          
          if (data[0].status == "success"){    // success
             $(".setting-notification").html(success);
             
             
          }
            else if (data[0].status == "failure"){
               $(".setting-notification").html(error_message);
               
            } 
              else if (data[0].status == "validate"){
                
                 $.each(data[1], function(key, value){
                    
                    $(".setting-"+key).html('<p class="text-danger form-text mt-3">'+value+'</p>');
                    
                });
                 
               }
                
              },
              error : function(xmlhttp,status,message){
                 
                if (status == "timeout"){
                   
                   $(".setting-notification").html(error_timeout);
                   
                   
                }
                   
                   else
                           {
                           
                 $(".setting-notification").html(error_message);
                 
               }
                 
              },
              beforeSend : function(){
                 
                 $(".loading").show();
                 
              },
              complete : function(){
                 
                 $(".loading").hide();
          },
          timeout : 8000  // 8 second
          
   });
  });
}); </script>
<?php require_once(VIEWPATH.'admin/includes/footer.php');?>