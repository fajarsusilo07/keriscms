
 <script>
 
  jQuery(function(){
     
     jQuery(".btn").on('click', function(){
        
      jQuery.ajax({
         
         url : '/install/response.php',
         type : 'POST',
         dataType : 'JSON',
         data : jQuery("#form-install").serialize(),
         success : function(response)
         {
            if (response.status == "success")
            {
               jQuery("#error-message").html('<div class="alert alert-success" role="alert">'+response.message+'</div>');
               jQuery(".text-danger").html("");
            }
            else if (response.status == "dberror")
            {
               jQuery("#error-message").html('<div class="alert alert-danger alert-dismissible">'+response.message+'</div>');
               jQuery(".text-danger").html("");
            }
            else
            {
              jQuery("#error-message").html("");
               jQuery.each(response.message, function(key, value)
               {
                  jQuery("#m-"+key).html(value);
               });
            }
         },
         error : function(xml, status, error)
         {
            if (status == "timeout")
            {
               jQuery("#error-message").html('<div class="alert alert-danger alert-dismissible"> Koneksi gagal, silahkan periksa koneksi internet anda ! </div>');
               jQuery(".text-danger").html("");
            }
            else
            {
               jQuery("#error-message").html('<div class="alert alert-danger alert-dismissible"> Terjadi kesalahan saat memproses data ! silahkan coba lagi </div>');
               jQuery(".text-danger").html("");
            }
         },
         beforeSend : function()
         {
            jQuery("#loader").addClass("fas fa-spin fa-spinner ml-2");
         },
         complete : function()
         {
            jQuery("#loader").removeClass();
         },
         timeout: 8000
      })
    });
  });
 </script>
 
</body>
</html>