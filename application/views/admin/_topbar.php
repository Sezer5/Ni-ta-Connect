
<div class="topbar">
    <div class="topbar-left d-flex align-items-center">
        <img src="<?php echo base_url("uploads/logoA4.jpg"); ?>" alt="Logo" style="height: 35px;">
        <div class="brand-text">NİĞTAŞ CONNECT</div>        
    </div>

    <div class="topbar-right d-flex align-items-center">
        <div class="dropdown">
            <div class="user-pill dropdown-toggle shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                <?php 
                    // Standart userdata metoduyla session verisini çekiyoruz
                    $oturum_admin = $this->session->userdata('oturum_admin');
                    
                    // Eğer veritabanında görsel adı varsa ve klasörde mevcutsa onu bas, yoksa ui-avatars üret
                    $avatar_url = (!empty($oturum_admin['profile_image']) && file_exists('./uploads/'.$oturum_admin['profile_image'])) 
                        ? base_url('uploads/'.$oturum_admin['profile_image']) 
                        : "https://ui-avatars.com/api/?name=".urlencode($oturum_admin['name'])."&background=004085&color=fff&size=128";
                ?>
                <img src="<?= $avatar_url ?>" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                <span class="user-pill-name">
                    <?= !empty($oturum_admin['name']) ? $oturum_admin['name'] : 'Kullanıcı'; ?>
                </span>
                <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem; color: #94a3b8;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 15px;">
                <li><a class="dropdown-item py-2" href="<?=base_url()?>Profil"><i class="fa-regular fa-circle-user me-2"></i> Profilim</a></li>
                <li><hr class="dropdown-divider opacity-50"></li>
                <li><a class="dropdown-item py-2 text-danger" href="<?=base_url()?>Login/logout"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Güvenli Çıkış</a></li>
            </ul>
        </div>
    </div>
</div>