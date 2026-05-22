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
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_data")){
				redirect(base_url().'Login');}
				
        }
	public function index()
    {
    $sorgu=$this->db->query("SELECT * FROM message_topics");
    $data["message_topics"]=$sorgu->result();

    $this->load->view('messages', $data);
    }

    public function save() 
    {
        // 1. Güvenlik Kontrolü: İstek POST yöntemiyle mi gelmiş?
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Geçersiz istek yöntemi doğrudan erişim engellendi.');
            redirect(base_url('messages'), 'refresh');
            return;
        }

        // 2. Form Verilerini Güvenli Bir Şekilde Alıyoruz (XSS Temizliği Aktif)
        $topic    = $this->input->post('topic', TRUE);
        $title       = $this->input->post('title', TRUE);
        $code       = $this->input->post('code', TRUE);
        $description = $this->input->post('description', TRUE);

        // 3. Veri Boşluk Kontrolü (Validasyon)
        if (empty($topic) || empty($title) || empty($description)) {
            $this->session->set_flashdata('error', 'Lütfen formda bulunan tüm zorunlu alanları doldurunuz.');
            redirect($this->input->server('HTTP_REFERER'), 'refresh'); // Geldiği sayfaya geri gönderir
            return;
        }

        // 4. Oturum Açan Kullanıcı Bilgisini Alıyoruz (Kim gönderdi?)
        // Sisteminizdeki session yapısına göre 'oturum_admin' veya 'oturum_user' olarak güncelleyebilirsiniz
        $oturum = $this->session->userdata('oturum_admin');
        $sender_id = !empty($oturum['id']) ? $oturum['id'] : 0; 

        // 5. Veritabanına Eklenecek Dizi Yapısını Hazırlıyoruz
        $insert_data = [
            'topic'    => intval($topic),
            'code'       => htmlspecialchars($code),
            'title'       => htmlspecialchars($title),
            'description' => htmlspecialchars($description),
            'created_at'  => date('Y-m-d H:i:s'), // Mesajın gönderim tarihi
            'is_read'     => 0                    // Okunmadı olarak işaretliyoruz
        ];

        // 6. Veritabanına Kayıt Atma İşlemi
        // Not: Tablo adınız veritabanında ne ise ('messages', 'iletisim_mesajlari' vb.) onu yazmalısınız
        $result = $this->db->insert('messages', $insert_data);

        // 7. Arayüze Geri Bildirim Mesajlarının Gönderilmesi
        if ($result) {
            // View dosyasındaki $this->session->userdata('success') alanını tetikler
            $this->session->set_flashdata('success', 'Mesajınız başarıyla ilgili birime iletilmiştir. Teşekkür ederiz.');
        } else {
            // View dosyasındaki $this->session->userdata('error') alanını tetikler
            $this->session->set_flashdata('error', 'Mesaj kaydedilirken sistemsel bir hata oluştu. Lütfen tekrar deneyiniz.');
        }

        // 8. Formun Gönderildiği İletişim Sayfasına Yönlendirme
        redirect($this->input->server('HTTP_REFERER'), 'refresh');
    }

    public function history()
    {
        // 1. Oturum kontrolü: Eğer kullanıcının session kodu yoksa giriş sayfasına yönlendir
        $user_code = $this->session->oturum_data['code'];
        if (empty($user_code)) {
            redirect('Login'); // Giriş kontrolü yaptığınız controller adını yazın
        }

        // 2. Veritabanından sadece bu kullanıcı koduna ait mesajları ilişkileriyle çekiyoruz
        $this->db->select('
            messages.*, 
            message_topics.name AS topic_name, 
            admin.name AS admin_name
        ');
        $this->db->from('messages');
        $this->db->join('message_topics', 'message_topics.Id = messages.topic', 'inner');
        $this->db->join('admin', 'admin.Id = messages.admin_id', 'left'); // İlgilenen admin varsa adını almak için
        $this->db->where('messages.code', $user_code);
        $this->db->order_by('messages.created_at', 'DESC'); // En yeni mesaj en üstte görünecek şekilde
        
        $data['history_messages'] = $this->db->get()->result();
        $data['title'] = "Eski İletişim Taleplerim";

        // 3. Görünüm dosyasını yüklüyoruz
        $this->load->view('messages_history', $data);
    }

}