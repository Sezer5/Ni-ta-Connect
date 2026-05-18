<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Home extends CI_Controller {

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
                $this->load->model('Admin_Model');
                $this->load->model('Api_model');
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_admin")){
				redirect(base_url().'Login');}
				
        }
	public function index()
{
    // Session'dan cari referans numarasını alıyoruz
    $oturum = $this->session->userdata('oturum_admin');
    

    $this->load->view('admin/_main_content');
}    

}