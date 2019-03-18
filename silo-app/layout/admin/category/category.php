<?php defined('BASEPATH') OR exit('access denied !'); 
 require VIEWPATH.'admin/includes/header.php'; ?>
 
   <div class="row">
   	
     <div class="col-12 col-md-8">
     	
        <div class="input-group my-2">
        	
           <div class="input-group-append">
     

     <div class="input-group-text"> <i class="fas fa-search" id="search-spinner"></i> 
     </div>
        </div>
     
	     <input type="text" class="form-control" onkeyup="getCategory('/api/api_category/datacategory', this.value)" value="">
     
     </div>
     
       <button type="button" data-toggle="modal" data-target="#addcategory-modal" class="btn btn-primary mt-1 shadow">  Tambah Kategori  </button> 
 
       </div>
       
          </div>
   
   <!-- Add Category -->
   
   <div class="modal fade" id="addcategory-modal" tabindex="-1" role="dialog" aria-labelledby="addcategory-modal" aria-hidden="true">
   
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
           
            <div class="modal-title"> 
                   Buat Kategori Baru
                            </div>
                            
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              
            </button>
            
          </div>
          
          <form action="" id="form-addcategory" role="form">
          
          <div class="modal-body"> 
          	
         <!-- Notification -->
         	
         <div id="addcategory-info"></div>
          
         <div class="form-group"> 
          
          <label for="addcategory-name">	 Nama Kategori  	</label>
          
          <input type="text" name="name" class="form-control" id="addcategory-name" value="">
          
          <div class="message"></div>
          
          </div>
          
          <div class="form-group">
          
          <label for="addcategory-url"> URL Kategori </label>
          
          <input type="text" name="permalink" class="form-control" id="addcategory-url" value="">
          
          <div class="message"></div>
          
          </div>       
           
          </div>
          
         <div class="modal-footer">
          
            <button type="button" class="btn btn-danger text-white" data-dismiss="modal"> Batal </button>
            
            <button type="button" class="btn btn-primary text-white" id="btn-addcategory" onclick="return addCategory();"> Simpan </button>
            
              </div>
              
          </form>
          
        </div>
        
      </div>
      
    </div>
    
    
  <!-- Delete Category -->
  
   <div class="modal fade" id="deletecategory-modal" tabindex="-1" role="dialog" aria-labelledby="deletecategory-modal" aria-hidden="true">
   
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title">  Hapus Kategori  </div>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	
              <span aria-hidden="true"> &times; </span>
              
            </button>
            
          </div>
          
          <form action="" method="POST" role="form">
          
          <div class="modal-body"> 
          
          <!-- Notification -->
          	
          <div id="deletecategory-info"></div>
          
          <small class="text-muted"> Apakah kamu yakin ingin menghapus kategori ini? kategori yang di hapus tidak dapat di pulihkan lagi. </small>
          
          <input type="hidden" name="id" id="deletecategory-id" value="">
          
          <div class="form-group"> 
          
          <label for="deletecategory-name"> Nama Kategori </label>
          
          <input type="text" class="form-control" id="deletecategory-name" value="" readonly>
          </div>
          
          <div class="form-group">
          <label for="deletecategory-slug"> URL Kategori </label>
          
          <input type="text" class="form-control" id="deletecategory-slug" value="" readonly>
          
          </div>        
          
          </div>
          
          <div class="modal-footer">
          
          <button type="button" class="btn btn-dark text-white" data-dismiss="modal"> Batal </button>
          
            <button type="button" class="btn btn-danger text-white" id="btn-deletecategory"> Hapus </button>
            
           </div>
          
         </form>
          
        </div>
        
      </div>
      
    </div>
  
    
  <!-- Edit Category -->
  
   <div class="modal fade" id="editcategory-modal" tabindex="-1" role="dialog" aria-labelledby="editcategory-modal" aria-hidden="true">
   
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <div class="modal-title">  Edit Kategori </div>
            
            <button type="button" data-dismiss="modal" class="close" aria-label="Close">
              <span aria-hidden="true">&times; </span>
              
            </button>
            
          </div>
          
          <form action="" method="POST" id="form-editcategory" role="form">
          
          <div class="modal-body"> 
          
          <div id="editcategory-info"></div>
          
          <input type="hidden" name="id" id="editcategory-id" value="">
       
          <div class="form-group"> 
          
          <label for="editcategory-name"> Nama Kategori </label>
          
          <input type="text" name="name" class="form-control" id="editcategory-name" value="">
          
          <div class="message"></div>
          
          </div>
          
          <div class="form-group">
          
          <label for="editcategory-slug"> URL Kategori </label>
          
          <input type="text" name="permalink" class="form-control" id="editcategory-slug" value="">
          
          <div class="message"></div>
          
          </div>     
             
          </div>
          
          <div class="modal-footer">
          
		<button type="button" class="btn btn-danger text-white" data-dismiss="modal"> Batal   </button>
            
            <button type="button" class="btn btn-primary text-white" id="btn-editcategory"> Simpan </button>
            
             </div>
          
          </form>
          
        </div>
        
      </div>
      
    </div>
    
 <!-- Content -->
  
	<div id="category-result"></div>
 
 <script type="text/javascript">
 
  $(document).ready(function(){
   // tampilkan daftar kategori
   getCategory('/api/api_category/datacategory',''); 
   // permalink otomatis terisi sesuai dengan nama kategori
   $("#addcategory-url").slugger({
   	 source : "#addcategory-name"
   });
   $("#editcategory-slug").slugger({
      source : "#editcategory-name"
   });
  
  // ketika modal 'Tambah Kategori' close, reset semua input
	$("#addcategory-modal").on('hide.bs.modal', function(){
  	
  	var fajar = $(this);
  
  	fajar.find(':input').val(""); // reset all input form
  	fajar.find('#addcategory-info').html("");  // reset all message
  	fajar.find(".message").html("");
  });
  
  // ketika modal 'Edit kategori close '
  $("#editcategory-modal").on('hide.bs.modal', function(){
  	
  	var fajar = $(this);
  
  	fajar.find(':input').val(""); // reset all input form
  	fajar.find('#editcategory-info').html("");  // reset all message
  	fajar.find(".message").html("");
  });
  
  // ketika modal delete kategori close
  $("#deletecategory-modal").on('hide.bs.modal', function(){
  	
  	var fajar = $(this);
  
  	fajar.find(':input').val(""); // reset all input form
  	fajar.find('#deletecategory-info').html("");  // reset all message
  	fajar.find(".message").html("");
  });
  
  
 // ketika modal 'edit kategori open
  $("#editcategory-modal").on('show.bs.modal', function(event){

   var button = $(event.relatedTarget);
   var fajar = $(this);
   var id = button.data('id');
   var name = button.data('name');
   var slug = button.data('slug');
   
   fajar.find('#editcategory-name').val(name);
   fajar.find('#editcategory-slug').val(slug);
   fajar.find('#editcategory-id').val(id);
   
   });
   
   
 // ketika modal 'delete kategori open
  $("#deletecategory-modal").on('show.bs.modal', function(event){

   var button = $(event.relatedTarget);
   var fajar = $(this);
   var id = button.data('id');
   var name = button.data('name');
   var slug = button.data('slug');
   
   fajar.find('#deletecategory-name').val(name);
   fajar.find('#deletecategory-slug').val(slug);
   fajar.find('#deletecategory-id').val(id);
   
   });

   
 // ketika button 'Edit Kategori ' di klik , jalankan AJAX
   $("#btn-editcategory").on('click', function(event){
      
   	event.preventDefault();
   
   	  var error_message = '<div class="alert alert-danger"> Terjadi kesalahan saat memproses data. </div>';
   
      var error_timeout = '<div class="alert alert-danger"> Batas waktu koneksi habis. (connection timeout) </div>';
      var dataSend = {'id' : $("#editcategory-id").val(), 'name' : $("#editcategory-name").val(), 'permalink' : $("#editcategory-slug").val()};
      
      var fajar = $("#editcategory-modal");
      
      var icon_spinner = '<i class="fas fa-spinner fa-spin"></i>';
      
   	$.ajax({
   		
   		url : '/api/api_category/edit',  // url 
   
   		type : 'POST',   //  method type
   
   		data : dataSend,  // data 
   
   		dataType : 'JSON',  // data response JSON
   
   		success : function(response){     // request success
   			
   			if (response.status == "success"){
   				
   				$("#editcategory-modal").modal('hide');
   				
   				getCategory('/api/api_category/datacategory', '');
   				
   			}
   			      
   			      else if (response.status == "failure"){
   			      	
   			      	
   			      	$("#editcategory-info").html(error_message);
   			      	
   			      }
   			      
   			           else
   			                   {
   			                   	
   			                   	 fajar.find(".message").eq(0).html('<p class="form-text text-danger mt-2">'+response.message.name+'</p>');
   			                     fajar.find(".message").eq(1).html('<p class="form-text text-danger mt-2">'+response.message.permalink+'</p>');                 	
   			                   }
   			
     		},
     		error : function(XMLHttpRequest, status, message){     //  request failure
     			
     			if (status == "timeout"){    // request timeout
     				
     				  $("#editcategory-info").html(error_timeout);
     				
     			}
     			
     		    	else
     		    	
     		    	       {
     		    	       	
     		    	       	$("#editcategory-info").html(error_message);
     		    	       	
     		    	       }
     			
     		},
     		beforeSend : function(){
     			
     			$("#btn-editcategory").removeClass('btn-primary').addClass('btn-info active').html('Menyimpan... '+icon_spinner);      //  before send, add spinner for waiting response
     			
     		},
     		complete : function(){    // request completed
     			
     			$("#btn-editcategory").removeClass('btn-info active').addClass('btn-primary').html('Simpan');
     			
     		}
     		
   		
 	});
   	
  });
  
  // ketika button 'delete kategori' di klik
  $("#btn-deletecategory").on('click', function(event){
  	
  	event.preventDefault();
  	
  	var id = $("#deletecategory-id").val();
  	
  	var icon_spinner = '<i class="fas fa-spinner fa-spin"></i>';
  	
  	var button = $(this);
  	
  	var error_message = '<div class="alert alert-danger alert-dismissible" role="alert"> Terjadi kesalahan saat memproses data. <button type="button" close="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true"> &times; </span> </div>';
  	
  	
  	$.ajax({
  		
  		   url : '/api/api_category/delete',  // url
  
  		   type : 'POST',   // method type
  
  		   data : {'id': id},   // data 
  
  		   dataType : 'JSON',  // data response 
  		   success : function(response){
  		   	
  		   	if (response.status == "success"){
  		   		
  		   		$("#deletecategory-modal").modal('hide');
  		   		
  		   		getCategory('/api/api_category/datacategory', '');
  		   		
  		    	}
  		    	
  		    	 
  		    	   else
  		    	   
  		    	          {
  		    	          	
  		    	          	$("#deletecategory-info").html(error_message);
  		    	          	
  		    	          }
  		   	
  		   },
  		   error : function(){
  		   	
  		   	$("#deletecategory-info").html(error_message);
  		   	
  		   },
  		   beforeSend : function(){
  		   	
  		   	button.removeClass('btn-primary').addClass('btn-info shadow').html('Menghapus...'+icon_spinner);
  		   	
  		   },
  		   
  		   complete : function(){
  		   	
  		   	button.removeClass('btn-info shadow').addClass('btn-primary').html('Hapus');
  		   	
  		   }
  		   
  		   
         	});
  	
  	  });

  });
  	
  
  function getCategory(url, search){
  	
  	var error_message = '<div class="alert alert-danger"> Terjadi kesalahan saat memproses data. </div>';
  	
  	var error_timeout = '<div class="alert alert-danger"> Batas waktu koneksi habis. (connection timeout) </div>';
  	
  	$.ajax({
  		
  		url : url,
  		type: 'GET',
  		data : 'q='+search,
  		dataType : 'html',
  		success : function(data){
       
       	$("#category-result").html(data);
  			
  		},
  		error : function(XMLHttpRequest, status, message){
  			
  			if (status == 'timeout'){
  				
  				  $("#category-result").html(error_timeout);
  				  
  			}
  			  
  			     else
  			              {
  			            	
  			            	   $("#category-result").html(error_message);
  			            	
  			             }
  			
           		},
           		
           		beforeSend : function(){
           			
           			$("#search-spinner").removeClass('fa-search').addClass('fa-spinner fa-spin');
           			
           		},
           		complete : function(){
           			
           				$("#search-spinner").removeClass('fa-spinner fa-spin').addClass('fa-search');
    
           			
           		},
           	  timeout : 8000 // 8 second
           	
  		
      	});
      	
      	
      	return false;
   	
  }
  
  function addCategory(){    // addCategory
  
    var error_message = '<div class="alert alert-danger"> Terjadi kesalahan saat memproses data. </div>';
  
  	var error_timeout = '<div class="alert alert-danger"> Batas waktu koneksi habis. (connection timeout) </div>';
  	
  	var icon_spinner = '<i class="fas fa-spin fa-spinner"></i>';
  
    var field = $("#form-addcategory").serialize();
    
    $.ajax({
    	 
    	 url : '/api/api_category/create',
    	 type : 'POST',
    	 data : field,
    	 dataType : 'JSON',
    	 success : function(response){
    	 	
    	 	if (response.status == "success"){
    	 		  
    	 		  $("#addcategory-modal").modal('hide');
    	 		  
    	 		  getCategory('/api/api_category/datacategory', '');
    	 		  
    	 		  	
    	   	}
    	   	   
    	   	    else if (response.status == "failure"){
    	   	           	
    	   	           	$("#addcategory-info").html(error_message);
    	   	           	
    	   	           }
    	   	             
    	   	          
    	   	          else
    	   	            
    	   	               {
    	   	                  	$(".message").eq(0).html('<p class="form-text text-danger mt-2">'+response.message.name+'</p>');
    	   	                  	
    	   	                  	$(".message").eq(1).html('<p class="form-text text-danger mt-2">'+response.message.permalink+'</p>');

    	   	                  	
    	   	                }
    	 	
    	           },
    	           error : function(XMLHttpRequest, status, message){
    	           	
    	           	if (status == "timeout"){
    	             	$("#addcategory-info").html(error_timeout);   	
    	         
    	           }
    	              
    	              else
    	                     {
    	                     	
    	                     	$("#addcategory-info").html(error_message);
    	                     	
    	               }
    	              
    	          },
    	          beforeSend : function(){
    	          	
    	          	$("#btn-addcategory").html('Menyimpan...'+icon_spinner).removeClass('btn-primary').addClass('btn-info shadow');
    	          	
    	          },
    	          complete : function(){
    	          	
    	          	$("#btn-addcategory").html('Simpan').removeClass('btn-info shadow').addClass('btn-primary');
    	          	
    	          },
    	          timeout : 8000 // 8 second
    	           
           });
           
           return false;
  
        }
        
        function action(id){
	
        	$("#action-"+id).toggleClass('d-block');
        
        }
 	 </script>
 
 <?php require_once(VIEWPATH.'admin/includes/footer.php');?>   