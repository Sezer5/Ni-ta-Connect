<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    .history-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05) !important;
    }
    .table-custom th {
        font-family: 'Pirulen', sans-serif;
        font-size: 11px;
        color: #475569;
        background-color: #f8fafc;
        padding: 15px 12px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-custom td {
        padding: 15px 12px;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }
    .btn-back-custom {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-back-custom:hover {
        transform: translateY(-2px);
        background-color: #f8fafc;
        color: #1a237e;
    }
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-white shadow-sm rounded-3" style="border: 1px solid #e2e8f0;">
                    <i class="fa-solid fa-clock-rotate-left text-primary fs-4 px-1"></i>
                </div>
                <div>
                    <h2 class="pirulen m-0" style="color: #1a237e; font-size: 1.2rem;">GEÇMİŞ TALEPLERİM</h2>
                    <p class="text-muted small m-0 mt-1">Daha önce göndermiş olduğunuz destek ve iletişim taleplerinizin listesini buradan inceleyebilirsiniz.</p>
                </div>
            </div>
            
            <a href="<?= base_url('messages') ?>" class="btn btn-back-custom pirulen d-flex align-items-center gap-2">
                <i class="fa-solid fa-arrow-left fs-6"></i> YENİ TALEP OLUŞTUR
            </a>
        </div>

        <div class="card border-0 rounded-4 history-card p-4">
            <div class="table-responsive">
                <table class="table table-custom table-hover m-0">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Tarih</th>
                            <th style="width: 20%;">Konu Kategorisi</th>
                            <th style="width: 25%;">Mesaj Başlığı</th>
                            <th style="width: 35%;">Mesaj İçeriği</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($history_messages)): ?>
                            <?php foreach($history_messages as $msg): ?>
                                <tr>
                                    <td class="text-secondary fw-medium">
                                        <i class="fa-regular fa-calendar me-1"></i> <?= date('d.m.Y H:i', strtotime($msg->created_at)) ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(26, 35, 126, 0.08); color: #1a237e; font-size: 11px; font-weight: 600;">
                                            <?= htmlspecialchars($msg->topic_name) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($msg->title) ?></td>
                                    
                                    <td class="text-muted text-break">
                                        <?= htmlspecialchars($msg->description) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fs-2 mb-3 d-block text-black-50"></i>
                                    Daha önce iletilmiş herhangi bir iletişim veya destek talebiniz bulunamadı.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('_footer'); ?>