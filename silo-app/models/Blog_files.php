<?php defined('BASEPATH') OR exit('access denied !');
/**
 * @author fajar susilo
 * @email <silophp@gmail.com>
 * @since 1.0
 * @files Blog_files (Model)
 **/
 class Blog_files extends CI_Model {
    
  public function listfile($page = 0, $search = ""){
  
   $limit = 10;   // limit
   
   if (empty($search)){     // list all file and page
      
      $this->db->limit($limit, $page); 
   
      $this->db->order_by('id', 'DESC');
   
   $res = $this->db->get('blog_file');
   
       if ($res->num_rows() == 0){
          
           return array();    
           
       }
       
       $result = $res->result_array();
       
       foreach ($result as $list){
          
          $data['id'] = $list['id']; // jjjid file
          $data['rawname'] = $this->_raw_name($list['filename']); // nama file tanpa extensi
          $data['filename'] = $list['filename']; // nama file
          $data['file_ext'] = $this->_file_ext($list['filename']); 
          
          $data['date'] = $list['date']; // tanggal upload
          $data['size'] =  get_filesize($list['size']); // ukuran file
          $view [] = $data;
       }
       
       return $view;
       
    }
    
        else
        
        
               {
                     // halaman pencarian
                     
                     $this->db->like('filename', $search);
                     
                     $this->db->order_by('id', 'DESC');
                     
                     $this->db->limit($limit, $page);
                     
                     $res = $this->db->get('blog_file');
                    $result = $res->result_array();
                    
                    if ($res->num_rows() == 0){
                       
                       return array();
                       
                    }
                    
                    
                  foreach ($result as $list){
                     
                      $data['id'] = $list['id']; // jjjid file
          $data['rawname'] = $this->_raw_name($list['filename']); // nama file tanpa extensi
          $data['filename'] = $list['filename']; // nama file
          $data['file_ext'] = $this->_file_ext($list['filename']); 
          
          $data['date'] = $list['date']; // tanggal upload
          $data['size'] =  get_filesize($list['size']); // ukuran file
          $view [] = $data;
                     
           }
                
                return $view;
       }

  }
  
  private function _file_ext($file){
     
      $pecah = explode('.',$file);
      return strtoupper($pecah[1]);
      
  }
  
  private function _raw_name($file){
     
     $pecah = explode('.',$file);
     
     return strtoupper($pecah[0]);
     
  }
  
    public function add($data){
       
     if($this->db->insert('blog_file',$data)){
        
        return TRUE;
     }
       return FALSE;
  }

 // perbaharui file
 public function update($data,$file_id){
    
  $this->db->where('id',$file_id);
  $this->db->set($data);
  
  if($this->db->update('blog_file')){
   
     return TRUE;
 
   }
     return FALSE;
 }
 
 // menghapus file
 public function delete($file_id){
    
  $this->db->where('id',$file_id);
  
  if ($this->db->delete('blog_file')){
   
     return TRUE;
   }
     return FALSE;
 }
 
  public function isfile($id){
  
  $this->db->where('id', $id);
  $res = $this->db->get('blog_file');
  
              if ($res->num_rows() > 0 ){
               
                  $result = $res->row_array();
                  return $result;
              }
                
               return FALSE;
      
       }
       
 // menampilkan total file
 public function count($search = ""){
    
   if (empty($search) OR ($search == ""))
   {  // jumlah semua file
    $sql = "SELECT COUNT(*) AS total FROM blog_file";
 
    $query = $this->db->query($sql);
    $query = $query->row_array();
    
    return $query['total'];
       
       
       }
         
         else 
              
              {
            
          $query = $this->db->select('*')
                            ->from('blog_file')
                            ->like('filename', $search)
                            ->get();
    
          return $query->num_rows();
          
         }
      
     }
    
 }