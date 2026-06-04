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
                $this->load->model('User_Model');
                $this->load->model('Api_model');
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_data")){
				redirect(base_url().'Login');}
				
        }
	public function index()
{
    // Session'dan cari referans numarasını alıyoruz
    $oturum = $this->session->userdata('oturum_data');
    $cariRef = $oturum['ref'];

    // DOĞRU KULLANIM: Model içindeki fonksiyonu ismen çağırıyoruz
    // Api_model içinde 'get_irsaliye_count' fonksiyonu olduğunu varsayıyorum
    $data['toplam_irsaliye'] = $this->Api_model->get_irsaliye_count($cariRef);

    // Eğer tüm listeyi de çekmek istersen:
    // $data['irsaliye_verileri'] = $this->Api_model->get_acik_irsaliyeler($cariRef);

    $data['toplam_siparis'] = $this->Api_model->get_siparis_count($cariRef);

    // Risk verisi (Doğrudan API'den gelen array)
    $data['risk_verisi'] = $this->Api_model->get_cari_risk($cariRef);

    // Vade verilerini çek
    $vade_raw = $this->Api_model->get_cari_vade($cariRef);

    // Veri yapısını düzelt (Eğer dizi içindeyse 0. indeksi al, değilse direkt al)
    $vade_data = isset($vade_raw[0]) ? $vade_raw[0] : $vade_raw;

    // View için temiz değişkenler
    $data['tanimli_vade'] = $vade_data['TANIMLI_VADE'] ?? 0;
    $data['gerceklesen_vade'] = $vade_data['GERCEKLESEN_VADE'] ?? 0;
    
    $this->load->vars($data); // Tüm $data içeriğini tüm view'lar için erişilebilir yap
    $this->load->view('_main_content'); // View'ı yükle
}    

}