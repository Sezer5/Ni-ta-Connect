<?php $this->load->view('admin/_header'); ?>

<div class="main-content p-4">
    <div class="col-lg-8 mx-auto">
        
        <a href="<?= base_url('Admin/uyelik_istekleri') ?>" class="btn btn-sm btn-light border mb-3 rounded-3 shadow-sm text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Listeye Geri Dön
        </a>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <?php 
                $header_bg = 'bg-secondary';
                if($istek['status'] == 1) $header_bg = 'bg-success';
                if($istek['status'] == 2) $header_bg = 'bg-danger';
            ?>
            <div class="<?= $header_bg ?> text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase small fw-bold opacity-75">Üyelik İstek Detayı</span>
                        <h3 class="fw-bold mb-0 mt-1"><?= $istek['name'] ?></h3>
                    </div>
                    <span class="badge bg-white text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">
                        ID: #<?= $istek['id'] ?>
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <?php if($this->session->flashdata('islem_sonuc')): ?>
                    <div class="alert alert-<?= $this->session->flashdata('islem_durum') ?> shadow-sm">
                        <?= $this->session->flashdata('islem_sonuc') ?>
                    </div>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-md-6 border-bottom pb-3">
                        <label class="text-muted small fw-semibold text-uppercase d-block">Yetkili Kişi (person)</label>
                        <span class="fs-5 fw-bold text-dark"><i class="fa-regular fa-user text-primary me-2"></i><?= $istek['person'] ?></span>
                    </div>
                    <div class="col-md-6 border-bottom pb-3">
                        <label class="text-muted small fw-semibold text-uppercase d-block">Vergi / TC Numarası (taxnumber)</label>
                        <span class="fs-5 fw-bold text-dark"><i class="fa-solid fa-id-card text-primary me-2"></i><?= $istek['taxnumber'] ?></span>
                    </div>
                    <div class="col-md-6 border-bottom pb-3">
                        <label class="text-muted small fw-semibold text-uppercase d-block">Telefon Numarası (tel)</label>
                        <span class="fs-5 fw-bold text-dark"><i class="fa-solid fa-phone text-primary me-2"></i><?= $istek['tel'] ?></span>
                    </div>
                    <div class="col-md-6 border-bottom pb-3">
                        <label class="text-muted small fw-semibold text-uppercase d-block">Başvuru Tarihi (created_at)</label>
                        <span class="fs-5 fw-bold text-dark"><i class="fa-regular fa-calendar text-primary me-2"></i><?= date('d.m.Y H:i:s', strtotime($istek['created_at'])) ?></span>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Açık Adres (address)</label>
                        <div class="p-3 bg-light rounded-3 text-dark border shadow-inner">
                            <i class="fa-solid fa-location-dot text-danger me-2"></i><?= $istek['address'] ?>
                        </div>
                    </div>
                </div>

                <?php if($istek['status'] != 0): ?>
                    <div class="alert alert-light border d-flex align-items-center mb-4 rounded-3 shadow-sm">
                        <i class="fa-solid fa-user-shield text-secondary fs-3 me-3"></i>
                        <div>
                            <div class="small text-muted fw-semibold">BU TALEP İLE İLGİLENEN ADMİN:</div>
                            <div class="fw-bold text-dark">Admin ID: #<?= $istek['admin_id'] ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($istek['status'] == 0): ?>
                    <div class="d-flex gap-3 mt-4">
                        
                        <?php echo form_open('Admin/basvuru_aksiyon', array('class' => 'w-100')); ?>
                            <input type="hidden" name="id" value="<?= $istek['id'] ?>">
                            <input type="hidden" name="islem" value="onayla">
                            <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-check-double me-2"></i> BAŞVURUYU ONAYLA
                            </button>
                        <?php echo form_close(); ?>

                        <?php echo form_open('Admin/basvuru_aksiyon', array('class' => 'w-100')); ?>
                            <input type="hidden" name="id" value="<?= $istek['id'] ?>">
                            <input type="hidden" name="islem" value="reddet">
                            <button type="submit" class="btn btn-outline-danger w-100 py-2.5 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-ban me-2"></i> BAŞVURUYU REDDET
                            </button>
                        <?php echo form_close(); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center text-muted p-2 bg-light rounded-3 border">
                        <i class="fa-solid fa-lock me-1"></i> Bu talep üzerinde işlem yapılmıştır ve kayıt arşive alınmıştır.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/_footer'); ?>