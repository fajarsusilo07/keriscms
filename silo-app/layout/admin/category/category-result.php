<?php defined('BASEPATH') OR exit('access denied !'); ?>
 
 <div class="row">
  
   <div class="col-12 col-md-8">
  
     <div class="card my-3">
      
       <div class="card-header">
          Kelola Kategori </div>
          
       <div class="card-body"> 
         
       <ul class="list-group list-group-flush">
       <?php foreach ($list as $item):?>
       
       <li class="list-group-item list-group-item-light text-dark" id="<?php echo $item['id'];?>" onclick="action($(this).attr('id'));"> <i class="fas fa-tag mr-2"></i> <?php echo $item['name'];?> <span class="float-right badge badge-dark"> <?php echo $item['post'];?> </span> </li>
       
       <li class="list-group-item bg-light d-none" id="action-<?php echo $item['id'];?>"> 
       <a href="#" data-toggle="modal" data-target="#editcategory-modal" data-id="<?php echo $item['id'];?>" data-slug="<?php echo slug_category($item['permalink']);?>" data-name="<?php echo $item['name'];?>" class="badge badge-dark p-1"> Edit </a>
       
  <?php if ($item['post'] == 0 && ($item['id'] != 1)):?>
  
  <a href="#" data-toggle="modal" data-target="#deletecategory-modal" data-id="<?php echo $item['id'];?>" data-slug="<?php echo slug_category($item['permalink']);?>" data-name="<?php echo $item['name'];?>" class="badge badge-danger p-1"> Hapus </a>
  <?php endif;?>
    
 </li>
 
 <?php endforeach;?>
 
   </ul>
   
 
   </div>
      
      </div>
      
      <!-- Pagination -->
      
      <?php echo $pagination;?>
      
         </div>
           
           </div>
      