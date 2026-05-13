<?php
class Database_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
	
	public function insert_data($table,$data)
	{
		$this->db->insert($table,$data);
        return true;
    }
    
	public function update_data($tablo,$data,$id)
	{
		$this->db->where('Id',$id);
		$this->db->update($tablo,$data);
		return true;
		
	}

}
