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
        $this->db->from('admin');
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

    // 1. Sol menüdeki okunmamış başvuru sayısını getirir
    public function get_unread_request_count() {
        return $this->db->where('is_read', 0)->count_all_results('account_request');
    }

    // 2. Tüm başvuruları listeler
    public function get_all_requests() {
        return $this->db->order_by('created_at', 'DESC')->get('account_request')->result_array();
    }

    // 3. Tek bir başvurunun detayını getirir
    public function get_request_detail($id) {
        return $this->db->where('id', $id)->get('account_request')->row_array();
    }

        // AccountRequest_Model içine eklenebilir
    public function get_pending_request_count() {
        $this->db->where('admin_id IS NULL');
        $this->db->from('account_request');
        return $this->db->count_all_results();
    }
    
}
