<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; }
    /* Profil resmi önizleme alanı için şık stiller */
    .profile-preview-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin-bottom: 15px;
    }
    .profile-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="pirulen mb-4" style="color: #1a237e; font-size: 1.2rem;">Admin Ekle</h2>
        
        <?php if($this->session->userdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="fa-solid fa-check-circle me-2"></i>
                <?= $this->session->userdata('success'); ?>
            </div>
            <?php $this->session->unset_userdata('success'); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <form action="<?= base_url('admin/Adminsettings/save') ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="fw-bold small">Ad Soyad</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-address-card text-primary"></i></span>
                                <input type="text" name="name" class="form-control border-start-0" placeholder="Ad Soyad giriniz..." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">User Id</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-user text-primary"></i></span>
                                <input type="text" name="user_id" class="form-control border-start-0" placeholder="User Id giriniz..." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">E-Posta Adresi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control border-start-0" placeholder="Email giriniz..." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">Şifre</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-key text-primary"></i></span>
                                <input type="text" name="password" class="form-control border-start-0" placeholder="Şifre giriniz..." required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3 pirulen" style="font-size: 11px; padding: 12px;">
                             KAYDET
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    // Dosya inputu değiştiğinde tetiklenir
    $('#profileImageInput').change(function() {
        const file = this.files[0];
        if (file) {
            // Dosyanın gerçekten resim olup olmadığını kontrol edelim
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                // Resim başarıyla okunduğunda preview elementine ata
                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(file);
            } else {
                alert('Lütfen geçerli bir resim dosyası seçiniz.');
                $(this).val(''); // Inputu temizle
            }
        }
    });
});
</script>

<?php $this->load->view('_footer'); ?>