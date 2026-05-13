<div class="topbar">
    <div class="topbar-left d-flex align-items-center">
        <img src="<?php echo base_url("uploads/logoA4.jpg"); ?>" alt="Logo" style="height: 35px;">
        <div class="brand-text">NİĞTAŞ CONNECT</div>        
    </div>

    <div class="topbar-right d-flex align-items-center">
        <div class="dropdown">
            <div class="user-pill dropdown-toggle shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($this->session->oturum_data['name']); ?>&background=004085&color=fff" class="rounded-circle" width="32" height="32">
                <span class="user-pill-name">
                    <?=$this->session->oturum_data['name'];?>
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