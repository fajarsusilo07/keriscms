<?php defined('BASEPATH') OR exit('No direct script accesss allowed');
 require_once(VIEWPATH.'admin/includes/header.php');?>
 
  <!-- Breadcrumbs-->
        
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php current_url();?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
          
          <div class="row">
          
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-dark o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-pen-square"></i>
                  </div>
                  <div class="mr-5"> <span class="badge badge-secondary"> <?php echo $total_post;?> </span> Artikel </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/post">
                  <span class="float-left">Lihat semua Artikel </span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
          
          <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-dark o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-pen-square"></i>
                  </div>
                  <div class="mr-5"> <span class="badge badge-secondary"> <?php echo $total_category;?> </span> Kategori </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/category">
                  <span class="float-left">Lihat semua kategori </span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-dark o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-book"></i>
                  </div>
                  <div class="mr-5"> <span class="badge badge-secondary"> <?php echo $total_pages;?> </span> Halaman </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/page">
                  <span class="float-left">Lihat semua halaman </span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            
            </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-dark o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-file"></i>
                  </div>
                  <div class="mr-5"> <span class="badge badge-secondary"> <?php echo $total_file;?> </span> Berkas </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/file">
                  <span class="float-left">Lihat semua berkas</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                
                  </a>
            
              </div>
           
            </div>
            
          </div>
            
<?php require_once(VIEWPATH.'admin/includes/footer.php');?>