<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    
    /* Premium Tablo Kartı Stilleri */
    .custom-table-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    }

    .custom-table {
        margin-bottom: 0;
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

    .custom-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .custom-table tbody td {
        padding: 14px 16px;
        color: #334155;
        font-size: 0.9rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Profil Resmi Listeleme Alanı */
    .table-avatar {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Durum Rozetleri (Badges) */
    .badge-status-active {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-status-passive {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* İşlem Butonları */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .btn-action-edit {
        background-color: rgba(26, 35, 126, 0.1);
        color: #1a237e;
        border: 1px solid rgba(26, 35, 126, 0.15);
    }
    .btn-action-edit:hover {
        background-color: #1a237e;
        color: #fff;
    }

    .btn-action-delete {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.15);
    }
    .btn-action-delete:hover {
        background-color: #ef4444;
        color: #fff;
    }
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="p-2 bg-white shadow-sm rounded-3" style="border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-users-gear text-primary fs-4 px-1"></i>
            </div>
            <div>
                <h2 class="pirulen m-0" style="color: #1a237e; font-size: 1.2rem;">YÖNETİCİ LİSTESİ</h2>
                <p class="text-muted small m-0 mt-1">Sistem genelindeki tüm admin hesaplarını görüntüleyebilir, düzenleyebilir veya silebilirsiniz.</p>
            </div>
        </div>

        <div class="card border-0 rounded-4 custom-table-card overflow-hidden">
            <div class="table-responsive">
                <table class="table custom-table text-nowrap">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="70">Profil</th>
                            <th>Ad Soyad</th>
                            <th width="150">Durum</th>
                            <th width="100" class="text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($admin as $rs){ ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?= $rs->Id ?></td>
                                <td>
                                    <?php 
                                        $avatar_url = (!empty($rs->profile_image) && file_exists('./uploads/'.$rs->profile_image)) 
                                            ? base_url('uploads/'.$rs->profile_image) 
                                            : "https://ui-avatars.com/api/?name=".urlencode($rs->name)."&background=004085&color=fff&size=128";
                                    ?>
                                    <img src="<?= $avatar_url ?>" class="table-avatar" alt="Avatar">
                                </td>
                                <td class="fw-semibold text-dark"><?= $rs->name ?></td>
                                <td>
                                    <?php if($rs->status == 1): ?>
                                        <span class="badge-status-active"><i class="fa-solid fa-circle-check me-1"></i> AKTİF</span>
                                    <?php else: ?>
                                        <span class="badge-status-passive"><i class="fa-solid fa-circle-minus me-1"></i> PASİF</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('admin/Adminsettings/adminUpdateDetail/'.$rs->Id) ?>" 
                                           class="btn btn-action btn-action-edit" 
                                           title="Düzenle">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/Adminsettings/adminDelete/'.$rs->Id) ?>" 
                                           class="btn btn-action btn-action-delete" 
                                           onclick="return confirm('Bu yönetici hesabını tamamen silmek istediğinize emin misiniz?');" 
                                           title="Sil">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('admin/_footer'); ?>