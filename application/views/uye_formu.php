<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niğtaş - Üyelik Başvurusu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
            url('<?php echo base_url("uploads/login.png"); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
            padding: 40px 0;
        }

        .register-card {
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.5); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
        }

        .btn-primary {
            background-color: #004085;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #003366;
            transform: translateY(-1px);
        }

        .btn-login-link {
            color: #004085;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .btn-login-link:hover {
            color: #002244;
            text-decoration: underline;
        }

        .logo-img {
            max-width: 130px;
            margin-bottom: 15px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px;
        }
        
        .form-label {
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card register-card p-4 shadow-lg">
                <div class="text-center">
                    <img src="<?= base_url('uploads/logoA4.jpg'); ?>" alt="Niğtaş Logo" class="logo-img">
                    <h4 class="fw-bold text-dark mb-1">Yeni Üyelik Başvurusu</h4>
                    <p class="text-muted small mb-4">Lütfen kurumsal veya bireysel bilgilerinizi eksiksiz doldurun. Başvurunuz admin onayından sonra aktif edilecektir.</p>
                    
                    <?php if($this->session->flashdata('basvuru_sonuc')): ?>
                        <div class="alert alert-<?= $this->session->flashdata('basvuru_durum') == 'basarili' ? 'success' : 'danger'; ?> shadow-sm py-2 small">
                            <?= $this->session->flashdata('basvuru_sonuc'); ?>
                        </div>
                        <?php 
                            $this->session->unset_userdata('basvuru_sonuc'); 
                            $this->session->unset_userdata('basvuru_durum'); 
                        ?>
                    <?php endif; ?>
                </div>
                
                <?php echo form_open('Login/basvuru_kaydet', array('id' => 'basvuruForm')); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Firma</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-building text-muted"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Öniz Tekstil A.Ş." required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Yetkili Kişi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-regular fa-user text-muted"></i></span>
                                <input type="text" name="person" class="form-control" placeholder="Ahmet Yılmaz" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Vergi No</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-id-card text-muted"></i></span>
                                <input type="text" name="taxnumber" class="form-control" placeholder="1234567890" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Telefon Numarası</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="tel" name="tel" class="form-control" placeholder="0555 XXXXXXX" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold">Açık Adres</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-map-location-dot text-muted"></i></span>
                            <textarea name="address" class="form-control" rows="3" placeholder="Merkez Mh. Atatürk Cd. No:5 Niğde" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">Başvuruyu Gönder</button>
                    
                    <div class="text-center mt-3">
                        <p class="small text-dark mb-0">
                            Zaten bir hesabınız var mı? 
                            <a href="<?= base_url('Login'); ?>" class="btn-login-link">Giriş Yapın</a>
                        </p>
                    </div>
                <?php echo form_close(); ?>
                </div>
        </div>
    </div>
</div>

<script>
    // Mesaj bildirimlerinin otomatik kaybolması
    window.addEventListener('load', function() {
        let alert = document.querySelector('.alert');
        if(alert) {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }, 5000); // Kullanıcı rahat okusun diye 5 saniye yapıldı
        }
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>