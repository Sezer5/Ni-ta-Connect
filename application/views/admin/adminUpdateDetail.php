<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    
    /* Gelişmiş Premium Form Kartı Stilleri */
    .custom-form-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        transition: transform 0.3s ease;
    }
    
    .form-label-custom {
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        color: #334155;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }

    .form-control-custom:focus {
        background-color: #fff;
        border-color: #1a237e;
        box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.15);
        color: #1e293b;
    }

    .input-group-custom-text {
        border: 1px solid #e2e8f0;
        background-color: #f1f5f9;
        color: #64748b;
        border-radius: 10px 0 0 10px;
        padding: 0 14px;
    }

    .input-group-custom-text + .form-control-custom {
        border-radius: 0 10px 10px 0;
    }

    /* Durum (Status) Seçim Butonları */
    .status-group .btn-check:checked + .btn-outline-success {
        background-color: #10b981;
        color: #fff;
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    .status-group .btn-check:checked + .btn-outline-danger {
        background-color: #ef4444;
        color: #fff;
        border-color: #ef4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    .status-group .btn {
        font-size: 0.8rem;
        font-weight: 700;
        padding: 10px;
        border-radius: 10px;
    }

    /* Kaydet Butonu */
    .btn-submit-custom {
        background: linear-gradient(135deg, #1a237e 0%, #0d1b60 100%);
        border: none;
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-size: 11px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(26, 35, 126, 0.3);
    }

    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26, 35, 126, 0.4);
        background: linear-gradient(135deg, #283593 0%, #1a237e 100%);
    }
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="p-2 bg-white shadow-sm rounded-3" style="border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-user-gear text-primary fs-4 px-1"></i>
            </div>
            <div>
                <h2 class="pirulen m-0" style="color: #1a237e; font-size: 1.2rem;">ADMİN GÜNCELLEME DETAYI</h2>
                <p class="text-muted small m-0 mt-1">Sistem yöneticisi hesap bilgilerini ve yetki durumunu bu panelden düzenleyebilirsiniz.</p>
            </div>
        </div>
        
        <?php if($this->session->userdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-3 text-success"></i>
                <div class="fw-medium text-success-dark"><?= $this->session->userdata('success'); ?></div>
            </div>
            <?php $this->session->unset_userdata('success'); ?>
        <?php endif; ?>

        <?php if($this->session->userdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="fa-solid fa-circle-exclamation fs-5 me-3 text-danger"></i>
                <div class="fw-medium text-danger-dark"><?= $this->session->userdata('error'); ?></div>
            </div>
            <?php $this->session->unset_userdata('error'); ?>
        <?php endif; ?>

        <div class="card border-0 rounded-4 custom-form-card p-4 col-xl-8">
            <form action="<?= base_url('admin/adminsettings/update_save') ?>" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= $admin['Id'] ?>">
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">Ad Soyad</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-regular fa-user"></i></span>
                                <input type="text" name="name" class="form-control form-control-custom" value="<?= $admin['name'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">Kullanıcı Adı</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-solid fa-at"></i></span>
                                <input type="text" name="user_id" class="form-control form-control-custom" value="<?= $admin['user_id'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">E-Posta Adresi</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-regular fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-custom" value="<?= $admin['email'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">Yeni Şifre</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-solid fa-key"></i></span>
                                <input type="text" name="password" class="form-control form-control-custom" value="<?= $admin['password'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label-custom d-block mb-2">Kullanıcı Durumu</label>
                            <div class="btn-group status-group w-100" role="group">
                                <input type="radio" class="btn-check" name="status" id="statusActive" value="1" <?= $admin['status'] == 1 ? 'checked' : '' ?>>
                                <label class="btn btn-outline-success d-flex align-items-center justify-content-center gap-2" for="statusActive">
                                    <i class="fa-solid fa-user-check"></i> AKTİF YAP
                                </label>

                                <input type="radio" class="btn-check" name="status" id="statusPassive" value="0" <?= $admin['status'] == 0 ? 'checked' : '' ?>>
                                <label class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2" for="statusPassive">
                                    <i class="fa-solid fa-user-slash"></i> PASİF YAP
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="opacity: 0.1; color: #64748b;">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-submit-custom w-100 pirulen">
                        <i class="fa-solid fa-floppy-disk me-2"></i> DEĞİŞİKLİKLERİ GÜVENLE KAYDET
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/_footer'); ?>