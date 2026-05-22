<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountRequest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Admin giriş kontrolü varsayılmıştır. Model yüklemesi:
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
                if($this->Admin_Permission_Model->adminGeneralPermission($this->session->oturum_admin['id'],4) != 1){
				redirect(base_url().'admin/Login');}
    }

    // Başvuru Listesi Sayfası
    public function uyelik_istekleri() {
        // Tüm sayfalarda sidebar sayacına erişebilmek için global veri çekiyoruz
        $data['unread_count'] = $this->Admin_Model->get_unread_request_count();
        $data['istekler'] = $this->Admin_Model->get_all_requests();
        
        $this->load->view('admin/uyelik_istekleri_view', $data);
    }

    // Başvuru Detay Sayfası
    public function uyelik_detay($id) {
        $id = (int)$id; // Güvenlik için ID'yi temizleyin
        
        // Başvuru detayını çek
        $data['istek'] = $this->Admin_Model->get_request_detail($id);
        if(empty($data['istek'])) { show_404(); }

        // 🎯 Kurgu Gereği: Detaya girildiği an bu istek OKUNDU olarak işaretlenir ve sayaçtan düşer
        if($data['istek']['is_read'] == 0) {
            $this->db->where('id', $id)->update('account_request', array('is_read' => 1));
        }

        $data['unread_count'] = $this->Admin_Model->get_unread_request_count();
        $this->load->view('admin/uyelik_detay_view', $data);
    }



public function basvuru_aksiyon() {
    $id = (int)$this->input->post('id', TRUE);
    $islem = $this->input->post('islem', TRUE);
    
    // DÜZELTME: 'oturum_data' yerine 'oturum_admin' kullanıyoruz
    $admin_oturum = $this->session->userdata('oturum_admin');
    
    // Burada id'nin dizideki anahtar adını (örneğin 'id' veya 'admin_id') kontrol et
    // Eğer session'ın içinde id'ye 'id' olarak ulaşıyorsan:
    $admin_id = isset($admin_oturum['id']) ? $admin_oturum['id'] : null;

    if (!$admin_id) {
        $this->session->set_flashdata('islem_sonuc', 'Admin oturumu bulunamadı! Lütfen tekrar giriş yapın.');
        $this->session->set_flashdata('islem_durum', 'danger');
        redirect('Admin/AccountRequest/uyelik_detay/' . $id);
        return;
    }

    $update_data = [];

    if ($islem == 'sahiplen') {
        $update_data = ['status' => 2, 'admin_id' => $admin_id];
    } elseif ($islem == 'pasife_cek') {
        $update_data = ['status' => 3, 'admin_id' => $admin_id];
    } else {
        redirect('Admin/AccountRequest/uyelik_istekleri');
        return;
    }

    $this->db->where('Id', $id);
    $sonuc = $this->db->update('account_request', $update_data);

    if ($sonuc) {
        $this->session->set_flashdata('islem_sonuc', 'İşlem başarıyla gerçekleşti.');
        $this->session->set_flashdata('islem_durum', 'success');
    } else {
        $this->session->set_flashdata('islem_sonuc', 'Veritabanı güncelleme hatası!');
        $this->session->set_flashdata('islem_durum', 'danger');
    }

    redirect('Admin/AccountRequest/uyelik_detay/' . $id);
}

    
}