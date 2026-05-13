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
        $this->load->model('Admin_Model');
        $this->load->model('Api_model');
        $this->load->library('Http');

        if (!$this->session->userdata("oturum_data")){
            redirect(base_url().'Login');
        }
    }

    public function index() 
    {
        $oturum = $this->session->userdata('oturum_data');
        $user_id = $oturum['id']; 

        // image_54a71d.png'deki veritabanı tablonuza göre güncel bilgileri çekiyoruz
        $data['user'] = $this->db->where('Id', $user_id)->get('user')->row_array();
        
        $this->load->view('profil', $data);
    }

    public function update() 
    {
        $oturum = $this->session->userdata('oturum_data');
        $user_id = $oturum['id'];
        
        $new_email = $this->input->post('email');
        $new_password = $this->input->post('password');

        $update_data = ['email' => $new_email];

        // Şifre alanı boş değilse, HASHLEME YAPMADAN doğrudan ekle
        if (!empty($new_password)) {
            $update_data['password'] = $new_password; 
        }

        // Güncelleme işlemi
        $this->db->where('Id', $user_id)->update('user', $update_data);

        // Başarı mesajı (Flashdata bir sonraki istekte otomatik silinir)
        $this->session->set_flashdata('success', 'Profil bilgileriniz başarıyla güncellendi.');
        
        // Sayfa yenileme hatasını önlemek için tam URL ile yönlendirme
        redirect(base_url('profil'), 'refresh');
    }
}