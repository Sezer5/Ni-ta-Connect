<?php
class Admin_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                
                
        }
	
	public function login($user_id,$password)
	{
		$this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_id',$user_id);
        $this->db->where('password',$password);
        $this->db->limit(1);
        $query=$this->db->get();
        if($query->num_rows() == 1){
            return $query->result();
        } else {
            return false;
        }
		
		
	}
    
}
