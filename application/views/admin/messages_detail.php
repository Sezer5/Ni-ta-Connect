<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    .meta-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .meta-value { font-size: 14px; color: #1e293b; font-weight: 500; }
    .message-body { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; font-size: 14px; color: #334155; white-space: pre-line; line-height: 1.6; }
    
    /* Buton Özelleştirmeleri */
    .btn-action { font-size: 11px; font-weight: 700; padding: 10px 20px; border-radius: 10px; transition: all 0.2s ease; }
    .btn-back { background-color: #f1f5f9; color: #475569; }
    .btn-back:hover { background-color: #e2e8f0; color: #1e293b; }
</style>

<div class="main-content">
    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold mb-0 pirulen" style="color: var(--nigtas-blue); font-size: 1.2rem;">MESAJ İÇERİĞİ</h2>
                    <a href="<?= base_url('admin/messages') ?>" class="btn btn-action btn-back pirulen">
                        <i class="fa-solid fa-arrow-left me-1"></i> LİSTEYE DÖN
                    </a>
                </div>
                <hr style="opacity: 0.1;">

                <div class="mb-4">
                    <div class="meta-label pirulen">MESAJ BAŞLIĞI</div>
                    <h4 class="fw-bold text-dark m-0"><?= htmlspecialchars($message->title) ?></h4>
                </div>

                <div class="mb-2">
                    <div class="meta-label pirulen">MESAJ METNİ</div>
                    <div class="message-body">
                        <?= htmlspecialchars($message->description) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h2 class="fw-bold mb-3 pirulen" style="color: var(--nigtas-blue); font-size: 1.1rem;">BİLGİLER & AKSİYON</h2>
                    <hr style="opacity: 0.1;" class="mb-4">

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="meta-label pirulen">GÖNDEREN KULLANICI</div>
                        <div class="meta-value fw-bold text-primary"><?= $message->user_name ?></div>
                        <small class="text-muted">Kullanıcı Kodu: <?= $message->code ?></small>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="meta-label pirulen">KONU KATEGORİSİ</div>
                        <div class="meta-value">
                            <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(26, 35, 126, 0.1); color: #1a237e; font-size: 11px;">
                                <?= $message->topic_name ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="meta-label pirulen">GÖNDERİLME TARİHİ</div>
                        <div class="meta-value text-secondary">
                            <i class="fa-regular fa-calendar-days me-1"></i> <?= date('d.m.Y H:i', strtotime($message->created_at)) ?>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="meta-label pirulen">İLGİLENEN ADMİN</div>
                        <div class="meta-value">
                            <?= !empty($message->admin_name) ? '<span class="text-success fw-bold"><i class="fa-solid fa-user-shield me-1"></i> '.$message->admin_name.'</span>' : '<span class="text-muted italic">Henüz Kimse Atanmadı</span>'; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="meta-label pirulen">MESAJ DURUMU</div>
                        <div class="meta-value">
                            <?php if(isset($message->status) && $message->status == 1): ?>
                                <span class="badge bg-success text-white px-3 py-2 fw-bold" style="font-size: 11px;">AKTİF</span>
                            <?php else: ?>
                                <span class="badge bg-secondary text-white px-3 py-2 fw-bold" style="font-size: 11px;">PASİF (KAPATILDI)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 pt-3 border-top" style="border-top-style: dashed !important;">
                    
                    <?php if(empty($message->admin_id)): ?>
                        
                        <a href="<?= base_url('admin/messages/assign_admin/'.$message->Id) ?>" class="btn btn-action btn-primary pirulen py-3 shadow-sm">
                            <i class="fa-solid fa-hand-holding-hand me-2 fs-6"></i> MESAJLA İLGİLEN
                        </a>
                    
                    <?php elseif(!empty($message->admin_id) && $message->status == 1): ?>
                        
                        <a href="<?= base_url('admin/messages/deactivate_message/'.$message->Id) ?>" class="btn btn-action btn-danger pirulen py-3 shadow-sm" onclick="return confirm('Bu mesajı pasife almak istediğinize emin misiniz? Bu işlem geri alınamaz!');">
                            <i class="fa-solid fa-toggle-off me-2 fs-6"></i> MESAJI PASİFE AL
                        </a>
                    
                    <?php else: ?>
                        <div class="alert alert-secondary text-center small fw-bold m-0 border-0 p-2" style="font-size:11px;">
                            <i class="fa-solid fa-lock me-1"></i> BU MESAJ KİLİTLENMİŞTİR
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div>
</div>

<?php $this->load->view('admin/_footer'); ?>