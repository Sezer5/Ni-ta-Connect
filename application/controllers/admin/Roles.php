<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Roles extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
     public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                $this->load->library("session");
				$this->load->helper('url');
                $this->load->helper('text');
                $this->load->database(); //Sayfada database'ye erişimi sağlar
				$this->load->model('Database_Model');
				$this->load->model('Admin_Permission_Model');
                $this->load->model('Admin_Model');
                $this->load->model('Api_model');
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_admin")){
				redirect(base_url().'Admin');}
                if($this->Admin_Permission_Model->adminGeneralPermission($this->session->oturum_admin['id'],1) != 1){
				redirect(base_url().'admin/Login');}
				
        }
	public function index()
{
   
	$sorgu=$this->db->query("SELECT * FROM roles");
    $data["roles"]=$sorgu->result();
    
    $this->load->view('admin/roles',$data);
}

public function role_add(){
        $data=array(
        'name'=>$this->input->post('name'),
        'description'=>$this->input->post('description'),
        );
        $this->Database_Model->insert_data("roles",$data);
            redirect(base_url()."admin/roles");
}

public function role_delete($id){
		$this->db->query("DELETE FROM roles WHERE Id=$id");
        redirect(base_url()."admin/roles");
    }

}