<?php defined('BASEPATH') OR exit('access denied !');
 require_once(VIEWPATH.'admin/includes/header.php'); ?>
 
 <div class="container-fluid">
 <div class="row">
 
 <?php if ($backup):?>
   
   <div class="alert alert-danger mt-1 alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close"> <span aria-hidden="true"> &times; </span> </button> Terjadi kesalahan saat memproses data. </div>
   <?php endif;?>

 
 <form action="<?php echo current_url();?>" method="POST"> 
 <input type="submit" name="backup" value="backup" class="btn btn-light border ml-3 mr-1">
 </form>
 
 <button class="btn btn-light border" type="button" data-toggle="modal" data-target="#upload-theme"> Unggah Tema </button> 
 
 
 <div class="col-md-12 mt-1 mb-5">

  <div id="notification"></div>
    
  <div class="form-group">
  <select class="form-control" id="part" onchange="getPart(this.value);">
  
  <option value="index.html"> index.html 
  </option>
  <option value="header.html"> header.html </option>
  <option value="footer.html">  footer.html </option>
   <option value="post-single.html"> post-single.html </option>
  <option value="search-post.html">  search-post.html </option>
   <option value="post-category.html"> post-category.html </option>
  <option value="pages.html">  pages.html </option>
  <option value="404.html"> 404.html </option>
  <option value="style.css"> CSS </option>
  </select>
      </div>
      
      <div id="spinner-loading" class="mx-auto my-2"></div>
      
      <div class="form-group">
      <textarea class="form-control template-editor-text" name="content" id="content" rows="20"></textarea>
      </div>
      
      <button type="button" class="btn btn-primary" id="save"> Simpan <span id="spinner"></span> </button>  <button type="button" class="btn btn-danger" id="reset"> Reset </button>
      
    
         
         </div>
           </div>
             </div>
             
 <!-- Modal upload theme -->          
 <div class="modal fade" id="upload-theme" tabindex="-1" role="dialog" aria-labelledby="upload-themeLabel" aria-hidden="true">
    
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title"> Unggah Tema </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
          
          <form action="" enctype="multipart/form-data" id="upload-theme-form" accept-charset="utf-8" method="POST"> 
          
          
     <div class="modal-body">
     <div class="notification"></div>
     <div class="alert alert-info border"> Unggah tema dalam bentuk format terkompresi (ZIP), ukuran tema tidak boleh lebih dari 2MB.</div>
     
     <div class="custom-file mt-3"> 
     <input type="file" class="custom-file-input" id="file" name="upload"> 
     
     <label class="custom-file-label" for="file"> Pilih Berkas </label>
   
      </div>
      </div>
      
         <div class="modal-footer">
         <button class="btn btn-danger text-white" type="button" data-dismiss="modal"> Batal </button>
          
            <button type="button" class="btn btn-primary text-white " id="upload-theme-button"> <i id="loading"></i> Unggah tema </button>
            
          </div>
          
          </form>
             
        </div>
        
      </div>
      
    </div>
    
             
 <script type="text/javascript">
 
  jQuery(function(){
     // load template index
     getPart();
     // reset textarea
     jQuery("#reset").click(function()
     {
        jQuery("#content").val("");
     });
     // Simpan template
     jQuery("#save").on('click', function(){
        // message
        var success = '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert">&times;</button> Template berhasil di simpan </div>';
        
        var error = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert">&times;</button> Terjadi kesalahan saat memproses data </div>';
        
        var timeout = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert">&times;</button> connection timeout ! try again </div>';
        
        var part = jQuery("#part").val();
        
        jQuery.ajax({
           url : '/api/api_theme/save?part='+part,
           data : {'content' : jQuery("#content").val() },
           dataType : 'JSON',
           type : 'POST',
           success : function(response)
           {
              if (response.status == "success")
              {
                
                 jQuery("#notification").html(success);
                 getPart(part);
              }
              else
              {
                 jQuery("#notification").html(error);
              }
           },
           error : function(xml, status, message)
           {
              if (status == "timeout")
              {
                 jQuery("#notification").html(timeout);
              }
              else
              {
                 jQuery("#notification").html(error);
              }
           },
           beforeSend : function()
           {
              jQuery("#save").find("#spinner").addClass('fas fa-spinner fa-spin ml-2');
           },
           complete : function()
           {
              jQuery("#save").find("#spinner").removeClass();
           },
           timeout : 9000
           
        });
     });
     
   // modal for upload theme
   jQuery("#upload-theme").on('hide.bs.modal', function(){
     // reset notification if found
      jQuery(jQuery(this))
            .find(".notification")
            .html("");
    });
   jQuery("#upload-theme-button").on('click', function(e){
      e.preventDefault();
      var e_message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert"> <span aria-hidden="true"> &times; </span> </button>';
      var loading = 'fas fa-spin fa-spinner mx-1';
      var active = jQuery(this);
      
      jQuery.ajax(
      {
         url : '/api/api_theme/upload',
         type : 'POST',
         data : new FormData(jQuery("#upload-theme-form")[0]),
         processData : false,
         contentType : false,
         dataType : 'JSON',
         success : function(response)
         {
            if (response.status == "success")
            {
               jQuery("#upload-theme").modal('hide');
               getPart();
            }
            else
            {
             jQuery("#upload-theme")
                   .find(".notification")
                   .html(e_message+response.message+'</div>');
            }
         },
         error : function()
         {
            jQuery("#upload-theme")
                  .find(".notification")
                  .html();
         },
         beforeSend : function()
         {
            jQuery(active)
                  .find("#loading")
                  .addClass(loading);
         },
         complete : function()
         {
            jQuery(active)
                  .find("#loading")
                  .removeClass();
                  
         }
      })
    });
  });
  
  function getPart(part = 'index.html')
  {
     jQuery.ajax({ 
     
      url : '/api/api_theme/getpart',
      type : 'GET',
      dataType : 'JSON',
      data: { 'part' : jQuery("#part").val()},
      success : function(response)
      {
         if (response.status == "success")
         {
            jQuery("#content").val(response.content);
            
         }
         else
         {
            jQuery("#content").val("");
            jQuery("#notification").html('<p class="alert alert-danger"> Struktur template tidak di temukan </p>');
         }
      },
      beforeSend : function()
      {
         jQuery("#spinner-loading").html('Memuat <i class="fas fa-spinner fa-spin ml-3"></i>');
      },
      complete : function()
      {
         jQuery("#spinner-loading").html("");
      },
      error : function(xml, status, msg)
      {
        jQuery("#notification").html('<p class="alert alert-danger"> Terjadi kesalahan saat memproses data </p>');
        
      }
    });
  }
  </script>
 <?php require_once(VIEWPATH.'admin/includes/footer.php'); ?>  