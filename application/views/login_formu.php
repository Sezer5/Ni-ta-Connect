<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niğtaş - Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* Arka plana resim atama */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
            url('<?php echo base_url("uploads/login.png"); ?>');
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
            
            /* Opasite ayarı: Beyaz rengin %50 yoğunluğu */
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

        /* Üye Ol Linki ve Çizgisi İçin Yeni Stiller */
        .register-wrapper {
            position: relative;
            text-align: center;
        }
        
        .register-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: rgba(0, 0, 0, 0.4);
            font-size: 12px;
            font-weight: 500;
        }

        .register-divider::before,
        .register-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        }

        .register-divider:not(:empty)::before {
            margin-right: .5em;
        }

        .register-divider:not(:empty)::after {
            margin-left: .5em;
        }

        .btn-register-link {
            color: #004085;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .btn-register-link:hover {
            color: #002244;
            text-decoration: underline;
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
                    <img src="<?= base_url('uploads/logoA4.jpg'); ?>" alt="Niğtaş Logo" class="logo-img">
                    <h4 class="fw-bold text-dark mb-1">Niğtaş Connect</h4>
                    <p class="text-muted small mb-4">Hoşgeldiniz, lütfen giriş yapın.</p>
                    
                    <?php if($this->session->flashdata('login_hata')): ?>
                        <div class="alert alert-danger shadow-sm py-2">
                            <?= $this->session->flashdata('login_hata'); ?>
                        </div>
                        <?php 
                            // Mesaj bir kez ekrana basıldı, şimdi session'dan tamamen silelim.
                            $this->session->unset_userdata('login_hata'); 
                        ?>
                    <?php endif; ?>
                </div>
                
                <?php echo form_open('Login/login_ol'); ?>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Kullanıcı Adı</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-regular fa-envelope text-muted"></i></span>
                            <input type="text" name="user_id" class="form-control border-start-0" placeholder="Kullanıcı Adı Giriniz" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small">Şifre</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">Giriş Yap</button>
                    
                    <div class="register-wrapper mt-3">
                        <div class="register-divider mb-3">veya</div>
                        <p class="small text-dark mb-0">
                            Bir hesabınız yok mu? 
                            <a href="<?= base_url('Login/uye_ol'); ?>" class="btn-register-link">Üye Olun</a>
                        </p>
                    </div>
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
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Yarım saniye sonra DOM'dan tamamen sil
            }, 3000);
        }
    });

    // F5 yapıldığında formun tekrar gönderilmesini engeller
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>