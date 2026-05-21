<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Adminsettings extends CI_Controller {

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
				$this->load->model('Admin_Permission_Model');
                $this->load->model('Admin_Model');
                $this->load->model('Api_model');
                $this->load->library('Http');
                if (!$this->session->userdata("oturum_admin")){
				redirect(base_url().'Admin');}
                if($this->Admin_Permission_Model->adminGeneralPermission($this->session->oturum_admin['id'],3) != 1){
				redirect(base_url().'admin/Login');}
				
        }
	public function index()
	{
	
	}    
	public function adminAdd()
	{
		$this->load->view('admin/adminAdd');
	}

	public function save(){

		$data=array(
        'name'=>$this->input->post('name'),
        'user_id'=>$this->input->post('user_id'),
        'email'=>$this->input->post('email'),
        'password'=>$this->input->post('password'),
        'status'=>1,
        );
        $this->Database_Model->insert_data("admin",$data);
		redirect(base_url().'admin/Adminsettings/AdminAdd');
	}

	public function adminUpdate(){
		$programmer=$this->session->oturum_admin['programmer'];
		$user_id=$this->session->oturum_admin['id'];
		if($programmer==1){
			$sorgu=$this->db->query("SELECT * FROM admin");
    		$data["admin"]=$sorgu->result();
		}else{
			$sorgu=$this->db->query("SELECT * FROM admin WHERE programmer<>1 AND Id<>$user_id");
    		$data["admin"]=$sorgu->result();
		}
		$this->load->view('admin/adminUpdate',$data);
	}

	public function adminUpdateDetail($id){
		// CodeIgniter Query Builder standardı
		$data["admin"] = $this->db->where('Id', $id)->get('admin')->row_array();

		$this->load->view('admin/adminUpdateDetail', $data);
	}

	public function update_save() 
{
    // Formun dışarıdan doğrudan tetiklenmesini önlemek için POST kontrolü yapıyoruz
    if ($this->input->method() !== 'post') {
        $this->session->set_flashdata('error', 'Geçersiz istek yöntemi.');
        redirect(base_url('admin/Home'), 'refresh');
        return;
    }

    // Form elemanlarından gelen verileri güvenli bir şekilde alıyoruz
    $id       = $this->input->post('id');
    $name     = $this->input->post('name');
    $user_id  = $this->input->post('user_id');
    $email    = $this->input->post('email');
    $status   = $this->input->post('status');
    $password = $this->input->post('password');

    // ID kontrolü (Güvenlik için boş olmamalı)
    if (empty($id)) {
        $this->session->set_flashdata('error', 'Güncellenecek yönetici kimliği bulunamadı.');
        redirect(base_url('admin/Home'), 'refresh');
        return;
    }

    // Güncellenecek temel verileri hazırlıyoruz
    $update_data = [
        'name'    => $name,
        'user_id' => $user_id,
        'email'   => $email,
        'status'  => ($status == '1') ? 1 : 0 // Radio butondan gelen veriyi integer'a eşitliyoruz
    ];

    // Şifre alanı boş değilse veritabanına gönderilecek veriye ekliyoruz
    // (Not: Eğer sisteminizde md5, sha1 veya password_hash kullanılıyorsa burayı ona göre sarmalayabilirsiniz)
    if (!empty($password)) {
        $update_data['password'] = $password; 
    }

    // Veritabanı güncelleme işlemi
    $this->db->where('Id', $id);
    $result = $this->db->update('admin', $update_data);

    if ($result) {
        // Eğer güncellenen kişi o an oturum açmış olan admin ise, 
        // sol menü ve üst barın anlık değişmesi için session verilerini de güncelliyoruz
        $oturum = $this->session->userdata('oturum_admin');
        if (!empty($oturum) && $oturum['id'] == $id) {
            $oturum['name']    = $name;
            $oturum['email']   = $email;
            $oturum['user_id'] = $user_id;
            $this->session->set_userdata('oturum_admin', $oturum);
        }

        $this->session->set_flashdata('success', 'Yönetici bilgileri başarıyla güncellendi.');
    } else {
        $this->session->set_flashdata('error', 'Veritabanı güncellemesi sırasında bir hata oluştu.');
    }

    // Kullanıcıyı işlem yaptığı güncelleme detay sayfasına geri yönlendiriyoruz
    redirect(base_url('admin/adminsettings/adminUpdateDetail/' . $id), 'refresh');
}

public function adminDelete($id)
{
    // Güvenlik Kontrolü: Silinmek istenen ID boş mu veya sistemde böyle bir admin var mı?
    if (empty($id) || !is_numeric($id)) {
        $this->session->set_flashdata('error', 'Geçersiz veya eksik yönetici kimliği.');
        redirect(base_url('admin/Adminsettings/AdminUpdate'), 'refresh'); // Listeleme fonksiyonunun adıyla güncelleyebilirsin
        return;
    }

    // Kendi Kendini Silme Engeli (Önemli Güvenlik Duvarı): 
    // Adminin yanlışlıkla o an açık olan kendi oturumunu silmesini engelliyoruz.
    $oturum = $this->session->userdata('oturum_admin');
    if (!empty($oturum) && $oturum['id'] == $id) {
        $this->session->set_flashdata('error', 'Kendi yönetici hesabınızı silemezsiniz! Aktif oturumunuz bulunmaktadır.');
        redirect(base_url('admin/Adminsettings/AdminUpdate'), 'refresh');
        return;
    }

    // İSTEĞE BAĞLI GELİŞMİŞ ÖZELLİK: Eğer silinen adminin eski bir profil resmi varsa sunucudan (uploads klasöründen) kaldırıyoruz
    $admin_data = $this->db->where('Id', $id)->get('admin')->row();
    if (!empty($admin_data->profile_image)) {
        $file_path = './uploads/' . $admin_data->profile_image;
        if (file_exists($file_path)) {
            unlink($file_path); // Dosyayı sunucudan kalıcı olarak siler
        }
    }

    // Veritabanından silme işlemi
    $this->db->where('Id', $id);
    $result = $this->db->delete('admin');

    if ($result) {
        $this->session->set_flashdata('success', 'Yönetici hesabı ve bağlı tüm dosyaları başarıyla silindi.');
    } else {
        $this->session->set_flashdata('error', 'Silme işlemi sırasında veritabanı hatası oluştu.');
    }

    // İşlem bittikten sonra admin listesinin olduğu sayfaya geri yönlendiriyoruz
    // Not: Eğer listeleme fonksiyonunun ismi "index" veya farklı bir şeyse buradaki URL'i ona göre düzenleyebilirsin.
    	redirect(base_url('admin/Adminsettings/AdminUpdate'), 'refresh');
	}

	public function Adminpermissions()
	{
        $programmer=$this->session->oturum_admin['programmer'];
		$user_id=$this->session->oturum_admin['id'];
		if($programmer==1){
			$sorgu=$this->db->query("SELECT * FROM admin");
    		$data["admin"]=$sorgu->result();
		}else{
			$sorgu=$this->db->query("SELECT * FROM admin WHERE programmer<>1");
    		$data["admin"]=$sorgu->result();
		}

        $sorgu=$this->db->query("SELECT * FROM roles");
        $data["roles"]=$sorgu->result();

        $this->load->view('admin/permissions', $data);
        
	}

	public function role_add_admin()
	{
        $data=array(
        'admin_id'=>$this->input->post('admin_id'),
        'role_id'=>$this->input->post('role_id'),
        );
        $this->Database_Model->insert_data("role_admins",$data);
            redirect(base_url()."admin/Adminsettings/AdminPermissions");
    }

    public function role_delete_admin($id)
	{
		$this->db->query("DELETE FROM role_admins WHERE Id=$id");
        redirect(base_url()."admin/Adminsettings/AdminPermissions");
    }

}