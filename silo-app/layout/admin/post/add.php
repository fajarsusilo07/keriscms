<?php defined('BASEPATH') OR exit('access denied !');
 require_once(VIEWPATH.'admin/includes/header.php'); ?>

  <div class="row">
 
  <div class="col-md-10">
  
  <div id="postAlert"></div>
  
  <div class="card shadow my-4">
  
     <div class="card-header"> Buat Artikel </div>
     <div class="card-body">
     
  <form method="POST" id="form-addPost" role="form">
 
        <div class="form-group"> 
           <label for="title"> Judul artikel </label>
           <input type="text" name="title" id="title" class="form-control" value="">
   
      <div class="message-title text-danger mt-2 form-text"></div>
         
          </div>
          
    <div class="form-group">
      
      <label for="permalink"> Permalink  </label>
        
         <input type="text" name="permalink" class="form-control" id="permalink" value=""/> 
   
    <div class="message-permalink form-text text-danger"></div>
         
       </div>

 <div class="form-group"> 
 <label for="text"> Konten artikel </label>
 <textarea class="form-control" name="content" id="text" rows="15"></textarea>
 
  <div class="message-content text-danger form-text"></div>
         
  </div> 
 
 <div class="form-group">
 
 <label> Kategori </label> 
 
 <?php foreach($category as $cat){ 
 
    $checked=($cat['id'] == 1) ? 'checked':''; ?>
     <div class="custom-control custom-checkbox">
    <input type="checkbox" name="label[]" id="category_<?php echo $cat['id'];?>" value="<?php echo $cat['id'];?>" class="custom-control-input" <?php echo $checked;?>>
    <label for="category_<?php echo $cat['id'];?>" class="custom-control-label"> <?php echo $cat['name'];?> </label>
    </div>
     <?php }  ?>  
     
     
     <div class="message-category form-text text-danger mt-2"></div>
     
     </div> 
    
    <div class="custom-control custom-checkbox mt-3">
    <input type="checkbox" class="custom-control-input" name="nl2br" value="1" id="nl2br" checked="checked"> 
   <label for="nl2br" class="custom-control-label"> Gunakan Baris Baru Otomatis. </label>
  
    </div>
    
    <div class="form-group mt-3">
    
    <label for="status"> Status </label>
   
    <select class="custom-select" name="status" id="status">
    <option value="1"> Terbitkan </option>
    <option value="0"> Konsep </option>
    </select> </div>
    
    
    <button type="submit" class="btn btn-primary btn-block text-white" id="btn-addPost"> Terbitkan </button>
    
   
   </form>
    
       </div>
       
          </div>
         
             </div>
             
                </div>
                     
                     
 <script type="text/javascript">

 $(document).ready(function(){
    $("#permalink").slugger({
       source : "#title"
    });
    $("#btn-addPost").on('click', function(event){
    	
    	event.preventDefault();
    	
    	var button = $(this);
    	
    	var message_timeout = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Connection timeout <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
    	
    	var message_error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">  Terjadi Kesalahan Saat Memproses Data ! <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button>   </div>';
    	
    	var message_success = '<div class="alert alert-success alert-dismissible fade show" role="alert">  Artikel berhasil di terbitkan, Ke <a href="/admin/post" class="text-info"> Daftar artikel </a>  <button type="button" data-dismiss="alert" aria-label="Close" class="close"> <span aria-hidden="true"> &times; </span> </button> </div>';
    	
    	var loading = '<i class="fas fa-spin fa-spinner"></i>';
    	
    	var dataSend = $("#form-addPost").serialize();
    	
    	$.ajax({
    		  
    		  url : '/api/api_post/create',
    		  data : dataSend,
    		  type : 'POST',
    		  dataType : 'JSON',
    		  success : function(response){
    		  	
    		  	if (response.status == "success"){
    		  		$("#postAlert").html(message_success);
    		  		$(".message-category, .message-content, .message-permalink, .message-title").html("");
    		  		
    		  		
    		  	}
    		  	
    		  	   else if (response.status == "failure"){
    		  	   	
    		  	   	$("#postAlert").html(message_error);
    		  	   	
    		  	   	
    		  	   }
    		  	         
    		  	       else
    		  	       
    		  	             {
    		  	             	
    		  	             	$.each(response.message, function(key, value){
    		  	             		
    		  	             		$(".message-"+key).html(value);
    		  	             
    		  	       });
    		  	          	
    		  	          	
    		       }
    		  
    	   	},
    	   	error : function(XMLHttpRequest, status, message){
    	   		if (status == "timeout"){
    	   			
    	   			  $("#postAlert").html(message_timeout);
    	   			
    	   		}
    	   		
    	   		    else
    	   		    
    	   		           {
    	   		           	
    	   		           	$("#postAlert").html(message_error);
    	   		           	
    	   		         }
    	   		
    	        	},
    	        	beforeSend : function(){
    	        		
    	        		button.removeClass('btn-primary').addClass('bg-red shadow').html('Menyimpan '+loading);
    	        	
    	        	},
    	        	complete : function(){
    	        		
    	        		button.removeClass('bg-red shadow').addClass('btn-primary').html('Simpan');

    	        		
    	        	}
    		
      	});
    	
    });
    
  });
      </script>     
<?php require_once(VIEWPATH.'admin/includes/footer.php'); ?>