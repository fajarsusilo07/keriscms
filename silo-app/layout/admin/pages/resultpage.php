<?php defined("BASEPATH") OR exit('access denies !'); ?>
  
  <div class="row">
  <div class="col-xs-12 col-sm-8">
  
  <div class="card my-3">
  
  <div class="card-header">
  <span class="card-title"> Kelola Halaman </span>  </div>
  
  <div class="card-body">
  <?php foreach($page as $item):?>
  
  <ul class="list-group list-group-flush">
  
  <li class="list-group-item"> <div id="info-page" data-id="<?php echo $item['id'];?>" onclick="infoPage($(this).attr('data-id'));"> <i class="fas fa-book mr-2"></i> <?php echo $item['name'];?> </div>  </li>
  <div id="<?php echo $item['id'];?>" class="d-none list-group-item bg-light"> 
  
  <a href="#" data-toggle="modal" data-target="#editpage" data-id="<?php echo $item['id'];?>" data-name="<?php echo $item['name'];?>" data-content="<?php echo htmlentities($item['content']);?>" data-permalink="<?php echo $item['permalink'];?>">
 <i class="fas fa-edit ml-1 text-dark"></i> </a> 

 </li>  
    </ul>
    
    <?php endforeach;?>
      </div>
         </div>
        
         <!-- Pagination -->
         <?php echo $pagination;?>
         
           </div>
           </div>
    