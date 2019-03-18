$(document).ready(function(){ 
 
 $("#btn-logout").click(function(e){
     e.preventDefault();   
     $.ajax({
        type: 'GET',
        url : '/api/api_auth/logout',
        dataType : 'JSON',
        success : function(data){
         window.location.href = '/user/login';
          
        },
        error: function(XMLHttp,status,err){
          alert("Terjadi Error : " +err+ " - Status : " +XMLHttp.status);
        },
        beforeSend : function(){
           $(".loading").show();
        },
        complete : function(){
           $(".loading").hide();
        }
        
        
     });
   }); 
 });