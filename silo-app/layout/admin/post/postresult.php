<?php defined('BASEPATH') OR exit('access denied !'); ?>
 
 <!-- Row -->

  <div class="row"> 
 
  <!-- col-12 col-md-8 -->
  
  <div class="col-12 col-md-8 my-3">
  
  <div class="card shadow">
  
  <div class="card-header">
  Kelola Postingan </div>
  
  <div class="card-body">
  
  <ul class="list-group list-group-flush">
  
  <?php foreach ($list as $item):
 ?>
  
   <li class="list-group-item list-group-item-light">
  
     <span data-id="<?php echo $item['id'];?>" onclick="actionPost($(this).attr('data-id'));" class="text-dark" style="word-wrap:break-word; !important;">
    <i class="fas fa-pen-square mr-2"></i> <?php echo $item['title'];?>   </span> 
   
   </li>
   
   <li class="list-group-item d-none" id="<?php echo $item['id'];?>"> 
   
   <a href="<?php echo site_url('admin/post/edit/'.$item['id']);?>" class="mr-3"> <i class="fas fa-edit"></i> </a>
   
  <span data-title="<?php echo $item['title'];?>" data-content="<?php echo htmlentities($item['content']);?>" data-id="<?php echo $item['id'];?>" data-toggle="modal" data-target="#deletePost"> <i class="fas fa-times-circle text-danger"></i>  </span>
  
  <?php if ($item['status'] == 1):?>
  
  <a href="<?php echo site_url($item['permalink']);?>" class="ml-3"> <i class="fas fa-eye"></i> </a>
  
  <?php endif;?>
   
   </li>
   
   <?php endforeach;?>
   
   </ul>
   
   </div>
   
   </div>
  
  
        
 <!-- Pagination  -->
 
 <?php echo $pagination;?>
 
	 <!--/.col-12 col-md-8 -->
	   
	     </div>
	        
	        <!-- /.row -->
	        
	         </div>
	         