<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

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
        <h2 class="pirulen mb-4" style="color: #1a237e; font-size: 1.2rem;">PROFİL AYARLARI</h2>
        
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
                    <form action="<?= base_url('profil/update') ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="text-muted small">Cari Ünvan</label>
                            <input type="text" class="form-control bg-light border-0" value="<?= $user['name'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Kullanıcı Adı</label>
                            <input type="text" class="form-control bg-light border-0" value="<?= $user['user_id'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small d-block mb-2">Profil Resmi <span style="color:red">(Max. 2Mb)</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="profile-preview-wrapper">
                                    <?php 
                                        // Eğer veritabanında görsel yolu varsa onu bas, yoksa ui-avatars üret
                                        $avatar_url = (!empty($user['profile_image'])) 
                                            ? base_url('uploads/'.$user['profile_image']) 
                                            : "https://ui-avatars.com/api/?name=".urlencode($user['name'])."&background=004085&color=fff&size=128";
                                    ?>
                                    <img id="profileImagePreview" src="<?= $avatar_url ?>" class="profile-preview-img" alt="Profil Önizleme">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" id="profileImageInput" class="form-control" name="profile_image" accept="image/*">
                                    <small class="text-muted d-block mt-1">Sadece JPG, JPEG veya PNG formatları.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="mb-3">
                            <label class="fw-bold small">E-Posta Adresi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control border-start-0" value="<?= $user['email'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold small">Yeni Şifre</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-lock text-primary"></i></span>
                                <input type="password" name="password" class="form-control border-start-0" placeholder="Değiştirmek istemiyorsanız boş bırakın">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-3 pirulen" style="font-size: 11px; padding: 12px;">
                            GÜNCELLEMELERİ KAYDET
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