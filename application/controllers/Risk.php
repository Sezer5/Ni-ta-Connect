<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Risk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->database();
        $this->load->model('Database_Model');
        $this->load->model('User_Model');
        $this->load->model('Api_model');
        $this->load->library('Http');

        // Oturum kontrolü
        if (!$this->session->userdata("oturum_data")) {
            redirect(base_url() . 'Login');
        }
    }

    public function index()
    {
        // 1. Session'dan bilgileri al
        $oturum = $this->session->userdata('oturum_data');
        $token = $oturum['access_token'];
        $cariRef = $oturum['ref'];

        // 2. API URL'lerini Hazırla
        // Genel risk verileri için
        $risk_url = "http://10.51.0.24:8091/api/risk/GetCariRisk?cariRef=" . $cariRef;
        // image_56e9f8.png görselindeki Kalan Limit API'si için
        $kalan_limit_url = "http://10.51.0.24:8091/api/risk/GetCariKalanLimit?cariRef=" . $cariRef;

        $vadeler_url = "http://10.51.0.24:8091/api/vade/GetCariVade?cariRef=" . $cariRef;

        // ... mevcut kodlar ...
        $faturalar_url = "http://10.51.0.24:8091/api/fatura/GetAcikFaturalar?cariRef=" . $cariRef;

        // 3. API İsteği Fonksiyonu (Kod tekrarını önlemek için)
        $fetchApi = function ($url) use ($token) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ));
            $res = curl_exec($ch);
            curl_close($ch);
            return json_decode($res, true);
        };

        // 4. Verileri Çek
        $risk_data = $fetchApi($risk_url);
        $kalan_limit_data = $fetchApi($kalan_limit_url);
        $vadeler_data = $fetchApi($vadeler_url);
        $faturalar_data = $fetchApi($faturalar_url); // Yeni API çağrısı
        // 5. View İçin Veriyi Paketle
        // Risk verilerini al (dizi boş gelirse hata oluşmaması için kontrol ekledik)
        $data['risk_verisi'] = $risk_data ?? [];
        $data['vade_verisi'] = (isset($vadeler_data[0])) ? $vadeler_data[0] : (is_array($vadeler_data) ? $vadeler_data : []);
        // image_56e9f8.png görselindeki KALAN_LIMIT değerini alıyoruz
        $data['kalan_limit_api'] = isset($kalan_limit_data['KALAN_LIMIT']) ? $kalan_limit_data['KALAN_LIMIT'] : 0;

        // Açık faturaları gönder (Eğer boşsa boş dizi gönder)
        $data['acik_faturalar'] = is_array($faturalar_data) ? $faturalar_data : [];

        // Sayfa başlığı ve tarih gibi ek bilgiler
        $data['title'] = "Finansal Risk Analizi";
        $data['current_date'] = date('d.m.Y H:i');

        // 6. View'a gönder
        $this->load->view('risk', $data);
    }
}
