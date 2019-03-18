<?php defined('BASEPATH') OR exit('access denied !');
require_once(VIEWPATH.'admin/includes/header.php');
?>
  <div class="row">
  <div class="col-md-8 my-3">
  <div class="input-group">
  <div class="input-group-append"><span class="input-group-text" id="load"> <i class="fas fa-search"></i> </span> </div>  

<input type="text" name="q" class="form-control" onkeyup="getFile('/api/api_file/content', this.value);">
       </div>
       
  <button type="button" class="btn btn-primary shadow my-2" data-toggle="modal" data-target="#upload"> Unggah </button>
 
    </div>
    
        </div>
  <!-- Notification -->
  
  <div id="result-file-info"></div>
  
  <!-- Result File -->
  
  <div id="result-file"></div>
  
  
  
   <!-- Upload File -->
   
    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="uploadLabel" aria-hidden="true">
    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title"> Unggah Berkas </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
          
          <form action="" enctype="multipart/form-data" id="uploading-file" accept-charset="utf-8" method="POST"> 
          
          
     <div class="modal-body">
     
     <div class="alert alert-info border"> mendukung format berkas jpg, png, bmp, jpeg, gif, apk, mp3, mp4, pdf, doc, docs, odt, odf </div>
     
     <div class="custom-file mt-3"> 
     <input type="file" class="custom-file-input" id="file" name="userfile"> 
     
     <label class="custom-file-label" for="file" id="upload-spin"> Pilih Berkas </label>
     
     <div class="message form-text text-danger mt-3"></div>
          
      </div>
      
      </div>
      
          <div class="modal-footer">
          
          <button class="btn btn-danger text-white" type="button" data-dismiss="modal"> Batal </button>
          
            <button type="button" class="btn btn-primary text-white" id="btn-uploading"> Unggah  </button>
            
          </div>
          
          </form>
             
        </div>
        
      </div>
      
    </div>
    
    
    
    <!-- Detail File -->
   
    <div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="downloadLabel" aria-hidden="true">
    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title" id="uploadLabel"> Rincian Berkas </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            
              <span aria-hidden="true">×</span>
            </button>
            
          </div>
          
  <form action="" method="POST">
     
     <div class="modal-body">
     
     <div class="notification"></div>
 
     <input type="hidden" name="id" value="" id="data-id">
     
     <div class="table-responsive">
     
     <table class="table">
    
     <tbody>
     
     <tr> 
     
     <td> Nama Berkas </td> <td> : </td> <td id="data-filename"> </td> </tr>
     <tr> <td> Jenis Berkas</td> <td> : </td> <td id="data-file-ext"></td>  </tr>
     <tr>
     <td> Tanggal Unggah  </td> <td> : </td> <td id="data-file-date"></td>  </tr>
     <tr> <td> Ukuran </td> <td> : </td> <td id="data-file-size"></td> </tr>
     
     </tbody>
     
     </table>
     
     </div>
     
     <div class="input-group">
     
     <div class="input-group-append">
     
     <span class="input-group-text"> URL Download </span>
     </div>
     <input type="text" id="data-file-url" value="" class="form-control">
     </div>
           
      </div>
      
          <div class="modal-footer">
          
          <button class="btn btn-primary" type="button" data-dismiss="modal"> Batal </button>
            
            <button type="button" id="delete-file" class="btn btn-primary"> Hapus </button>
            
            <a class="btn btn-primary" href="" id="link-download"> Unduh </a>
          </div>
             </form>
        </div>
      </div>
    </div>
    
    
   <!-- Edit File -->
   
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title" id="editLabel"> Rename Berkas </div>
            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              
            </button>
            
          </div>
                  
     <div class="modal-body">
          
     <div class="notification"></div>
     
     <input type="hidden" name="id" id="edit-fileid" value="">
     
     <div class="input-group mt-3"> 
     
     <input type="text" class="form-control" id="edit-filename" name="filename" value=""> 
     
     <div class="input-group-append" id="edit-filename-append"></div>
     
      </div>
      
      </div>
      
          <div class="modal-footer">
         
          <button class="btn btn-danger text-white" type="button" data-dismiss="modal"> Batal </button>
          
            <button type="button" class="btn btn-primary text-white" id="btn-editfile"> Simpan </button> 
            
          </div>
             
        </div>
        
      </div>
      
    </div>
    
   
 <script type="text/javascript">
 
 $(document).ready(function(){
  // list file
  getFile('/api/api_file/content',"");
   
   // Uploading file
    $("#btn-uploading").on('click',function(event){
       
       event.preventDefault();
       
       var File = new FormData($("#uploading-file")[0]);   // data file
       
       var fajar = $("#upload");
       
       var icon_spinner = '<i class="fas fa-spin fa-spinner"></i>';
       
       
       
   $.ajax({
      
        url : '/api/api_file/upload',  // url
        type : 'POST',  // method type
        
        data : File,   // data
        
        processData : false,
        
        contentType : false,    
        
        dataType : 'JSON',   // type data response
        success : function(response){
           
     if (response.status == "success"){        
     
            fajar.modal('hide');
            
            fajar.find(".message").text("");
            
            getFile('/api/api_file/content','');
                     
           }
             else if (response.status == "failure"){
                
                fajar.find(".message").text(response.message);
             }
        },
        error : function(){
           
           fajar.find(".message").text("Terjadi kesalahan saat memproses data.");
        },
        beforeSend : function(){
           
         fajar.find("#upload-spin").html('Memproses...');
         
         fajar.find("#btn-uploading").removeClass('btn-primary').addClass('btn-info shadow').html("Mengunggah... "+icon_spinner);
         
        },
        complete : function(){
         
          fajar.find("#upload-spin").html('Pilih Berkas');
           
          fajar.find("#btn-uploading").removeClass('btn-info shadow').addClass('btn-primary').html('Unggah');
          
          
        }
        
   });
      
  });
  
  // ketika semua modal close
  $("#upload, #download, #edit").on('hide.bs.modal', function(){
     
    var fajar = $(this);
     
    fajar.find(':input').val("");   // reset all input
     fajar.find('.notification').html("");   // reset all message
      
  });
  
  // download modal show
  $("#download").on('show.bs.modal', function(event){
     
     var button = $(event.relatedTarget);
     var filename = button.data('filename'); 
     var file_ext = button.data('file-ext');
     var file_size = button.data('file-size');
     var file_date = button.data('date');
     var file_url = button.data('url');
     var file_id = button.data('id');
     var fajar = $(this);
     
     fajar.find("#data-id").val(file_id);
     fajar.find("td#data-filename").html(filename);
     fajar.find('td#data-file-ext').html(file_ext);
     fajar.find("td#data-file-size").html(file_size);
     fajar.find("td#data-file-date").html(file_date);
     fajar.find("#data-file-url").val(file_url);
     fajar.find('#link-download').attr('href',file_url);
      
     });
     
     // Hapus berkas on click
     $("#delete-file").on('click',function(e){
     
       e.preventDefault();
       
       var fajar = $("#download");
       
       var file_id = fajar.find("#data-id").val();
       
       var error_message = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Terjadi kesalahan saat memproses data . <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'></span> </button> </div>";
      
      var error_timeout = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Batas waktu koneksi habis (connection timeout). <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'></span> </button> </div>";
      
     var icon_spinner = '<i class="fas fa-spin fa-spinner"></i>';
       
       $.ajax({
          
           url : '/api/api_file/delete',  // URL
           
           type : 'POST',  // method type
           
           data : 'id='+file_id,  // data
           
           dataType : 'JSON',  //  data response
           success : function(response){
             
           if (response.status == "success"){
              
              fajar.modal("hide");
                           
              getFile('/api/api_file/content','');
           }
             else if (response.status == "failure")
                  {
                     
                     fajar.find(".notification").html(error_message);
                
                  }
             
           },
           error : function(XMLHttpRequest, status, message){
              
              if (status == "timeout"){
                 
                  fajar.find(".notification").html(error_timeout);
              }
               
                  else
                  
                         {
                            
                            fajar.find(".notification").html(error_message);
                            
                         }
       
           
           
           },
           beforeSend : function(){
             
             fajar.find("#delete-file").removeClass('btn-primary').addClass('btn-info shadow').html('Menghapus...'+icon_spinner);
             
           },
           complete : function(){
              
              fajar.find("#delete-file").removeClass('btn-info shadow').addClass('btn-primary').html('Hapus');
              
           }
    
     });
     
   });
   
   // ketika modal "edit" open
   $("#edit").on("show.bs.modal", function(event){
      
      var button = $(event.relatedTarget);
      
      var filename = button.data('filename');    // ambil value dari attribute data-filename
      
      var extension = button.data('extension');   // ambil value dari attribute data-extension
      
      var id = button.data('id');    // ambil value dari attribute data-id
      
      var fajar = $(this);
           
      fajar.find('#edit-filename').val(filename);
      
      fajar.find("#edit-filename-append").html('<span class="input-group-text">'+extension+'</span>');
      
      fajar.find("#edit-fileid").val(id);
      
   });
      
     // ketika button "edit" di click
      $("#btn-editfile").on('click',function(){
         
      var fajar = $("#edit");
          
      var id = fajar.find("#edit-fileid").val();
          
      var name = fajar.find("#edit-filename").val();  // ambil value dari input dengan id " edit-filename"
        
      var icon_spinner = '<i class="fas fa-spin fa-spinner"></i> ';
          
      var error_timeout = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Batas waktu koneksi habis (connection timeout) <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times; </span> </button> </div> ";
      
      var error_message = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Terjadi kesalahan saat memproses data. <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button> </div> ";

         $.ajax({   // jalankan AJAX
         
            url : '/api/api_file/rename',  // URL
            
            type : 'POST',   // method type
            
            data : 'id='+id+'&filename='+name,   // data
            
            dataType : 'JSON',  // response data
            
            success : function(response){
               
             if (response.status == "success"){
               
               fajar.modal('hide');
               
               getFile('/api/api_file/content','');
             }
             
             
               else if (response.status == "failure"){
                 
                 fajar.find(".notification").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'>  "+response.message+"  <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button> </div> ");
                  
               }
               
            },
            
            error : function(){
       
           fajar.find(".notification").html(error_message);
               
        },
         
          beforeSend : function(){
           
           fajar.find("#btn-editfile").removeClass("btn-primary").addClass("btn-info shadow").html("Menyimpan..."+icon_spinner);
           
            },
            complete : function(){
               
            fajar.find("#btn-editfile").removeClass("btn-info shadow").addClass("btn-primary").html("Simpan");
          
          
            }
     
       });
      
   });
   
 });
 
 function selectedFile(id,name){
    
   $("."+id).toggleClass('d-block');
   
  }
   
 function getFile(page, keyword){
    
   var link = page;
   
   var error_timeout = '<div class="alert alert-danger"> Batas waktu koneksi habis  (connection timeout) </div>';
   
   var error_message = '<div class="alert alert-danger"> Terjadi kesalahan saat memproses data. </div> ';
   
   $.ajax({
      
          url : link,
          
          type : 'GET',
          
          data : 'q='+keyword,
          
          dataType : 'html',
          
          success : function(data){
            
           $("#result-file").html(data);
           
          },
      
        error : function(XMLHttpRequest, status, message){
           
           if (status == "timeout"){
              
               $("#result-file-info").html(error_timeout);
               
           }
               
               else
                      
                      {
                         
                         $("#result-file-info").html(error_message);
                         
          }
    
       },
       beforeSend : function(){
          
          $("#load").html('<i class="fas fa-spinner fa-spin"></i>');
          
       },
       complete : function(){
          
          $("#load").html('<i class="fas fa-search"></i>');
       }
    });
    
    return false;
 }
 </script>
<?php require_once(VIEWPATH.'admin/includes/footer.php');?>