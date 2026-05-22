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
                $this->load->model("User_Model");
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
    $user = $this->User_Model->login($user_id, $password);

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

    public function uye_ol()
	{
        
		$this->load->view('uye_formu');
        
	}

    public function basvuru_kaydet() {
    // 1. GÜVENLİK: Sayfa dışarıdan POST yerine düz linkle (GET) çağrılmaya çalışılırsa login'e postala
    if ($this->input->method(TRUE) !== 'POST') {
        redirect('Login');
        return;
    }

    // 2. GÜVENLİK VE VERİ ALMA: XSS temizliği yaparak form verilerini çekiyoruz
    $name      = $this->input->post('name', TRUE);
    $person    = $this->input->post('person', TRUE);
    $taxnumber = $this->input->post('taxnumber', TRUE);
    $tel       = $this->input->post('tel', TRUE);
    $address   = $this->input->post('address', TRUE);

    // 3. DOĞRULAMA: Alanların boş gelip gelmediğini kontrol edelim (HTML bypass edilirse diye)
    if (empty($name) || empty($person) || empty($taxnumber) || empty($tel) || empty($address)) {
        $this->session->set_flashdata('basvuru_durum', 'hata');
        $this->session->set_flashdata('basvuru_sonuc', 'Lütfen formdaki tüm alanları eksiksiz doldurun.');
        redirect('Login/uye_ol');
        return;
    }

    // 4. VERİTABANI EŞLEŞTİRME: account_request tablonun kolon yapısı
    $data = array(
        'name'       => $name,
        'person'     => $person,
        'taxnumber'  => $taxnumber,
        'tel'        => $tel,
        'address'    => $address,
        'status'     => 0,                  // 0: Beklemede (Admin panelinden onaylanacak)
        'is_read'    => 0,                  // 0: Okunmadı (Yeni bildirim uyarısı için)
        'admin_id'   => NULL,               // İlk aşamada boş
        'created_at' => date('Y-m-d H:i:s') // Başvuru tarihi
    );

    // 5. KAYIT İŞLEMİ: Tablo adı 'account_request' olarak set edildi
    $kaydet = $this->db->insert('account_request', $data);

    // 6. KULLANICIYI BİLGİLENDİRME VE YÖNLENDİRME
    if ($kaydet) {
        $this->session->set_flashdata('basvuru_durum', 'basarili');
        $this->session->set_flashdata('basvuru_sonuc', 'Başvurunuz başarıyla alındı! İnceleme sonrasında sizinle iletişime geçeceğiz.');
    } else {
        $this->session->set_flashdata('basvuru_durum', 'hata');
        $this->session->set_flashdata('basvuru_sonuc', 'Sistemsel bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.');
    }

    // Form sayfasına güvenle geri gönderiyoruz
    redirect('Login/uye_ol');
}
        
}
    
