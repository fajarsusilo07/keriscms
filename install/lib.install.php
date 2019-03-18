<?php
/**
  * @author fajar susilo
  * @email <silopho@gmail.com>
  * @since 1.0
  * @package lib.install
  */
  
  class Install {
     
     private $DB;  // instance class PDO
         
     private $message = array(); // pesan error
     private $time;
     
     private $path;
     
     public function __construct()
     {
        $this->time = gmdate('Y-m-d H:i:s',time()+3600*7);
        $this->path = $_SERVER['DOCUMENT_ROOT'].'/silo-app/config/';
     }
    // Tampilkan pesan error jika ada
     public function errorField($field)
     {
        if (empty($this->message[$field]))
        {
           return '';
        }
        else
        {
           return $this->message[$field];
        }
        
     }
     
     // Tampilkan semua pesan error
     public function getError()
     {
        if (count($this->message))
        {
           foreach ($this->message as $msg)
           {
              echo $msg;
           }
        }
        else
        {
           echo "";
        }
     }
     
     // validasi form
     public function addValidate($field, $label, $rule = array(), $criteria = array())
     {
         // unset variabel dahulu jika ada
        if ($this->message[$field]){
            unset($this->message[$field]);     
         }
        // filter
        $value = strip_tags(strtolower($_POST[$field]));
        
        foreach ($rule as $rules)
        {
          
          switch ($rules)
          {
             case 'required':
         
          if (empty($value))
             {
                $this->message[$field] = " bidang $label tidak boleh kosong. ";
                return;
             }
             break;
             
             case 'regex_match':
             if (!preg_match($criteria['regex_match'], $value))
             {
                $this->message[$field] = "Bidang {$label} tidak valid !";
             }
             break;
             
             case 'max_length':
             if (strlen($value) > $criteria['max_length'])
             {
                $this->message[$field] = " Bidang $label maksimal {$criteria['max_length']} karakter";
                return;
             }
             break;
             
             case 'min_length':
             if (strlen($value) < $criteria['min_length'])
             {
                $this->message[$field] = "bidang $label minimal {$criteria['min_length']} karakter";
                return;
             }
             break;
             
             case 'email':
             if (!filter_var($value, FILTER_VALIDATE_EMAIL))
             {
                $this->message[$field] = "bidang $label harus berupa email yang valid";
                return;
             }
             
             break;
        }
      }
    }
   // logika untuk validasi
   public function running()
   {
      if (empty($this->message))
       {
           return TRUE;
          }
        
          return FALSE;
       }
       
       // test koneksi ke database
       public function connect($dbhost, $dbname, $dbuser, $dbpass)
       {
          try {
             
             $dsn = "mysql:host=$dbhost;dbname=$dbname";
             $this->DB = new PDO($dsn, $dbuser, $dbpass);
             $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             
          }
          catch (PDOException $e)
          {
             $this->message['db_error'] = 'Tidak dapat terhubung ke database <p> Pesan Kesalahan : '.$e->getMessage().'</p>';
             return FALSE;
          }
          
          return TRUE;
       }
       
   // buat query sql
   private function create_sql()
   {
      // cek file install.sql
      if (file_exists(__DIR__.'/install.sql'))
      {
         
      $sql = file_get_contents(__DIR__.'/install.sql');
      return $sql;
     
      }
      return FALSE;
   }
   
   private function run_sql($query)
   {
      try {
         
         $this->DB->exec($query);
      } 
      catch (PDOException $e)
      {
         
         
         return FALSE;
      }
      
      return TRUE;
   }
   
   private function addUser($fullname, $username, $email, $password)
   {
      // buat key login
      $key = time.$email.$password;
      $login = md5(md5(base64_encode($key)));
      $name = $username;
      $name2 = $fullname;
      $pass = password_hash($password, PASSWORD_DEFAULT);
      $mail = $email;
      $date = $this->time;
    
      try  {
        $stmt = $this->DB->prepare("INSERT INTO blog_user (login, username, email, pass, fullname, date) VALUES (:login, :username, :email, :pass, :fullname, :date)");
        
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $stmt->bindParam(':fullname', $name2, PDO::PARAM_STR);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        
      }
      catch (PDOException $e)
      {
         return FALSE;
      }
     
     return TRUE;
     
   }
   
   // insert data untuk user
   public function addData($fullname, $username, $email, $password)
   {
      // file sql tersedia untuk di install
    if ($query = $this->create_sql())
      {
         if ($this->run_sql($query))
         {
            if ($this->addUser($fullname, $username, $email, $password))
            {
               return TRUE;
            }
            else
            {
               $this->message['db_error'] = "Terjadi kesalahan saat memproses data <p> Error code : 2 </p>";
            }
         }
         else
         {
            $this->message['db_error'] = 'Terjadi kesalahan saat memproses data. <p> Error code : 1 </p>'; 
            
            return FALSE;
         }
      }
      else
      {
         $this->message['db_error'] = ' Tidak dapat menginstall komponen <strong> install.sql </strong> tidak dapat di temukan.';
         return FALSE;
      }
      
   }
   
   public function create_silo_db($dbhost, $dbname, $dbuser, $dbpass)
   {
    $php = "<?php\n
      define('DBHOST', '$dbhost');\n
      define('DBNAME', '$dbname');\n
      define('DBUSER', '$dbuser');\n
      define('DBPASS', '$dbpass');\n?>";
      
     if (file_put_contents($this->path.'silo-db.php', $php))
     {
        return TRUE;
     }
     else
     {
       return FALSE;
     }
   }
   
    // Tampilkan pesan error jika tidak dapat terhubung ke database
    public function db_error()
   {
          if (!empty($this->message['db_error']))
          {
             return $this->message['db_error'];
             
          }
          return '';
    }
       // validasi request bukan dari ajax
    public function is_ajax(){
          
     return ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    
     }
  }
  
   ini_set('date_timezone', 'Asia/Jakarta');
   ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		} 
		
  $silo = new install();
  
  ?>