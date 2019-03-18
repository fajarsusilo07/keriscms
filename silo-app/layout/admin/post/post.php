 <?php defined('BASEPATH') OR exit('access denied !');
  require_once(VIEWPATH.'admin/includes/header.php'); ?>
 
  <div class="row">
  
  <div class="col-12 col-md-8 mb-2">
  
  <div class="input-group"> 
  
  <div class="input-group-append">
   
  <span class="input-group-text"> 
  <i class="fas fa-search" id="loading-spin"></i>  </span> </div>
  
  <input type="text" value="" class="form-control" onkeyup="getPost('/api/api_post/datapost', this.value, document.getElementById('mode').value);" id="search">
  
           </div>
                 
                   <div class="form-group mt-3">
                   
                   <select onchange="getPost('/api/api_post/datapost', $('#search').val(), $(this).val());" id="mode" class="custom-select">
                   
                   <option value="publish"> Publish </option>
                   
                   <option value="draft"> Draft </option>
                   
           </select>
                    
                  </div>
                  
                  <div class="btn btn-primary">
                   <a href="/admin/post/add" class="text-white"> Buat Artikel </a>
                   
                   </div>
                   
                        </div>
                   
                             </div>
                             
                             
                                                   <div class="modal fade show bg-info" id="delete-post" tabindex="-1" role="dialog">
                             
                             <div class="modal-dialog" role="document">
                             
                             <div class="modal-content">
                             
                             <div class="modal-header">
                             
                             <div class="modal-title" id="delete-postLabel">  Apakah anda yakin ingin menghapus postingan ini ? </div>
                              <button type="button" data-dismiss="modal" class="close" aria-label="Close">
                              <span aria-hidden="true"> x </span>  </button>
                              
                              
                              
                              </div>
                              
                             
                              
                              <div class="modal-body"> 
                              <div id="deletepost-info"></div>
                              
                              <div class="text-muted"> Apakah anda yakin ingin menghapus postingan ini " <strong id="deletepost-title"></strong> " Tindakan ini tidak dapat di urungkan.
                  
                 <div class="form-group">            
                 <input type="text" class="deletepost-input form-control" readonly="readonly" value="">
                              </div>
                              
                              <div class="form-group">
                              
                              <textarea id="deletepost-input form-control" rows="5"></textarea>
                              
                              </div> 
                               
                                 </div>
                                 
                                    <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-dark" data-dismiss="modal"> Batal </button>
                                    
                                    <button type="button" onclick="deletePost" class="btn btn-danger"> Hapus </button>
                                    
                                    </div>
                                    
                                    </div>
                                    
                                    </div> 
                                    </div>
                                    
                                    </div>
                                    
 <!-- Confir Delete -->
 
  <div class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="deletePost" aria-hidden="true">
    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title"> Hapus Postingan Ini ? </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
                    
     <div class="modal-body">
     
     <div class="post-notification"></div>
     
     <div class="alert alert-info border"> Apakah anda yakin ingin menghapus postingan ini, postingan yang di hapus tidak dapat di kembalikan lagi. </div>
     
     <div class="form-group">
     
     <input type="hidden" name="id" id="post-id" value="">
     
     <label for="post-title"> Judul Artikel  </label>
     
     <input type="text" class="form-control" value="" id="post-title" readonly> 

     
      </div>
      
      <div class="form-group">
      
      <label for="post-content"> Konten </label>
      
      <textarea id="post-content" class="form-control" rows="8" readonly></textarea>
      
      </div>
      
      </div>
      
          <div class="modal-footer">
          
          <button class="btn btn-danger text-white" type="button" data-dismiss="modal"> Batal </button>
          
            <button type="button" class="btn btn-primary text-white" id="btn-deletepost">  Hapus  </button>
            
          </div>
             
        </div>
        
      </div>
      
    </div>
    
    
                                          
 <!-- Result Post -->
 
 <div id="post-result"></div>     
 
     
 <script type="text/javascript">
 
 $(document).ready(function(){
    
   getPost('/api/api_post/datapost', '', 'publish'); // getPost 
   
   $("#deletePost").on('hide.modal.bs', function(){
      
      $(this).find(':input').val("");  // reset
      $(this).find('.post-notification').html("");
      
   });
   
   $("#deletePost").on('show.bs.modal', function(event){
      
      var fajar = $(this);
      
      var button = $(event.relatedTarget);
      
      var id = button.data('id');  // id
      
      var title = button.data('title'); // title
      
      var content = button.data('content');  // content
      
      // inner
      fajar.find('#post-title').val(title);
      fajar.find('#post-id').val(id);
      fajar.find('#post-content').val(content);
      
   });
   
   $("#btn-deletepost").on('click', function(event){
      
      event.preventDefault();
      
      var fajar = $('#deletePost');
      
      var id = fajar.find("#post-id").val();
      
      var error_timeout = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="close" data-dismiss="alert" aria-label="Close">&times; </button> Batas waktu koneksi habis (Connection timeout). </div>';
      
      var error_message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="close" data-dismiss="alert" aria-label="Close">&times; </button> Terjadi kesalahan saat memproses data. </div>';
      
      $.ajax({
         
         url : '/api/api_post/delete',
         data : { 'id' : id },
         type : 'POST',
         dataType : 'JSON',
         success : function(response) {
            
            if (response.status == "failure") {
               
               fajar.find('.post-notification').html(error_message);
               
               
            }
       else
            {
               
               fajar.modal('hide');
               getPost('/api/api_post/datapost', '', 'publish');
               
            }
            
         },
         error : function(xmlhttp, status, message) 
         {
            
            if (status == "timeout")
               {
                  
                  fajar.find(".post-notification").html(error_timeout);
                  
               }
         else
              {
                 
                 fajar.find(".post-notification").html(error_message);
                 
              }
            
         },
         beforeSend : function(){
         
         fajar.find("#btn-deletepost").removeClass("btn-primary").addClass("btn-info shadow").html('Menghapus... <i class="fas fa-spinner fa-spin"></i>');
         
         },
         complete : function(){
          
          fajar.find("#btn-deletepost").removeClass("btn-info shadow").addClass("btn-primary").html("Hapus");
          
         },
         timeout : 8000 // 8 second
         
      });
      
   });
   
 });
  
  function getPost(link, search, mode){
     
     var error_message = '<div class="alert alert-danger mt-2 alert-dismissible" role="alert"> <button type="button" class="close" aria-label="Close" data-dismiss="alert"> <span aria-hidden="true"> &times; </span> </button> Terjadi kesalahan saat memproses data. silahkan coba lagi nanti. </div>';
     
      $.ajax({  
     
       url : link,  
       
       data : 'q='+search+'&u='+mode,
       
       dataType : 'html',
       
       success : function(data){
          
       $("#post-result").html(data);
       },
       error : function(xmlhttp, status, message){
          $("#post-result").html(error_message);
                          
                    
         },
                
          beforeSend : function(){
                   
                   $("#loading-spin").removeClass('fa-search').addClass('fa-spinner fa-spin');
                   
                },
                
                complete : function(){
                   
                   $("#loading-spin").removeClass('fa-spinner fa-spin').addClass('fa-search');

                   
                }
         
         });
         
         return false;
     
    }
    
    function actionPost(id){
       
       $("#"+id).toggleClass('d-block');
       
    }
  
  </script>

<?php require_once(VIEWPATH.'admin/includes/footer.php'); ?>