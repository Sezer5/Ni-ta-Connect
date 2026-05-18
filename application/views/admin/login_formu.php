<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niğtaş Connect - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* Arka plana resim atama */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
            url('<?php echo base_url("uploads/adminLogin.png"); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            
            /* Opasite ayarı: Beyaz rengin %85 yoğunluğu */
            background-color: rgba(255, 255, 255, 0.5); 
            
            /* Arkadaki resmi bulanıklaştıran modern cam efekti */
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

        .logo-img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        /* Input alanlarını kartla uyumlu hale getirmek için opsiyonel */
        .form-control {
            background-color: rgba(255, 255, 255, 0.9) !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card p-4">
                <div class="text-center">
                    <!-- CI3 Base URL ile logo kullanımı -->
                    <img src="<?= base_url('uploads/logoA4.jpg'); ?>" alt="Niğtaş Logo" class="logo-img">
                    <h4 class="fw-bold text-dark mb-1">Niğtaş Connect <br> Admin</h4>
                    <p class="text-muted small mb-4">Hoşgeldiniz, lütfen giriş yapın.</p>
                    <!-- Hata mesajının görünmesini istediğin yere yapıştır -->
                    <?php if($this->session->flashdata('login_hata')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('login_hata'); ?>
                        </div>
                        <?php 
                            // Mesaj bir kez ekrana basıldı, şimdi session'dan tamamen silelim.
                            // Böylece F5 yapıldığında bu IF bloğu FALSE dönecektir.
                            $this->session->unset_userdata('login_hata'); 
                        ?>
                    <?php endif; ?>
                    
                </div>
                <form action="<?=base_url()?>admin/Login/login_ol" method="post">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Kullanıcı Adı</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-envelope text-muted"></i></span>
                            <input type="text" name="user_id" class="form-control border-start-0" placeholder="Kullanıcı Adı Giriniz">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small">Şifre</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">Giriş Yap</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Sayfa yüklendiğinde alert varsa 3 saniye bekle ve yavaşça yok et
    window.addEventListener('load', function() {
        let alert = document.querySelector('.alert');
        if(alert) {
            setTimeout(function() {
                // Sadece gizlemek yerine yumuşak geçişle opaklığı azaltalım
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Yarım saniye sonra DOM'dan tamamen sil
            }, 3000);
        }
    });

    // F5 yapıldığında formun tekrar gönderilmesini (ve dolayısıyla hatanın tekrarlanmasını) engeller
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>