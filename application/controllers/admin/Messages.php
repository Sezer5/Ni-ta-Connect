<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Messages extends CI_Controller {

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
                $this->load->model('Admin_Permission_Model');
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_admin")){
				redirect(base_url().'admin/Login');}
				
        }
	public function index()
    {
		$sql = "SELECT COUNT(*) as toplam FROM messages 
        WHERE status = 1 
        AND (
            is_read = 0 
            OR admin_id = 0 
            OR admin_id IS NULL 
            OR TRIM(admin_id) = ''
            OR admin_id NOT IN (SELECT Id FROM admin)
        )";

$query = $this->db->query($sql);
$result = $query->row();

// Çıkan sonucu session'a yazıyoruz
$count = ($result) ? (int)$result->toplam : 0;
$this->session->set_userdata('unread_messages_count', $count);
	
        $this->db->select('
        messages.*, 
        user.name AS user_name, 
        message_topics.name AS topic_name, 
        admin.name AS admin_name
    ');
    $this->db->from('messages');
    $this->db->join('user', 'user.code = messages.code', 'inner');
    $this->db->join('message_topics', 'message_topics.Id = messages.topic', 'inner');
    $this->db->join('admin', 'admin.Id = messages.admin_id', 'left'); // Henüz admin atanmamışsa da gelsin diye LEFT join
    $this->db->order_by('messages.Id', 'DESC');
    
    $query = $this->db->get();
    
    // 2. View dosyasına göndereceğimiz $data dizisini tanımlıyoruz
    $data['messages'] = $query->result(); 
    
    // 3. Veriyi view dosyasına parametre olarak basıyoruz
    // Not: 'admin/messages_view' kısmını kendi view dosya yolunuza göre güncelleyin
    $this->load->view('admin/messages', $data);
    }

	public function detail($id)
{
    if (empty($id) || !is_numeric($id)) {
        redirect('admin/messages');
    }

    // 1. İşlem: Veritabanında mesajı "Okundu" yap
    $this->db->where('Id', $id);
    $this->db->update('messages', ['is_read' => 1]);

    // 🎯 2. İşlem: Mesaj okunduğu için hafızadaki (Session) sayıyı 1 azalt
    $current_count = $this->session->userdata('unread_messages_count');
    if(!empty($current_count) && $current_count > 0) {
        $this->session->set_userdata('unread_messages_count', $current_count - 1);
    }

    // 3. İşlem: Detay verilerini çek ve ekrana bas
    $this->db->select('
        messages.*, 
        user.name AS user_name, 
        message_topics.name AS topic_name, 
        admin.name AS admin_name
    ');
    $this->db->from('messages');
    $this->db->join('user', 'user.code = messages.code', 'inner');
    $this->db->join('message_topics', 'message_topics.Id = messages.topic', 'inner');
    $this->db->join('admin', 'admin.Id = messages.admin_id', 'left');
    $this->db->where('messages.Id', $id); 
    
    $query = $this->db->get();
    $data['message'] = $query->row(); 

    if (!$data['message']) {
        redirect('admin/messages');
    }
    
    $data['title'] = "Mesaj Detayı #" . $data['message']->Id;
    $this->load->view('admin/messages_detail', $data);
}

public function assign_admin($id)
{
    // Güvenlik kontrolleri
    if (empty($id) || !is_numeric($id)) {
        redirect('admin/messages');
    }

    // Session'dan giriş yapmış olan aktif yöneticinin ID değerini alıyoruz
    $active_admin_id = $this->session->oturum_admin['id']; // Kendi session anahtarınızla değiştirin

    if (!empty($active_admin_id)) {
        // İlgili mesajın admin_id alanına session'daki admin ID'sini yazıyoruz
        $this->db->where('Id', $id);
        $this->db->update('messages', [
            'admin_id' => $active_admin_id
        ]);
    }

    // İşlem bittikten sonra sayfayı yeniliyoruz (Buton değişecek)
    redirect('admin/messages/detail/' . $id);
}

// 2. BUTON İÇİN: Mesajı Pasife Al Buton Fonksiyonu (Bir Kez Çalışır)
public function deactivate_message($id)
{
    // Güvenlik kontrolleri
    if (empty($id) || !is_numeric($id)) {
        redirect('admin/messages');
    }

    // Mesajın durumunu (status) 0 (Pasif) yapıyoruz
    $this->db->where('Id', $id);
    $this->db->update('messages', [
        'status' => 0
    ]);

    // İşlem bittikten sonra sayfayı yeniliyoruz (Buton tamamen yok olacak)
    redirect('admin/messages/detail/' . $id);
}

    

}