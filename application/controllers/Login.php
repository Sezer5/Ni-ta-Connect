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
                $this->load->database();
               
                
         
				
        }
	public function index()
	{
        
		$this->load->view('login_formu');
        
	}
    public function login_ol()
{
    $user_id  = $this->input->post('user_id', TRUE);
    $password = $this->input->post('password', TRUE);
    
    // 1. Veritabanı Kontrolü
    $user = $this->Admin_Model->login($user_id, $password);

    if ($user) {
        // Değişken kapsamı hatasını önlemek için API yanıtını farklı bir değişkende tutalım
        $token = null; 
        
        // 2. API Token Alma İşlemi
        $url = "http://10.51.0.24:8091/token";
        $post_data = array(
            'grant_type' => 'password',
            'username'   => 'admin',
            'password'   => 'ngt2026'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Bağlantı takılırsa sistemi kilitlemesin

        $response = curl_exec($ch);
        $curl_error = curl_errno($ch);
        curl_close($ch);

        if (!$curl_error) {
            $api_result = json_decode($response, true);
            if (isset($api_result['access_token'])) {
                $token = $api_result['access_token'];
            }
        }

        // 3. Oturum Verilerini Hazırlama
        // $user[0] yerine doğrudan dönen objeyi kullanıyoruz (Model yapına göre ayarlandı)
        $oturum_dizi = array(
            'id'           => $user[0]->Id,
            'user_id'      => $user[0]->user_id,
            'code'         => $user[0]->code,
            'ref'          => $user[0]->ref,
            'email'        => $user[0]->email,
            'name'         => $user[0]->name,
            'status'       => $user[0]->status,
            'profile_image'       => $user[0]->profile_image,
            'access_token' => $token // API'den gelen token buraya ekleniyor
        );

        $this->session->set_userdata('oturum_data', $oturum_dizi);

        // 4. Durum Kontrolü ve Yönlendirme
        if ($this->session->oturum_data['status'] == 0) {
            $this->session->set_flashdata("login_hata", "Hesabınız pasif durumdadır!");
            redirect(base_url() . 'login/logout');
            return;
        }

        redirect(base_url() . 'home');

    } else {
        // Giriş başarısız
        $this->session->set_flashdata("login_hata", "Geçersiz kullanıcı adı ya da şifre girdiniz!");
        redirect('login/index');
    }
}
    public function logout(){
        
        $this->session->unset_userdata('oturum_data');
        $this->session->sess_destroy();
        redirect(base_url().'login');
        
        
    }
        
}
    
