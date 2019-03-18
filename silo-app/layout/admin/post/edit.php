<?php defined('BASEPATH') OR exit('access denied !');
 require_once(VIEWPATH.'admin/includes/header.php'); ?>
 
   <div class="row">
   
   <div class="col-md-10">
   
   <div class="post-notification"></div>
   
   <div class="card my-3 shadow">
   <div class="card-header">  Edit Postingan
   </div>
   
   <div class="card-body">
   
   <form role="form" id="form-editpost" method="POST">
   
   <input type="hidden" name="id" value="<?php echo $artikel['id'];?>">
   <div class="form-group">
   
   <label for="post-title"> Judul Artikel 
   </label>
   
   <input type="text" name="title" class="form-control" value="<?php echo $artikel['title'];?>" id="post-title">
   
   <div class="message-title"></div>
   
   </div>
   
   <div class="form-group">
   
   <label for="post-slug"> Permalink 
   </label>
   
   <input type="text" name="slug" class="form-control" value="<?php echo $artikel['permalink'];?>" id="post-slug">
 
   <div class="message-slug"></div>
   
   </div>
   
   <div class="form-group">
   
   <label for="post-content"> Konten Artikel </label>
   
   <textarea name="content" class="form-control" rows="15"><?php echo  htmlentities($artikel['content']);?></textarea>
   
   <div class="message-content"></div>
   
   </div>
   
   
   <div class="form-group">
   <label for="post-category"> Kategori 
   </label>
   
   <?php 
      foreach($category as $kategori){
         
      if(preg_match("/{$kategori['id']}/",$artikel['category'])){ ?>
      
      <div class="custom-control custom-checkbox mt-2"> 
      
      <input type="checkbox" name="label[]" id="post-category-<?php echo $kategori['id'];?>" value="<?php echo $kategori['id'];?>" class="custom-control-input" checked="checked">
      
      <label for="post-category-<?php echo $kategori['id'];?>" class="custom-control-label">
      
       <?php echo $kategori['name'];?>
       </label>
       
       </div>
      
         
<?php   }
           else 
               
              {  ?>  
               <div class="custom-control custom-checkbox"> 
               <input type="checkbox" name="label[]" id="post-category-<?php echo $kategori['id'];?>" value="<?php echo $kategori['id'];?>" class="custom-control-input"> 
               
              <label for="post-category-<?php echo $kategori['id'];?>" class="custom-control-label"> <?php echo $kategori['name'];?>     </label>
               
               </div>
               
   <?php   }  } ?>
   
   <div class="message-category"></div>
   
      </div>
      
      <div class="form-group"> 
      
      <label for="post-status"> Status 
      </label>
      
      <select name="status" class="custom-select">
      
          <option value="1" <?php if($artikel['status'] == 1){ echo 'id="post-status" selected';}?>> Terbitkan </option>
          <option value="0" <?php if($artikel['status'] == 0){ echo 'id="post-status" selected';}?>> Konsep </option>   
             
          </select>
          
          </div>
 
 <div class="form-group">
 
 <label for="post-update"> Update Artikel ? </label>
 
 <div class="custom-control custom-checkbox">
 
 <input type="checkbox" name="update" value="1" id="yes" class="custom-control-input" checked> 
 <label for="yes" class="custom-control-label"> Perbaharui </label>
 
 </div>
 
 <textarea id="post-update" readonly="readonly" class="form-control mt-3" rows="3">
 jika anda memilih 'Perbaharui' maka artikel akan di perbaharui sebagai artikel baru (tanggal,waktu di perbaharui), dan akan tampil sebagai artikel yang baru di terbitkan (di halaman beranda)
 </textarea>
 
 </div>
          
          <div class="form-group">
          
          <label for="post-newline"> Gunakan Baris Otomatis 
          </label>
          
          <div class="custom-control custom-checkbox">
          
          <input type="checkbox" name="nl2br" id="nl2br-yes" value="1" class="custom-control-input">
          
          <label class="custom-control-label" for="nl2br-yes"> Yap </label>
          
          </div>
          
          </div>
          
          <button type="button" class="btn btn-primary btn-block" name="edit" id="btn-editpost">
          Simpan </button>
          
          </form>
            
              </div>
          
                   </div>
          
                         </div>
                             
 <script type="text/javascript">
 
  $(document).ready(function(){
    $("#post-slug").slugger({
       source : '#post-title'
    });
    $("#btn-editpost").on('click', function(){
       
       var urlSave = '/api/api_post/edit';
       
       var dataSave = $("#form-editpost").serialize();
       
       var error_timeout = '<div class="alert alert-danger alert-dismissible" role="Alert"> <button type="button" class="close" data-dismiss="alert" arial-label="close"> <span aria-hidden="true">&times; </span> </button> Batas waktu koneksi habis (connection timeout) </div> ';
       
       var error_message = '<div class="alert alert-danger alert-dismissible" role="Alert"> <button type="button" class="close" data-dismiss="alert" arial-label="close"> <span aria-hidden="true">&times; </span> </button> Terjadi kesalahan saat memproses data </div> ';
       
       var success_message = '<div class="alert alert-success alert-dismissible" role="Alert"> <button type="button" class="close" data-dismiss="alert" arial-label="close"> <span aria-hidden="true">&times; </span> </button> Artikel berhasil di perbaharui. </div> ';
       
     $.ajax({
        
        url : urlSave,
        dataType : 'JSON',
        data : dataSave,
        type : 'POST',
        success : function(response)
        {   
           if (response.status == "success")
           {
              $(".post-notification").html(success_message);
              $(".message-title, .message-content, .message-slug, .message-category").html("");
           }
           else if (response.status == "validate")
           {
             $.each(response.message, function(key, value){
              $(".message-"+key).html('<p class="text-danger mt-3 form-text">'+value+'</p>')
             });
           }
           else
           {
              $(".post-notification").html(error_message);
              
           }
           
        },
        error : function(XMLHttpRequest, status, message){
           if (status == "timeout")
           {
              $(".post-notification").html(error_timeout);
           }
           else
           {
              $(".post-notification").html(error_message);
           }
        },
        beforeSend : function(){
           $("#btn-editpost").removeClass("btn-primary").addClass("btn-info shadow").html('Menyimpan <i class="fas fa-spinner fa-spin ml-3"></i>');
        },
        complete : function(){
           $("#btn-editpost").removeClass("btn-info shadow").addClass("btn-primary").html('Simpan');
        },
        timeout : 8000 // 8 second
        
  });
       
  });
 
  });
  </script>

<?php require_once(VIEWPATH.'admin/includes/footer.php');?>