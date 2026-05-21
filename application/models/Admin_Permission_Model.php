<?php
class Admin_Permission_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                
                
        }
	
	public function adminGeneralPermission($uid,$pid)
	{
		$this->db->select('*');
        $this->db->from('role_admins');
        $this->db->where('admin_id',$uid);
        $this->db->where('role_id',$pid);
        $this->db->limit(1);
        $query=$this->db->get();
        if($query->num_rows() == 1){
            return 1;
        } else {
            return 0;
        }
		
		
	}

    public function findYetkiler($uid){
        $this->db->select('*');
        $this->db->from('role_admins');
        $this->db->where('admin_id',$uid);
        $query=$this->db->get();
        $roles_in_users = $query->result();
        return $roles_in_users;
    }

    public function findRoleAdi($id){
        $this->db->select('*');
        $this->db->from('roles');
        $this->db->where('Id',$id);
        $query=$this->db->get();
        $data = $query->result();
        $name=$data[0]->name;
        return $name;
    }
    
}
