<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author Fajar Susilo
 * @since 1.0
 * @email <silophp@gmail.com>
 * @files blog_pages (model)
 */
 
  class Blog_pages extends CI_Model {

   public function allpages(){
      return $this->db->get('blog_pages')->result_array();
   }
   public function count($search = ""){
      
      if ($search == "" OR (empty($search))){
         
         return $this->db->get('blog_pages')->num_rows();
         
      }
       
       else
       
           {
              
              $this->db->like('name',$search);

              $res = $this->db->get('blog_pages');

              return $res->num_rows();
              
              
           }
      
   }
   
   public function listpage($page = 0, $search = ""){
      
      if ($search == "" OR (empty($search))){
         
                $this->db->limit(10, $page);

                $this->db->order_by('id','DESC');

                $res = $this->db->get('blog_pages');
         
           return $res->result_array();
         
     }
        
      else  {
           
           $this->db->like('name', $search);

           $this->db->limit(10, $page);

           $this->db->order_by('id', 'DESC');

           $res = $this->db->get('blog_pages');
           
           return $res->result_array();
           
        }
      
    }
    
    public function insert($data){
       
       if (is_array($data)){    

       if ($this->db->insert('blog_pages',$data)){
          
         return TRUE;

       }
        
         return FALSE;
          
      }

   }
    
    public function update($data, $id){
       
       if (is_array($data)){
          
          $this->db->where('id', $id);

          $this->db->set($data);
          
          if ($this->db->update('blog_pages')){
             
             return TRUE;
          }
          
          return FALSE;
      
       }
        
    }
    
    public function delete($id){
       
       $this->db->where('id', $id);

       if ($this->db->delete('blog_pages')){
          
          return TRUE;

       }

       return FALSE;

    }
    
    public function detail($id = 0){
       
       $this->db->where('id', $id);

       $result = $this->db->get('blog_pages');
       
       if ($result->num_rows() > 0 ){
            
           $data = $result->row_array();
           
           return $data;
       }
       
        return NULL;
       
    }
    
    public function view($perm)
    {
       $this->db->where('permalink', $perm);
       $row = $this->db->get('blog_pages');
       
       if ($row->num_rows() > 0)
       {
          return $row->row_array();
       }
       return NULL;
    }
    
    public function is_unique($action = "name", $newdata, $data){
       
       if ($action == "permalink"){
           
           $this->db->where('permalink', $newdata);

           $this->db->where('permalink != ', $data);

           $row = $this->db->get('blog_pages');
           
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
                  
                  $rows = $this->db->get('blog_pages');
                  
                  if ($rows->num_rows() > 0){

                     return TRUE;

                  }
                    
                    else
                          {
                             
                            
                             return FALSE;
                             
            }
         }     
     }
  }