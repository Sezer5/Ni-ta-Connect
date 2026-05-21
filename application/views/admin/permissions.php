<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<?php $this->load->view('admin/dashboard/_styles'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    
    /* Premium Kart ve Tablo Stilleri */
    .custom-table-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    }

    .custom-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table tbody td {
        padding: 16px;
        color: #334155;
        font-size: 0.9rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Dinamik Rol Rozetleri (Badges) */
    .role-badge {
        display: inline-flex;
        align-items: center;
        background-color: #f1f5f9;
        color: #334155;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-right: 6px;
        margin-bottom: 6px;
        transition: all 0.2s;
    }

    .role-badge:hover {
        background-color: #e2e8f0;
    }

    .role-delete-btn {
        color: #ef4444;
        text-decoration: none;
        margin-right: 6px;
        font-weight: bold;
        font-size: 0.85rem;
        padding: 0 4px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .role-delete-btn:hover {
        background-color: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Seçim ve Ekleme Grubu */
    .role-select-custom {
        border: 1px solid #e2e8f0;
        border-radius: 8px 0 0 8px !important;
        font-size: 0.85rem;
        background-color: #f8fafc;
        padding: 8px 12px;
        height: 40px;
    }
    
    .role-select-custom:focus {
        border-color: #1a237e;
        box-shadow: none;
        background-color: #fff;
    }

    .role-add-btn {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
        border-radius: 0 8px 8px 0 !important;
        padding: 0 16px;
        height: 40px;
        transition: all 0.2s;
    }

    .role-add-btn:hover {
        background-color: #059669;
        border-color: #059669;
        color: white;
    }
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="p-2 bg-white shadow-sm rounded-3" style="border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-shield-halved text-primary fs-4 px-1"></i>
            </div>
            <div>
                <h2 class="pirulen m-0" style="color: #1a237e; font-size: 1.2rem;">YETKİLENDİRME PANELİ</h2>
                <p class="text-muted small m-0 mt-1">Yöneticilere modül bazlı roller atayabilir veya mevcut yetkilerini anlık olarak kaldırabilirsiniz.</p>
            </div>
        </div>

        <div class="card border-0 rounded-4 custom-table-card overflow-hidden">
            <div class="table-responsive">
                <table class="table custom-table text-nowrap m-0">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="150">Kullanıcı Adı</th>
                            <th>Ad Soyad</th>
                            <th>Atanmış Roller</th>
                            <th width="320">Yeni Rol Ekle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($admin as $as){ ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?= $as->Id ?></td>
                                <td class="text-primary fw-medium"><?= $as->user_id ?></td>
                                <td class="fw-semibold text-dark"><?= $as->name ?></td>
                                
                                <td>
                                    <div class="d-flex flex-wrap align-items-center">
                                        <?php
                                            $tempData = $this->Admin_Permission_Model->findYetkiler($as->Id);
                                            if(empty($tempData)){
                                                echo '<span class="text-muted small italic">Yetki atanmamış</span>';
                                            } else {
                                                foreach($tempData as $rs){
                                        ?>
                                                    <span class="role-badge">
                                                        <a href="<?= base_url('admin/adminSettings/role_delete_admin/'.$rs->Id) ?>" 
                                                           class="role-delete-btn" 
                                                           onclick="return confirm('Bu yetkiyi kaldırmak istediğinize emin misiniz?');"
                                                           title="Yetkiyi Kaldır">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </a> 
                                                        <?= $this->Admin_Permission_Model->findRoleAdi($rs->role_id); ?>
                                                    </span>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </div>
                                </td>
                                
                                <td>
                                    <form action="<?= base_url('admin/Adminsettings/role_add_admin') ?>" method="post" class="m-0">
                                        <input type="text" value="<?= $as->Id ?>" name="admin_id" hidden>
                                        <div class="input-group">
                                            <select name="role_id" class="form-select role-select-custom" required>
                                                <option value="" disabled selected hidden>Rol Seçiniz...</option>
                                                <?php foreach($roles as $ds){ ?>
                                                    <option value="<?= $ds->Id ?>" title="<?= $ds->description ?>"><?= $ds->name ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn role-add-btn" type="submit" title="Rolü Ata">
                                                <i class="fa-solid fa-plus fw-bold"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('admin/dashboard/_scripts'); ?>
<?php $this->load->view('admin/_footer'); ?>