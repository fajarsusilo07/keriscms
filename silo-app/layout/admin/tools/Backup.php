<?php defined('BASEPATH') OR exit('access denied !');
 include_once(VIEWPATH.'admin/includes/header.php'); ?>
 <div class="col-md-8"> <div class="alert alert-info"> Cadangkan data anda seperti file, post, label dan pages dengan mudah.
 </div>
 <?php if ($message) { ?> <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" arial-label="Close"> <span aria-hidden="true"> &times; </span> </button> <?php echo $message;?> </div> <?php } ?>
 
 <form action="<?php echo current_url(); ?>" method="POST">
 <div class="form-group">
    <select class="form-control" name="action">
    <option value="sql"> Post (label, category, file) (Zip) </option>
    <option value="archive"> File (Zip Archive) </option>
    </select>
    </div>
    <input type="hidden" name="backup" value="yes">
    <button type="submit" class="btn btn-danger"> Cadangkan </button>
    </form>
    
    </div>
         </div>
              </div>
              
 <?php include_once(VIEWPATH.'admin/includes/footer.php'); ?>

 