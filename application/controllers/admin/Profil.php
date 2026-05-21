<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Profil extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->database();
        $this->load->model('Database_Model');
        $this->load->model('Admin_Permission_Model');
        $this->load->model('User_Model');
        $this->load->model('Api_model');
        $this->load->library('Http');

        if (!$this->session->userdata("oturum_admin")){
            redirect(base_url().'Login');
        }
    }

    public function index() 
    {
        $oturum = $this->session->userdata('oturum_admin');
        $user_id = $oturum['id']; 

        // image_54a71d.png'deki veritabanı tablonuza göre güncel bilgileri çekiyoruz
        $data['user'] = $this->db->where('Id', $user_id)->get('admin')->row_array();
        
        $this->load->view('admin/profil', $data);
    }

    public function update() 
{
    // Mevcut session verilerini alıyoruz
    $oturum = $this->session->userdata('oturum_admin');
    $user_id = $oturum['id'];
    
    $new_email = $this->input->post('email');
    $new_password = $this->input->post('password');

    // Temel güncelleme verisi (E-posta her halükarda güncelleniyor)
    $update_data = ['email' => $new_email];

    // 1. Şifre alanı boş değilse ekle
    if (!empty($new_password)) {
        $update_data['password'] = $new_password; 
    }

    // 2. Profil Resmi Yükleme İşlemleri (Eğer kullanıcı dosya seçtiyse)
    if (!empty($_FILES['profile_image']['name'])) {
        
        // Yükleme dizini ayarları
        $config['upload_path']   = './uploads/'; 
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048; // Maksimum 2MB
        $config['file_name']     = 'profile_' . $user_id . '_' . time(); // Benzersiz dosya ismi

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            // Yüklenen dosyanın bilgilerini alıyoruz
            $upload_data = $this->upload->data();
            $new_image_name = $upload_data['file_name'];

            // ESKİ RESMİ SİLME MANTIĞI:
            // Veritabanından mevcut resmin adını çekiyoruz
            $current_user = $this->db->where('Id', $user_id)->get('user')->row_array();
            
            if (!empty($current_user['profile_image'])) {
                $old_file_path = './uploads/' . $current_user['profile_image'];
                
                // Eğer eski dosya klasörde gerçekten varsa sunucudan siliyoruz
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            // Güncellenecek verilere yeni resim adını ekliyoruz
            $update_data['profile_image'] = $new_image_name;
            
            // SESSION GÜNCELLEME (Fotoğraf): Yeni resim adını session hafızasına da yazıyoruz
            $oturum['profile_image'] = $new_image_name;

        } else {
            // Yükleme sırasında hata oluşursa hata mesajını gönder ve işlemi durdur
            $error = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Resim yüklenemedi: ' . $error);
            redirect(base_url('admin/profil'), 'refresh');
            return;
        }
    }

    // 3. Veritabanı Güncelleme İşlemi
    $this->db->where('Id', $user_id)->update('admin', $update_data);

    // SESSION GÜNCELLEME (Genel): Değişen e-posta adresini de session hafızasına yazıyoruz
    $oturum['email'] = $new_email;
    
    // Güncellenmiş yeni diziyi session'a tekrar set ediyoruz
    $this->session->set_userdata('oturum_admin', $oturum);

    // Başarı mesajı
    $this->session->set_flashdata('success', 'Profil bilgileriniz başarıyla güncellendi.');
    
    redirect(base_url('admin/profil'), 'refresh');
}

}