<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Login extends CI_Controller {

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
                $this->load->library("session");
				$this->load->helper('url');
                $this->load->library('form_validation');
                $this->load->model("Admin_Model");
                $this->load->model("Database_Model");
                $this->load->model("Admin_Permission_Model");
                $this->load->database();
               
                
         
				
        }
	public function index()
	{
        
		$this->load->view('admin/login_formu');
        
	}
    public function login_ol()
{
    $user_id  = $this->input->post('user_id', TRUE);
    $password = $this->input->post('password', TRUE);
    
    // 1. Veritabanı Kontrolü
    $user = $this->Admin_Model->login($user_id, $password);

    if ($user) {
        


        // 3. Oturum Verilerini Hazırlama
        // $user[0] yerine doğrudan dönen objeyi kullanıyoruz (Model yapına göre ayarlandı)
        $oturum_dizi = array(
            'id'           => $user[0]->Id,
            'user_id'      => $user[0]->user_id,
            'email'        => $user[0]->email,
            'name'         => $user[0]->name,
            'status'       => $user[0]->status,
            'programmer'       => $user[0]->programmer,
            'profile_image'       => $user[0]->profile_image,
        );

        $this->session->set_userdata('oturum_admin', $oturum_dizi);

        // 4. Durum Kontrolü ve Yönlendirme
        if ($this->session->oturum_admin['status'] == 0) {
            $this->session->set_flashdata("login_hata", "Hesabınız pasif durumdadır!");
            redirect(base_url() . 'admin/login/logout');
            return;
        }

        redirect(base_url() . 'admin/home');

    } else {
        // Giriş başarısız
        $this->session->set_flashdata("login_hata", "Geçersiz kullanıcı adı ya da şifre girdiniz!");
        redirect('admin/login/index');
    }
}
    public function logout(){
        
        $this->session->unset_userdata('oturum_admin');
        $this->session->sess_destroy();
        redirect(base_url().'admin/login');
        
        
    }
        
}
    
