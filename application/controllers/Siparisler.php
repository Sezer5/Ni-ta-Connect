<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Siparisler extends CI_Controller {

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
                if (!$this->session->userdata("oturum_data")){
				redirect(base_url().'Login');}
				
        }
	public function index()
	{
        // 1. Session'dan gerekli bilgileri alalım
		$oturum = $this->session->userdata('oturum_data');
		
		// Eğer oturum yoksa login'e at
		if (!$oturum) { redirect('login'); }

		$token = $oturum['access_token'];
		$cariRef = $oturum['ref']; // Session'daki cari referans numarası

		// 2. API URL'ini oluştur (Görseldeki gibi Query Param ekleyerek)
		$url = "http://10.51.0.24:8091/api/siparis/GetCariAcikSiparis?cariRef=" . $cariRef;

		// 3. cURL ile GET isteği hazırla
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Header kısmına Bearer Token ekliyoruz (Görseldeki Authorization tabı)
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $token,
			'Content-Type: application/json'
		));

		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		// 4. Yanıtı işle
		$data['siparis_verileri'] = array();

		if ($http_code == 200) {
			$data['siparis_verileri'] = json_decode($response, true);
		} else {
			// Hata durumunda session'a mesaj atabilir veya boş gönderebilirsiniz
			$data['hata_mesaji'] = "API verisi çekilemedi. Durum Kodu: " . $http_code;
		}

		// 5. View'a gönder
    
        
        $this->load->view('siparisler',$data);
        
	}
    


}