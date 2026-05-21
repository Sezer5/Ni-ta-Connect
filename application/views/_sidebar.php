<div class="sidebar">
    <div class="sidebar-user-card text-center">
        <?php 
                                        // Eğer veritabanında görsel yolu varsa onu bas, yoksa ui-avatars üret
                                        $avatar_url = (!empty($this->session->oturum_data['profile_image'])) 
                                            ? base_url('uploads/'.$this->session->oturum_data['profile_image']) 
                                            : "https://ui-avatars.com/api/?name=".urlencode($this->session->oturum_data['name'])."&background=004085&color=fff&size=128";
                                    ?>
        <img src="<?= $avatar_url ?>" class="sidebar-user-img" alt="User Avatar">
        <div style="font-weight: 700; color: var(--nigtas-blue);">
            <?=$this->session->oturum_data['name'];?>
        </div>
        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;font-family:Pirulen">Niğtaş Connect</div>
    </div>

    <div class="p-3">
        <nav class="nav flex-column gap-1">
            <?php 
                // URL'deki ilk segmenti alıyoruz (Örn: Home, Irsaliye vb.)
                $active_menu = $this->uri->segment(1); 
            ?>

            <a class="nav-link <?= ($active_menu == 'Home' || $active_menu == '') ? 'active' : '' ?>" href="<?=base_url()?>Home">
                <i class="fa-solid fa-house me-3"></i> Dashboard
            </a>
            
            <a class="nav-link <?= ($active_menu == 'Profil') ? 'active' : '' ?>" href="<?=base_url()?>Profil">
                <i class="fa-solid fa-user me-3"></i> Profil
            </a>
            
            <a class="nav-link <?= ($active_menu == 'Irsaliye') ? 'active' : '' ?>" href="<?=base_url()?>Irsaliye">
                <i class="fa-solid fa-file me-3"></i> Açık İrsaliyeler
            </a>

            <a class="nav-link <?= ($active_menu == 'Siparisler') ? 'active' : '' ?>" href="<?=base_url()?>Siparisler">
                <i class="fa-solid fa-shopping-cart me-3"></i> Açık Siparişler
            </a>

            <hr class="my-2" style="opacity: 0.1; color: var(--nigtas-blue);">

            <?php 
                // Alt menülerden biri aktifse ana menüyü de aktif ve açık göstermek için kontrol
                $is_finans_active = ($active_menu == 'Risk' || $active_menu == 'Ekstreler');
            ?>
            <a class="nav-link d-flex align-items-center justify-content-between <?= $is_finans_active ? 'active' : '' ?>" 
               data-bs-toggle="collapse" 
               href="#finansMenu" 
               role="button" 
               aria-expanded="<?= $is_finans_active ? 'true' : 'false' ?>" 
               aria-controls="finansMenu">
                <span>
                    <i class="fa-solid fa-wallet me-3"></i> Finansal İşlemler
                </span>
                <i class="fa-solid fa-chevron-down submenu-arrow transition-all" style="font-size: 0.8rem;"></i>
            </a>
            
            <div class="collapse <?= $is_finans_active ? 'show' : '' ?>" id="finansMenu">
                <div class="d-flex flex-column gap-1 ps-3 mt-1 border-start ms-3" style="border-color: rgba(0, 64, 133, 0.2) !important;">
                    
                    <a class="nav-link py-2 <?= ($active_menu == 'Risk') ? 'active' : '' ?>" href="<?=base_url()?>Risk" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-area-chart me-2" style="font-size: 0.8rem;"></i> Risk Analizi
                    </a>
                    
                    <a class="nav-link py-2 <?= ($active_menu == 'Ekstreler') ? 'active' : '' ?>" href="<?=base_url()?>Ekstreler" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-book me-2" style="font-size: 0.8rem;"></i> Ekstreler
                    </a>
                    
                </div>
            </div>
            </nav>
    </div>
    
    <div class="mt-auto p-4">
        <a href="<?=base_url()?>Messages" class="nav-link text-success m-0"><i class="fa-solid fa-envelope me-3"></i> İletişim</a>
        <a href="<?=base_url()?>Login/logout" class="nav-link text-danger m-0"><i class="fa-solid fa-power-off me-3"></i> Çıkış</a>
    </div>
</div>

<style>
    .nav-link[aria-expanded="true"] .submenu-arrow {
        transform: rotate(180deg);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    /* Alt menü aktifken sol çizgiyi belirginleştirme */
    .collapse .nav-link.active {
        background-color: transparent !important;
        color: var(--nigtas-blue) !important;
        font-weight: 700;
    }
</style>