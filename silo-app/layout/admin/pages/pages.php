<?php defined('BASEPATH') OR exit('access denied !');
require_once(VIEWPATH.'admin/includes/header.php'); ?>
 
 <div class="row">
  
  <div class="col-12">
 
  <!-- Search -->
    <div class="input-group mb-1 shadow">
    <div class="input-group-append">
    <span class="input-group-text" id="search-spinner"> 
    <i class="fas fa-search"></i> 
    </span> </div>
 
    <input type="text" class="form-control" onkeyup="getPage('/api/api_page/content', $(this).val());" value="">  
   
   </div>
   
     </div>
     
       </div>
 
 
  <div class="row">
  
  <div class="col-12">
  
  <button type="button" data-toggle="modal" data-target="#newpage" class="text-white btn bg-red shadow mt-2"> Buat Halaman </button>
  
  <div class="page-notification"></div>
 
  </div> 
  
     </div>
 
 <!-- List Category -->
 
 <div id="resultPage"></div>
 
 
 <!-- Add Page -->
 
 <div class="modal fade" id="newpage" tabindex="-1" role="dialog" aria-labelledby="newpageLabel" aria-hidden="true">
 
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title" id="newpageLabel"> Halaman Baru </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
          
  <form action="" id="form-newpage" method="POST"> 
     
  <div class="modal-body">
     
  <div id="newpage-info"></div>
     
  <div class="form-group mt-3"> 
    
   <label for="newpage-name"> Nama Halaman 
  
   </label>
     
     <input type="text" class="form-control" id="newpage-name" name="name" value=""> 
     
     <div class="message form-text text-danger mt-2"></div>
          
      </div>
      
      <div class="form-group mt-3">
      
      <label for="newpage-permalink"> Permalink </label>
      <input type="text" name="permalink" id="newpage-permalink" class="form-control" value="">
      
      <div class="message form-text text-danger mt-2"></div>
      
      </div>
      
      <div class="form-group mt-3">
      
      <label for="newpage-content"> Isi </label>
      
      <textarea name="content" id="newpage-content" class="form-control" rows="8"></textarea>
      
      <div class="message text text-danger mt-2" style="display:none;"></div>
      
      </div>
     
         </div>
           
          <div class="modal-footer">
          
          <button class="btn btn-danger text-white" type="button" data-dismiss="modal">  Batal  </button>
            
            <button type="button" class="btn btn-primary text-white" id="btn-newpage"> Simpan </button>
        

  </div>    
    
     </form>  
     
         </div>
         
             </div>
               
                 </div>
 
  <!-- Edit Page -->
 
  <div class="modal fade" id="editpage" tabindex="-1" role="dialog" aria-labelledby="editpageLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title">
             Edit Halaman </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
        
     <form action="" id="form-editpage" method="POST"> 
    
     <div class="modal-body">
     
     <div class="page-notification"></div>
    
     <input type="hidden" name="id" class="page-id" value="">
     
     <div class="form-group mt-3"> 
    
     <label for="editpage-name"> Nama Halaman
     </label>
     
     <input type="text" class="page-name form-control" id="editpage-name" name="name" value=""> 
     
    <div class="message-name form-text text-danger"></div>
          
      </div>
      
      <div class="form-group mt-3">
      
      <label for="editpage-permalink"> Permalink </label>
      
      <input type="text" name="permalink" id="editpage-permalink" class="page-slug form-control" value="">
      
      <div class="message-slug form-text text-danger"></div>
      
      </div>
      
      <div class="form-group mt-3">
      
      <label for="editpage-content"> Isi </label>
      
      <textarea name="content" id="editpage-content" class="page-content form-control" rows="8"></textarea>
      
      <div class="message-content form-text text-danger"></div>
      
      </div>

         </div>
         
      
          <div class="modal-footer">
          
            <button class="btn btn-dark text-white" type="button" data-dismiss="modal"> Batal </button>
            
            <button type="button" class="btn btn-danger text-white" id="btn-deletepage"> Hapus </button>
            
            <button type="button" class="btn btn-primary text-white" id="btn-editpage"> Simpan </button>
        

  </div>    
    
     </form>  
     
         </div>
           
             </div>
             
                </div>
  
 
 <script type="text/javascript">
 
  $(document).ready(function(){
    
   getPage('/api/api_page/content', '');
   
   // modal #newpage, #editpage hide
   $("#newpage, #editpage").on('hide.bs.modal', function()
   {
      var element = $(this);
      
      element.find(".message-name, .message-slug, .message-content").text("");  // clear message
      element.find(".page-notification").html("");  // clear noificatin
      element.find(":input").val("");
      
   });
   
   // edit page modal on show
   $("#editpage").on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var name = button.data('name');
      var permalink = button.data('permalink');
      var content = button.data('content');
      var fajar = $(this);
      fajar.find(".page-id").val(id);
      fajar.find('.page-name').val(name);
      fajar.find(".page-slug").val(permalink);
      fajar.find(".page-content").val(content);
  });
  
  $(".page-slug").slugger({
     source : ".page-name"
  });
  $("#newpage-permalink").slugger({
     source : "#newpage-name"
  });
   
    // ajax start onclick edit page
    
      $("#btn-editpage").on('click', function(event){
         
     event.preventDefault();
     
     var modal = $("#editpage");
     
     var error_timeout = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Connection timeout <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
     
      var error_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Terjadi kesalahan saat memproses data <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
    
     var dataSave = modal.find("#form-editpage").serialize();
     
     $.ajax({
        
        url : '/api/api_page/edit',
        
        type : 'POST',
        
        dataType : 'JSON',
        
        data : dataSave,
        
        success : function(response)
        {
           if (response.status == "success")
           {
              modal.modal('hide');
              getPage('/api/api_page/content', '');
           }
           else if (response.status == "failure")
           {
              modal.find(".page-notification").html(error_message);
           }
           else
           {
              $.each(response.message, function(key, value)
              {
                 modal.find(".message-"+key).text(value);
              });
           }
        },
        error : function(xmlhttp, status, message)
        {
           if (status == "timeout")
           {
              modal.find(".page-notification").html(error_timeout);
           }
           else
           {
              modal.find(".page-notification").html(error_message);
           }
        },
        beforeSend : function()
        {
           modal.find("#btn-editpage").removeClass("btn-primary").addClass("bg-red shadow").html("menyimpan <i class='fas fa-spin fa-spinner ml-2'></i>");
        },
        complete : function()
        {
           modal.find("#btn-editpage").removeClass("bg-red shadow").addClass("btn-primary").html("simpan");
        },
        timeout : 8000 //  8 second
        
     });
      
  });
     
     // button delete page on click
     $("#btn-deletepage").on('click', function(event){
        
       event.preventDefault();
       
        var error_timeout = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Connection timeout <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
     
       var error_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Terjadi kesalahan saat memproses data <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
    
       
       var id = $("#editpage").find(".page-id").val();
       
       $.ajax({
          
          url : '/api/api_page/delete',
          
          type : 'POST',
          
          data : 'id='+id,
          
          dataType : 'JSON',
          
          success : function(data){
             
        if (data.status == "success")
        {
         
          $("#editpage").modal("hide");
          getPage('/api/api_page/content', '');
           }
           else  
           {
             $("#editpage").find(".page-notification").html(error_message);         
           }
           },
           timeout : 8000,
         error : function(xmlhttp, status, message){
            
            if (status == "timeout"){
               
               $("#editpage").find(".page-notification").html(error_timeout);
               
            }
            else
            {
              $("#editpage-info").html(error_message);      
           }
           },
         beforeSend : function(){
         $("#btn-deletepage").removeClass("btn-primary").addClass("bg-red shadow").html("Menghapus <i class='fas fa-spin fa-spinner ml-2'></i>");
         
         },
         complete : function(){
         $("#btn-deletepage").removeClass("bg-red shadow").addClass("btn-primary").html("Hapus")
         }
        });  
     });  
   
   // btn #btn-newpage on click, ajax start
   $("#btn-newpage").on('click',function(event){
      
      event.preventDefault();
      
      dataSend = $("#form-newpage").serialize();
      var error_timeout = '<div class="alert alert-danger"> Connection timeout.</div>';
      var error_message = '<div class="alert alert-danger"> Terjadi kesalahan saat memproses data.</div>';
      
      $.ajax({
         
         url : '/api/api_page/create',
         type : 'POST',
         data : dataSend,
         dataType : 'JSON',
         success : function(data){
          // send success
         if (data.status == "success"){
            
            $("#newpage").modal("hide");
             getPage('/api/api_page/content','');  // refresh data
          }
            else if (data.status == "failure")
                 {
                    
                    $("#newpage-info").html(error_message);
                       
                 }
                   else
                        {
     $(".message").eq(0).show().html(data['message'].name);
     $(".message").eq(1).show().html(data['message'].permalink);
    $(".message").eq(2).show().html(data['message'].content);
                                  
              }
         },
         error : function(xmlhttp, status, message){
            
            if (status == "timeout"){
                $("#newpage-info").html(error_timeout);
            }
              else  {
               
               $("#newpage-info").html(error_message);
             
            }
         },
         beforeSend : function(){
           $("#btn-newpage").removeClass("btn-primary").addClass("bg-red shadow").html("Menyimpan <i class='fas fa-spin fa-spinner ml-2'></i>");
         },
         complete : function(){
           $("#btn-newpage").removeClass("bg-red shadow").addClass("btn-primary").html("Simpan");
         }
         
      });
      
    });
   
 });
 function getPage(uri, search){
    
    var error_message = '<div class="alert alert-danger mt-2"> Terjadi kesalahan saat memproses data </div>';
    var error_timeout = '<div class="alert alert-danger mt-2"> Connection timeout ! </div>';
    var spiner = '<i class="fas fa-spinner fa-spin"></i>';
    var noSpiner = '<i class="fas fa-search"></i>';
    
    $.ajax({
       url : uri,
       type : 'GET',
       data : 'q='+search,
       dataType : 'html',
       success : function(data){
          
         $("#resultPage").html(data);   // inner html ke dalam id #resultPage
         
       },
       error : function(xmlhttp, status, message){
           if (status == "timeout"){
               $("#resultPage").html(error_timeout);
           }
              else {
                 
                 $("#resultPage").html(error_message);
                 
              }
       },
       beforeSend : function(){
         $("#search-spinner").html(spiner);
       },
       complete : function(){
         $("#search-spinner").html(noSpiner);
       },
       timeout : 15000 // 15 detik
       
    });
    
    return false;
    
 }
 function infoPage(id){
    
    var elementId = id;
    $("#"+elementId).toggleClass('d-block');
    
 }
 </script>
 
<?php require_once(VIEWPATH.'admin/includes/footer.php');?>