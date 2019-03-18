<?php defined('BASEPATH') OR exit('access denied !'); ?>
 <div class="row">
 
    <div class="col-xs-12 col-md-8">
     
       <div class="card mb-3">

       <div class="card-header"> Kelola Berkas </div>
       
       <div class="card-body">
       <ul class="list-group list-group-flush">
       <?php foreach($file as $list => $item):?>
       
        <li class="list-group-item" data-id="<?php echo $item['id'];?>" data-name="<?php echo $item['filename'];?>" onclick="return selectedFile($(this).attr('data-id'),$(this).attr('data-name'));"> <i class="fas fa-file text-primary mr-2"></i>
       
    <?php echo $item['filename'];?> </li>
        
   <li class="<?php echo $item['id'];?> d-none list-group-item bg-light"> 
   
   <a href="#" data-toggle="modal" data-target="#edit" data-filename="<?php echo $item['rawname'];?>" data-id="<?php echo $item['id'];?>" data-extension="<?php echo $item['file_ext'];?>"> <i class="fa fa-pen-square ml-1 text-dark"></i></a> 
   
  <a href="#" data-toggle="modal" data-target="#download" data-id="<?php echo $item['id'];?>" data-url="<?php echo base_url('content/download/'.$item['filename']);?>" data-date="<?php echo $item['date'];?>" data-filename="<?php echo $item['rawname'];?>" data-file-ext="<?php echo $item['file_ext'];?>" data-file-size="<?php echo $item['size'];?>"> <i class="fas fa-info-circle ml-3 text-dark"></i> </a> </li>
        
       <?php endforeach;?>
     
     </ul>
     
       </div>
           
           </div>
       
        
       <?php echo $pagination;?>
       
                 </div>
                    
                     </div>
                         