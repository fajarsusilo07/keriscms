<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo 
 * @since 1.0
 * @email <silophp@gmail.com>
 * @files blog_post (models)
 */
 class Blog_post extends CI_Model {
   
  public function count($search = "", $status){  // jumlah postingan
     
     $mode = $this->status($status);  // status postingan
      
    if (empty($search)){
      
         $this->db->where('status', $mode);
          
         $row = $this->db->get('blog_post');
       
       return $row->num_rows();
      
     }
     else
     {
                
                $this->db->where('status', $mode);
                $this->db->like('title', $search);
                $row = $this->db->get('blog_post');
                
                return $row->num_rows();
                
             }
   
   }
   
   // tampilkan listpost dan pagination
   public function listpost($page = 0, $status = "publish", $limit = 10){
             
         $mode = $this->status($status); // status
         
         $this->db->where('status', $mode);
            
         $this->db->limit($limit, $page);
         
         $this->db->order_by('update', 'DESC');    
              
         $row = $this->db->get('blog_post');  // row data
            
            $result = $row->result_array();  // result data
         
         if ($row->num_rows() > 0 ){
            
             foreach ($result as $list){
                      
                      $data['id'] = $list['id'];  // id postingan
                      
                      $data['title'] = $list['title'];  // judul artikel
                      
                      $data['permalink'] = $this->permalink($data['id']);  // permalink
                      
                      
                      $data['post_by'] = $this->post_by_author($list['post_by']);  // postingan oleh
                      
                      
                      $data['category'] = $this->category($list['category']);  // category postingan
                      $data['content'] = $list['content'];  // konten artikel
                      
                      $data['summary'] = $this->summary($list['content']);   // artikel depan
                      
                      $data['thumbnail'] = $this->thumbnail($list['content']);  // thumbnail blog
                      
                      $data['date'] = $list['date'];  // tanggal postingan
                      
                      $data['update'] = $list['update'];  // tanggal pembaharuan
                      
                      $data['hits'] = $list['hits'];  // hits
                      
                      
                      $data['status'] = $list['status'];
                      
                      
                      $output[] = $data;
                     
            }  
            
            return $output;  // output berupa array
            
       }
       else
       {    
                  
                  return array(); // postingan kosong
                  
             }
                  
      
   }
   
   
    public function searchpost($page = 0, $status = "publish", $search = "", $limit = 10){
      
      $mode = $this->status($status);
      
                  $this->db->where('status', $mode);
                  
                  $this->db->like('title', $search);
                  
                  $this->db->limit($limit, $page);
                  
                  $this->db->order_by('update', 'DESC');
                  
                  $row_search= $this->db->get('blog_post');
                  
                  $result_search = $row_search->result_array();
                  
                  if ($row_search->num_rows() > 0 ){
                     
                     foreach ($result_search as $list){
                      
                      $data['id'] = $list['id'];  // id postingan
                      
                      $data['title'] = $list['title'];  // judul artikel
                      
                      $data['permalink'] = $this->permalink($list['id']);   // permalink
                      
                      
                      $data['post_by'] = $this->post_by_author($list['post_by']);  // postingan oleh
                      
                      $data['category'] = $this->category($list['category']);  // category postingan
                      
                      $data['content'] = $list['content'];  // konten 
                      
                      $data['summary'] = $this->summary($list['content']);  // artikel depan
                      
                      $data['thumbnail'] = $this->thumbnail($list['content']);  // thumbnail blog
                      
                      $data['date'] = $list['date'];  // tanggal postingan
                      
                      $data['update'] = $list['update'];  // tanggal pembaharuan
                      
                      $data['hits'] = $list['hits'];  // hits
                      
                      
                      $data['status'] = $list['status'];   // status postingan
                      
                      $output[] = $data;
                     
            }  
            
            return $output;  // output berupa array
      
   }
   else
   {
             
             return array();
             
          }
  
  
  }
  // tampilkan postingan berdasarkan kategori
  public function listpost_category($page = 0, $category = 0, $limit = 10)
  {
     $this->db->where('status', 1);
     
     $this->db->like('category', $category);
     $this->db->limit($limit, $page);
     
     $result = $this->db->get('blog_post');
     
     // cek ketersediaan artikel
     if ($result->num_rows() > 0)
     {
        $content = $result->result_array();
        foreach ($content as $list)
        {
                      $data['id'] = $list['id'];  // id postingan
                      
                      $data['title'] = $list['title'];  // judul artikel
                      
                      $data['permalink'] = $this->permalink($data['id']);  // permalink
                      
                      
                      $data['post_by'] = $this->post_by_author($list['post_by']);  // postingan oleh
                      
                      
                      $data['category'] = $this->category($list['category']);  // category postingan
                      $data['content'] = $list['content'];  // konten artikel
                      
                      $data['summary'] = $this->summary($list['content']);   // artikel depan
                      
                      $data['thumbnail'] = $this->thumbnail($list['content']);  // thumbnail blog
                      
                      $data['date'] = $list['date'];  // tanggal postingan
                      
                      $data['update'] = $list['update'];  // tanggal pembaharuan
                      
                      $data['hits'] = $list['hits'];  // hits
                      
                      
                      $data['status'] = $list['status'];
                      
                      
                      $output[] = $data;
                      
        }
          return $output;
    
     }
     else
     {
        return array();
     }
     
  }
   
   public function status($status){
      
      if ($status == "publish"){
         
          $publish = 1;
         
          return $publish;
        }
        elseif ($status == "draft"){
           
               $draft = 0;
               return $draft;
           }
           else
           {
                $default = 1;      
                return $default;
           }
              
      }
      
      public function post_by_author($id = 0, $fullname = "fullname"){
      	
         $this->db->select('fullname, username');
         
         $this->db->where('id', $id);
         
         $result = $this->db->get('blog_user');
         
         $result = $result->row_array();
         
         if ($fullname == "fullname"){
         	
         if ($result['fullname']){
            
             return $result['fullname'];
         }
            
             return $result['username'];
            
       }
            else
                   {
                	
                	return $result['username'];
                	
            }
     
        }
   
  
     public function category($category){
        
        $explode = explode(',',$category);  // explode
        
        foreach ($explode as $list){
           
           $this->db->where('id', $list);
           
           $result = $this->db->get('blog_category');
           
           $row = $result->row_array();
           
           $data['permalink'] = "/category/search/{$row['permalink']} ";
           
           $data['name'] = ucfirst($row['name']);
           
           $output[] = $data;
           
        }
        
        return $output;
        
     }
     
     public function summary($content){
        
       $summary = strip_tags($content);  // hilangkan html
       $length = strlen($summary);  // panjang karakter
       $text = substr($summary, 0, 240);  // potong karakter
       
       if ($length > 240 ) {
           
           return $text;
          
        }
        
        return $summary;
            
     }
     
     
     public function thumbnail($content){
               
       preg_match('/src=[\'\"](.+)[\'\"]/', $content, $cocok);
		$res = str_replace("'",'"',@$cocok[1]);
		$patern = explode('"', $res);
		$img = str_replace('/>','',$patern[0]);
		$img = str_replace('../','',$img);
		$img = str_replace('\'/>','',$img);
		// thumbnail placeholder
		if (empty($img)){
			$img = '/asset/img/no-thumbnail.jpg';
		   }
		   
		return $img;
	
    }
    
    public function permalink($id = 0) {
     
     $sql = "SELECT slugpost FROM blog_setting WHERE id = 1";
     
     $set = $this->db->query($sql);
     
     $get_slug = $set->row_array();
     
     switch ($get_slug['slugpost']) {
        
        case '1':   // mode permalink : article/view/username/post-title
        
        $this->db->select('permalink, post_by');
        
        $this->db->where('id', $id);
        
        $slug_1= $this->db->get('blog_post')->row_array();
        
        $username = $this->post_by_author($slug_1['post_by'], 'username');    // username author post
        
        $slugpost = "/article/view/{$username}/{$slug_1['permalink']}";
        
        return $slugpost;
        
        break;
        
        case '2':  // mode permalink : article/view/post-title
        
        $this->db->select('permalink');
        
        $this->db->where('id', $id);
        
        $slug_2= $this->db->get('blog_post')->row_array();
        
        $slugpost = "/article/view/{$slug_2['permalink']}";
        
        return $slugpost;
        
        break;
        
        case '3':   // mode permalink : article/view/post-id
        default;
                
        $slugpost = "/article/view/{$id}";
        
        return $slugpost;
        
        break;
        
     }
     
       
   }
    
    public function insert($data){
    	
    	if ($this->db->insert('blog_post', $data)){
    		
    		  return TRUE;
    		
    	}
    	
    	return FALSE;
    	
    }
    
    public function update($id, $data) {
       
       $this->db->where('id', $id);
       
       $this->db->set($data);
       
       if ($this->db->update('blog_post')) {
         
         
         return TRUE; 
              
       }
       
        return FALSE;
       
   }
     
     
     public function postdetail($uri = NULL, $status = "publish") {
      
      $mode = $this->status($status);   // status postingan
      
      $sql = "SELECT slugpost FROM blog_setting WHERE id = 1";
      
      $slugpost = $this->db->query($sql)->row_array();
      
      switch ($slugpost['slugpost']){
         
         case '1':   // mode permalink : article/view/username/post-title
         
         $pecah = explode('/', $uri);
         
         $username = $this->db->select('id')
               ->where('username', $pecah[2])
               ->get('blog_user');
         
         $username = $username->row_array();
         
         $view = $this->db->where('post_by', $username['id'])
            
                ->where('permalink', $pecah[3])
                ->where('status', $mode)
                ->get('blog_post');
     
        $list = $view->row_array();
        
        if ($view->num_rows() > 0) {
           
                      $data['id'] = $list['id'];  // id postingan
                      
                      $data['title'] = $list['title'];  // judul artikel
                      
                      $data['permalink'] = $this->permalink($list['id']);  // permalink
                      
                      
                      $data['post_by'] = $this->post_by_author($list['post_by']);  // postingan oleh
                      
                      
                      $data['category'] = $this->category($list['category']);  // category postingan
                      $data['content'] = $list['content'];  // konten artikel
                      
                      $data['summary'] = $this->summary($list['content']);   // artikel depan
                      
                      $data['thumbnail'] = $this->thumbnail($list['content']);  // thumbnail blog
                      
                      $data['date'] = $list['date'];  // tanggal postingan
                      
                      $data['update'] = $list['update'];  // tanggal pembaharuan
                      
                      $data['hits'] = $list['hits'];  // hits
                     
                      return $data;
            
        }
        
        return NULL;
        break;
        
        case '2':  // mode permalink : article/view/post-title
        case '3':  // mode permalink : article/view/post-id
   
         $pecah = explode('/', $uri);
         
         $permalink = $pecah[2];
         if ($slugpost['slugpost'] == 2) {
             $where = "permalink";
            
     }
     else
     {
             $where = "id";
            
         }
         
         $view = $this->db->where($where, $permalink)
                          ->where('status', $mode)
                          ->get('blog_post');
     
         $list = $view->row_array();
         
         if ($view->num_rows() > 0) {
            
                      $data['id'] = $list['id'];  // id postingan
                      
                      $data['title'] = $list['title'];  // judul artikel
                      
                      $data['permalink'] = $this->permalink($data['id']);  // permalink
                      
                      
                      $data['post_by'] = $this->post_by_author($list['post_by']);  // postingan oleh
                      
                      
                      $data['category'] = $this->category($list['category']);  // category postingan
                      $data['content'] = $list['content'];  // konten artikel
                      
                      $data['summary'] = $this->summary($list['content']);   // artikel depan
                      
                      $data['thumbnail'] = $this->thumbnail($list['content']);  // thumbnail blog
                      
                      $data['date'] = $list['date'];  // tanggal postingan
                      
                      $data['update'] = $list['update'];  // tanggal pembaharuan
                      
                      $data['hits'] = $list['hits'];  // hits
                      
                      return $data;
            
         }
         
         return NULL;
         break;
         
          
        }
      
     }
     
     public function delete($id)
     {
        $this->db->where('id', $id);
        
        $found = $this->db->get('blog_post');
        
        if ($found->num_rows() > 0)
        {
           
           if ($this->db->delete('blog_post', ['id' => $id]))
           {
              
              return TRUE;
              
           }
           else
           {
              
              return FALSE;
           }
           
           }
           else
           {
              
              return FALSE;
           }
        
       }
       
       public function is_unique($switch = "slug", $old, $new)
       {
          if ($switch == "title")
          {
            $this->db->where('title', $new);
            $this->db->where('title !=', $old);
            $title = $this->db->get('blog_post');
                                if ($title->num_rows() > 0)
                                {
                                   return TRUE;
                                }
                                else
                                {
                                   return FALSE;
                                }
         
          }
          else
          {
            $this->db->where('permalink', $new);
            $this->db->where('permalink !=', $old);
            $permalink = $this->db->get('blog_post'); 
                                if ($permalink->num_rows() > 0)
                                {
                                   return TRUE;
                                }
                                else
                                {
                                   return FALSE;
                                }
                                
             
          }
       }
       
       public function top($limit = 10)
       {
          $this->db->order_by('hits', 'DESC');
          $this->db->select('title, permalink, date, update, post_by, hits, id, content');
          $this->db->limit($limit, 0);
          $this->db->where('status', 1);
          $result = $this->db->get('blog_post');
          
          foreach ($top = $result->result_array() as $top_list)
          {
              $list['permalink'] = $this->permalink($top_list['id']);
             
             $list['post_by'] = $this->post_by_author($top_list['post_by']);
             
             $list['summary'] = $this->summary($top_list['content']);
             
             $list['thumbnail'] = $this->thumbnail($top_list['content']);
            
             $list['title'] = $top_list['title'];
            
            $list['date'] = $top_list['date'];
             
            $list['update'] = $top_list['update'];
            
            $list['hits'] = $top_list['hits'];
           
            $top_article[] = $list;
             
        }
      
        return $top_article;
    }
  }