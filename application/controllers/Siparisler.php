<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[AllowDynamicProperties]
class Siparisler extends CI_Controller
{

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
		$this->load->model('User_Model');
		$this->load->model('Api_model');
		$this->load->library('Http');
		if (!$this->session->userdata("oturum_data")) {
			redirect(base_url() . 'Login');
		}
	}
	public function index()
	{
		// 1. Session'dan gerekli bilgileri alalım
		$oturum = $this->session->userdata('oturum_data');

		// Eğer oturum yoksa login'e at
		if (!$oturum) {
			redirect('login');
		}

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


		$this->load->view('siparisler', $data);
	}

	public function get_siparisler_ajax()
	{
		$oturum = $this->session->userdata('oturum_data');
		if (!$oturum) exit;

		$cariRef = $oturum['ref'];
		$tum_veri = $this->Api_model->get_acik_siparisler($cariRef);
		if (!is_array($tum_veri)) $tum_veri = [];

		// DataTables Parametreleri
		$search = $_POST['search']['value'] ?? ''; // Genel arama
		$durum_filtresi = $_POST['columns'][2]['search']['value'] ?? ''; // Durum sütunu filtresi
		$start = (int)($_POST['start'] ?? 0);
		$length = (int)($_POST['length'] ?? 10);

		// 1. Durum Filtrelemesi
		if (!empty($durum_filtresi)) {
			$tum_veri = array_filter($tum_veri, function ($item) use ($durum_filtresi) {
				return ($item['SIPARIS_DURUM'] ?? '') === $durum_filtresi;
			});
		}

		// 2. Genel Arama (Eğer yazıldıysa)
		if (!empty($search)) {
			$tum_veri = array_filter($tum_veri, function ($item) use ($search) {
				return stripos($item['SIPARIS_DURUM'] ?? '', $search) !== false ||
					stripos($item['SIPARIS_NO'] ?? '', $search) !== false;
			});
		}

		$toplam_kayit = count($tum_veri);
		$sayfalanmis_veri = array_slice(array_values($tum_veri), $start, $length);

		echo json_encode([
			"draw" => intval($_POST['draw'] ?? 0),
			"recordsTotal" => $toplam_kayit,
			"recordsFiltered" => $toplam_kayit,
			"data" => $sayfalanmis_veri
		]);
	}
}
