<?php 
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @package response
  */
  $path = $_SERVER['DOCUMENT_ROOT'];
  require_once(__DIR__.'/lib.install.php');
  
  // request bukan ajax
  if (!$silo->is_ajax())
  {
     header('Location: /install');
     exit;
  } 
  // Validasi host
   $silo->addValidate('host', 'DB Host', array('required'));
   // Validasi dbname 
   $silo->addValidate('dbname', 'DB Name', array('required'));
   // Validasi dbuser
   $silo->addValidate('dbuser', 'DB User', array('required'));
   // Validasi dbpass
   $silo->addValidate('dbpass', 'DB Pass');
   
   // Validasi fullname
   $silo->addValidate('fullname', 'Nama lengkap', array('required','max_length', 'regex_match'), array('max_length' => 32, 'regex_match' => '/^[a-zA-Z ]{1,}[a-zA-Z0-9]{1,}$/'));
   
   // Validasi username
   $silo->addValidate('username', 'Nama pengguna', array('required', 'max_length', 'min_length', 'regex_match'), array('max_length' => 16, 'min_length' => 3, 'regex_match' => '/^[A-Za-z][A-Za-z0-9]{1,}$/'));
   
   // Validasi email
   $silo->addValidate('email', 'Email', array('required', 'email', 'max_length'), array('max_length' => 32));
   
   // Validasi password
   $silo->addValidate('password', 'Password', array('required', 'max_length', 'min_length', 'regex_match'), array('max_length' => 32, 'min_length' => 6, 'regex_match' => '/^[a-zA-Z0-9.*&]+$/'));
   
   if ($silo->running() == FALSE)
   {
      $response = array (
                        'status' => 'validate',
                        'message' =>
                        array (
                        'dbhost' => $silo->errorField('host'),
                        'dbuser' => $silo->errorField('dbuser'),
                        'dbname' => $silo->errorField('dbname'),
                        'dbpass' => $silo->errorField('dbpass'),
                        'username' => $silo->errorField('username'),
                        'fullname' => $silo->errorField('fullname'),
                        'email' => $silo->errorField('email'),
                        'password' => $silo->errorField('password')));
                        
                        echo json_encode($response);
                        exit;
   }
   else
   {
      // koneksi DB
      $dbhost = strip_tags(strtolower($_POST['host']));
      $dbname = strip_tags(strtolower($_POST['dbname']));
      $dbpass = strip_tags(strtolower($_POST['dbpass']));
      $dbuser = strip_tags(strtolower($_POST['dbuser']));
      
      // Informasi akun
      $fullname = strip_tags($_POST['fullname']);
      $username = strip_tags(strtolower($_POST['username']));
      $email = strtolower($_POST['email']);
      $password = strip_tags($_POST['password']);
      
      // test koneksi
      if ($silo->connect($dbhost, $dbname, $dbuser, $dbpass))
      {
         
        if ($silo->addData($fullname, $username, $email, $password))
        {
           if ($silo->create_silo_db($dbhost, $dbname, $dbuser, $dbpass))
           {
              $response = " Selamat Anda Telah Berhasil Menginstall SiloCMS, Demi keamanan silahkan hapus folder install pada root folder server anda.  <p> Informasi akun : <ul> <li> Email : {$email} </li> <li> Username : {$username}</li> <li> Password : {$password} </li> </ul> <p> Anda dapat login di alamat <u> domainanda.com/user/login atau  </u> <a href='/user/login'> Klik di sini </a>.
              <p> Jika ada yang ingin di tanyakan seputar <u> CMS </u> ini; silahkan hubungi pengembang di facebook <i> http://facebook.com/fajar.susilo.904 </i> (Fajar Susilo)  ";
              echo json_encode(array('status' => 'success', 'message' => $response));
              
              exit;
           }
           else
           {
              echo json_encode(array('status' => 'failure', 'message' => 'Terjadi kesalahan saat memproses data <p> Error code : 3 </p>'));
              
              exit;
           }
        }
        else
        {
           echo json_encode(array('status' => 'failure', 'message' => $silo->db_error()));
           exit;
        }
               
      }
      else
      {
         echo json_encode(array('status' => 'failure', 'message' => $silo->db_error()));
         exit;
      }
   } 

 ?>