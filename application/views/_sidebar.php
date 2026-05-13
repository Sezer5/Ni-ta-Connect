<div class="sidebar">
    <div class="sidebar-user-card text-center">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($this->session->oturum_data['name']); ?>&background=004085&color=fff" class="sidebar-user-img" alt="User Avatar">
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

            <a class="nav-link <?= ($active_menu == 'Risk') ? 'active' : '' ?>" href="<?=base_url()?>Risk">
                <i class="fa-solid fa-area-chart me-3"></i> Risk
            </a>

            <a class="nav-link <?= ($active_menu == 'Ekstreler') ? 'active' : '' ?>" href="<?=base_url()?>Ekstreler">
                <i class="fa-solid fa-book me-3"></i> Ekstreler
            </a>
           
        </nav>
    </div>

    <div class="mt-auto p-4">
        <a href="<?=base_url()?>Login/logout" class="nav-link text-danger m-0"><i class="fa-solid fa-power-off me-3"></i> Çıkış</a>
    </div>
</div>