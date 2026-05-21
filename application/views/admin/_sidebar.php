<div class="sidebar">
    <div class="sidebar-user-card text-center">
        <?php 
            // Eğer veritabanında görsel yolu varsa onu bas, yoksa ui-avatars üret
            $avatar_url = (!empty($this->session->oturum_admin['profile_image'])) 
                ? base_url('uploads/'.$this->session->oturum_admin['profile_image']) 
                : "https://ui-avatars.com/api/?name=".urlencode($this->session->oturum_admin['name'])."&background=004085&color=fff&size=128";
        ?>
        <img src="<?= $avatar_url ?>" class="sidebar-user-img" alt="User Avatar">
        <div style="font-weight: 700; color: var(--nigtas-blue);">
            <?=$this->session->oturum_admin['name'];?>
        </div>
        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;font-family:Pirulen">Niğtaş Connect</div>
    </div>

    <div class="p-3">
        <nav class="nav flex-column gap-1">
            <?php 
                // URL diziliminin tamamını alıyoruz (Örn: admin/Home, admin/Profil, Risk vb.)
                $current_uri = $this->uri->uri_string(); 
            ?>

            <a class="nav-link <?= ($current_uri == 'admin/Home' || $current_uri == 'admin' || $current_uri == '') ? 'active' : '' ?>" href="<?=base_url()?>admin/Home">
                <i class="fa-solid fa-house me-3"></i> Dashboard
            </a>
            
            <a class="nav-link <?= ($current_uri == 'admin/Profil') ? 'active' : '' ?>" href="<?=base_url()?>admin/Profil">
                <i class="fa-solid fa-user me-3"></i> Profil
            </a>

            <?php if($this->Admin_Permission_Model->adminGeneralPermission($this->session->oturum_admin['id'],1) == 1){?>
                <a class="nav-link <?= ($current_uri == 'admin/Roles') ? 'active' : '' ?>" href="<?=base_url()?>admin/Roles">
                    <i class="fa-solid fa-users me-3"></i> Admin Rolleri
                </a>
            <?php }?>
            
            <hr class="my-2" style="opacity: 0.1; color: var(--nigtas-blue);">

            <?php if($this->Admin_Permission_Model->adminGeneralPermission($this->session->oturum_admin['id'], 3) == 1){ ?>
                <?php 
                    // DÜZELTME: href adreslerinizle tam eşleşmesi için URI kontrol alanları güncellendi
                    $is_admin_active = ($current_uri == 'admin/Adminsettings/AdminAdd' || $current_uri == 'admin/Adminsettings/AdminUpdate' || $current_uri == 'admin/Adminsettings/AdminPermissions' || strpos($current_uri, 'admin/adminSettings/adminUpdateDetail') !== false);
                ?>
                <a class="nav-link d-flex align-items-center justify-content-between <?= $is_admin_active ? 'active' : '' ?>" 
                data-bs-toggle="collapse" 
                href="#adminMenu" 
                role="button" 
                aria-expanded="<?= $is_admin_active ? 'true' : 'false' ?>" 
                aria-controls="adminMenu">
                    <span>
                        <i class="fa-solid fa-user-gear me-3"></i> Admin İşlemler
                    </span>
                    <i class="fa-solid fa-chevron-down submenu-arrow transition-all" style="font-size: 0.8rem;"></i>
                </a>

                <div class="collapse <?= $is_admin_active ? 'show' : '' ?>" id="adminMenu">
                    <div class="d-flex flex-column gap-1 ps-3 mt-1 border-start ms-3" style="border-color: rgba(0, 64, 133, 0.2) !important;">
                        
                        <a class="nav-link py-2 <?= ($current_uri == 'admin/Adminsettings/AdminAdd') ? 'active' : '' ?>" href="<?=base_url()?>admin/Adminsettings/AdminAdd" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-user-plus me-2" style="font-size: 0.8rem;"></i> Admin Ekle
                        </a>
                        
                        <a class="nav-link py-2 <?= ($current_uri == 'admin/Adminsettings/AdminUpdate' || strpos($current_uri, 'admin/adminSettings/adminUpdateDetail') !== false) ? 'active' : '' ?>" href="<?=base_url()?>admin/Adminsettings/AdminUpdate" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-user-pen me-2" style="font-size: 0.8rem;"></i> Admin Güncelle
                        </a>
                        
                        <a class="nav-link py-2 <?= ($current_uri == 'admin/Adminsettings/AdminPermissions') ? 'active' : '' ?>" href="<?=base_url()?>admin/Adminsettings/AdminPermissions" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-shield-halved me-2" style="font-size: 0.8rem;"></i> Yetkilendirme
                        </a>
                        
                    </div>
                </div>
            <?php } ?>
            </nav>
    </div>

    <div class="mt-auto p-4">
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