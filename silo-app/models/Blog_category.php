<?php defined('BASEPATH') OR exit('access denied !');
/**
  * @author fajar susilo
  * @email <silophp@gmail.com>
  * @since 1.0
  * @file Blog_category (Models)
  */
  class Blog_category extends CI_Model {
  
  public function allcategory(){
  	
  	$result = $this->db->get('blog_category');
  	
  	if ($result->num_rows() > 0)
  	{
  	      foreach ($result = $result->result_array() as $list){
            
            $data['id'] = $list['id']; // ID Category
            $data['name'] = $list['name']; // Name Category
            $data['permalink'] = "/category/search/{$list['permalink']} "; // Permalink Category
            $data['post'] = $this->post($list['id']); // Jumlah Postingan
            
            $output[] = $data;
  	  }
  	  return $output;
    }	
  }
  
  public function listcategory($page = 0, $search = ""){
  	
  	 $limit = 10;
     
     if (empty($search)){
    
         $this->db->limit($limit, $page);
         
         $this->db->order_by('id', 'ASC');
         
         $row = $this->db->get('blog_category');
         
         $result = $row->result_array();
         
         if ($row->num_rows() > 0 ){
         
         foreach ($result as $list){
            
            $data['id'] = $list['id']; // ID Category
            $data['name'] = $list['name']; // Name Category
            $data['permalink'] = "/category/{$list['permalink']} "; // Permalink Category
            $data['post'] = $this->post($list['id']); // Jumlah Postingan
            
            $output[] = $data;
                  
         }
         
          return $output;
            
     }
         else
         
               {
               	
               	  return array();
               	  
               }
     
     }
     
     
      else 
        
        
           {
              
              $this->db->like('name', $search);
              $this->db->limit($limit, $page);
              $row = $this->db->get('blog_category');
              
              $result = $row->result_array();
              
         if ($row->num_rows() > 0 ){
              
            foreach ($result as $list){
              
            $data['id'] = $list['id']; // ID Category
            $data['name'] = $list['name']; // Name Category
            $data['permalink'] = "/category/search/{$list['permalink']} "; // Permalink Category
            $data['post'] = $this->post($list['id']); // Jumlah Postingan
            $output[] = $data;
                        
          }
              return $output;
     
       }
          
          else
                
                {
                	
                	return array();
                	
                }
      
         }
        

  }
  
  
  public function count($search = ""){
     
     if (empty($search) OR ($search == ""))
     {   // tampilkan total semua kategori
        
         $count = $this->db->get('blog_category');
      
         return $count->num_rows();
        
      }
      
       else
              {  // tampilkan total semua kategori berdasarkan name pencarian
                 
                 $this->db->like('name', $search);
                 $result = $this->db->get('blog_category');
                 
                 return $result->num_rows();
                 
              }
  
  }


  public function insert($data){
     
     if (is_array($data)){
        
         if ($this->db->insert('blog_category', $data)){
            
             return TRUE;
         }
          
               return FALSE;
        
     }
     
  }
  
  public function delete($id){
    
   $this->db->where('id', $id);
   
   $this->db->where('id !=', 1);
   
    if ($this->db->delete('blog_category')){
            
            return TRUE;
      }
        
        return FALSE;
        
  }
  
  public function update($data, $id){
  	
      if (is_array($data)){
         
         $this->db->where('id', $id);
         
         $this->db->set($data);
         
         if ($this->db->update('blog_category')){
            
             return TRUE;
         }
         
         return FALSE;
       
     }
        
  }

    public function is_unique_cat($action = "name", $newdata, $data){
       
       if ($action == "permalink"){
           
           $this->db->where('permalink', $newdata);
           $this->db->where('permalink != ', $data);
           $row = $this->db->get('blog_category');
           
           if ($row->num_rows() > 0 ){
              
               return TRUE;
           }
              else
                   {
                     return FALSE;
           }
           
       }
        
         else
               {
                  
                  $this->db->where('name', $newdata);
                  $this->db->where('name != ', $data);
                  
                  $rows = $this->db->get('blog_category');
                  
                  if ($rows->num_rows() > 0){
                     return TRUE;
                  }
                    
                    else
                          {
                             
                            
                             return FALSE;
                             
            }
            
            
         }     
         
         
     }   
       
       private function post($id){
       	
       	$this->db->like('category', $id);
       	
       	$count = $this->db->get('blog_post');
       	
       	return $count->num_rows();
       	
     }
     
     
       public function detail_category($id = 0){
       
       $this->db->where('id', $id);
       $result = $this->db->get('blog_category');
       
       if ($result->num_rows() > 0 ){
            
           $data = $result->row_array();
           
           return $data;
       }
       
        return NULL;
       
    }
    
    // tampilkan id kategori berdasarkan slug
    public function slug_to_id($permalink)
    {
       $this->db->where('permalink', $permalink);
       $data = $this->db->get('blog_category');
       
       if ($data->num_rows() > 0)
       {
          $id = $data->row_array()['id'];
          return $id;
       }
       else
       {
          return NULL;
       }
       
   }
 }