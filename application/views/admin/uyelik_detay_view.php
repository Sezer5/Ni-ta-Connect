<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<div class="main-content p-4">
    <div class="col-lg-8 mx-auto">
        
        <a href="<?= base_url('Admin/AccountRequest/uyelik_istekleri') ?>" class="btn btn-sm btn-light border mb-3 rounded-3 shadow-sm text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Listeye Geri Dön
        </a>

        <div class="alert <?= ($istek['status'] == 1) ? 'alert-success' : 'alert-dark' ?> rounded-4 shadow-sm border-0 mb-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fa-solid fa-circle-info me-2"></i> BAŞVURU DURUMU: <?= ($istek['status'] == 1) ? 'AKTİF' : 'PASİF / KİLİTLİ' ?></span>
            <?php if(!empty($istek['admin_id'])): ?>
                <span class="badge bg-white text-dark"><i class="fa-solid fa-user-shield me-1"></i> Admin #<?= $istek['admin_id'] ?></span>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h4 class="fw-bold text-primary mb-0"><i class="fa-solid fa-building-user me-2"></i> Cari Bilgileri</h4>
            </div>
            
            <div class="card-body p-4 pt-0">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Cari Unvanı / Adı</label>
                            <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($istek['name']) ?></h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Vergi / TC Numarası</label>
                            <span class="fw-bold text-dark"><i class="fa-solid fa-id-card me-2"></i><?= htmlspecialchars($istek['taxnumber']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Telefon Numarası</label>
                            <span class="fw-bold text-dark"><i class="fa-solid fa-phone me-2"></i><?= htmlspecialchars($istek['tel']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Yetkili Kişi</label>
                            <span class="fw-bold text-dark"><i class="fa-regular fa-user me-2"></i><?= htmlspecialchars($istek['person']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Başvuru Tarihi</label>
                            <span class="fw-bold text-dark"><i class="fa-regular fa-calendar me-2"></i><?= date('d.m.Y H:i', strtotime($istek['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Açık Adres</label>
                            <p class="text-dark mb-0"><i class="fa-solid fa-location-dot text-danger me-2"></i><?= htmlspecialchars($istek['address']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-4 border-top">
    <?php if(empty($istek['admin_id'])): ?>
        <div class="text-center">
            <form action="<?php echo base_url('Admin/AccountRequest/basvuru_aksiyon'); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $istek['Id']; ?>">
                <button type="submit" name="islem" value="sahiplen" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                    <i class="fa-solid fa-user-check me-2"></i> TALEBİ SAHİPLEN
                </button>
            </form>
        </div>
    <?php elseif($istek['status'] == 2): ?>
        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
            <span class="text-muted"><i class="fa-solid fa-lock-open me-2"></i> İşlem yetkisi sizde.</span>
            <form action="<?php echo base_url('Admin/AccountRequest/basvuru_aksiyon'); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $istek['Id']; ?>">
                <button type="submit" name="islem" value="pasife_cek" class="btn btn-danger px-4 rounded-pill">
                    <i class="fa-solid fa-power-off me-1"></i> PASİFE ÇEK VE KİLİTLE
                </button>
            </form>
        </div>
    <?php else: ?>
        <div class="text-center text-muted p-3">
            <i class="fa-solid fa-lock me-2"></i> Bu başvuru pasife alınmış ve kilitlenmiştir.
        </div>
    <?php endif; ?>
</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/_footer'); ?>