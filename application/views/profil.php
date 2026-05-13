<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="pirulen mb-4" style="color: #1a237e; font-size: 1.2rem;">PROFİL AYARLARI</h2>
        <!-- Başlığın hemen altına ekleyin -->
        <?php if($this->session->userdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="fa-solid fa-check-circle me-2"></i>
                <?= $this->session->userdata('success'); ?>
            </div>
            <?php 
                // Mesajı gösterdikten sonra session'dan elle siliyoruz 
                $this->session->unset_userdata('success'); 
            ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <form action="<?= base_url('profil/update') ?>" method="POST">
                        
                        <!-- Değiştirilemez Alanlar (Salt Okunur) -->
                        <div class="mb-3">
                            <label class="text-muted small">Cari Ünvan</label>
                            <input type="text" class="form-control bg-light border-0" value="<?= $user['name'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Kullanıcı Adı</label>
                            <input type="text" class="form-control bg-light border-0" value="<?= $user['user_id'] ?>" readonly>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <!-- Değiştirilebilir Alanlar -->
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

<?php $this->load->view('_footer'); ?>