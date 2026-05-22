<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    
    /* İletişim Sayfası Premium Kart Tasarımları */
    .contact-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        transition: transform 0.3s ease;
    }

    .info-gradient-card {
        background: linear-gradient(135deg, #1a237e 0%, #0d1b60 100%);
        color: white;
        box-shadow: 0 10px 25px -5px rgba(26, 35, 126, 0.2) !important;
    }
    
    .form-label-custom {
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 0.9rem;
        color: #334155;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }

    .form-control-custom:focus {
        background-color: #fff;
        border-color: #1a237e;
        box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.15);
        color: #1e293b;
    }

    .input-group-custom-text {
        border: 1px solid #e2e8f0;
        background-color: #f1f5f9;
        color: #64748b;
        border-radius: 10px 0 0 10px;
        padding: 0 14px;
    }

    .input-group-custom-text + .form-control-custom {
        border-radius: 0 10px 10px 0;
    }

    /* Gönder Butonu */
    .btn-submit-custom {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        padding: 14px 28px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* 🎯 Yeni Eklenen Geçmiş Talepler Butonu Stili */
    .btn-history-custom {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .btn-history-custom:hover {
        transform: translateY(-2px);
        background-color: #f8fafc;
        color: #1a237e;
        border-color: #cbd5e1;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    /* Bilgi Listesi İkonları */
    .info-icon-box {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-white shadow-sm rounded-3" style="border: 1px solid #e2e8f0;">
                    <i class="fa-solid fa-paper-plane text-primary fs-4 px-1"></i>
                </div>
                <div>
                    <h2 class="pirulen m-0" style="color: #1a237e; font-size: 1.2rem;">İLETİŞİM DESTEK TALEBİ</h2>
                    <p class="text-muted small m-0 mt-1">Görüş, öneri ya da teknik destek taleplerinizi doğrudan ilgili birime iletebilirsiniz.</p>
                </div>
            </div>
            
            <a href="<?= base_url('messages/history') ?>" class="btn btn-history-custom pirulen d-flex align-items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left fs-6"></i> ESKİ İLETİŞİM TALEPLERİ
            </a>
        </div>
        
        <?php if($this->session->userdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-3 text-success"></i>
                <div class="fw-medium text-success-dark">
                    <strong>Başarılı!</strong> <?= $this->session->userdata('success'); ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php $this->session->unset_userdata('success'); ?>
        <?php endif; ?>

        <?php if($this->session->userdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-5 me-3 text-danger"></i>
                <div class="fw-medium text-danger-dark">
                    <strong>Hata!</strong> <?= $this->session->userdata('error'); ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php $this->session->unset_userdata('error'); ?>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 p-4 info-gradient-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="pirulen mb-3" style="font-size: 0.95rem;">Niğtaş Connect</h5>
                        <p class="small text-white-50 lh-lg">Göndermiş olduğunuz mesajlar sistem yöneticileri ve ilgili departman sorumluları tarafından incelenerek en kısa sürede tarafınıza dönüş sağlanacaktır.</p>
                    </div>
                    
                    <div class="my-3 d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-icon-box"><i class="fa-solid fa-phone"></i></div>
                            <span class="small fw-medium">+90 388 214 15 00</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-icon-box"><i class="fa-solid fa-mobile-screen-button"></i></div>
                            <span class="small fw-medium">+90 532 715 43 55</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-icon-box"><i class="fa-solid fa-print"></i></div>
                            <span class="small fw-medium">+90 388 233 53 04</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-icon-box"><i class="fa-solid fa-envelope"></i></div>
                            <span class="small fw-medium">info@nigtas.com</span>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="info-icon-box"><i class="fa-solid fa-location-dot"></i></div>
                            <span class="small fw-medium lh-base">Nar Mahallesi 600 Cad. No:6 İç Kapı No: 1 Merkez / Niğde</span>
                        </div>
                    </div>

                    <div class="border-top pt-3 border-white-10">
                        <small class="text-white-50">Güvenli alt yapı vasıtasıyla iletelmektedir.</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 rounded-4 contact-card p-4">
                    <form action="<?= base_url('messages/save') ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label-custom">Mesaj Konusu</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-solid fa-tags"></i></span>
                                <select name="topic" class="form-select form-control-custom" id="message_topics" required>
                                    <option value="" selected disabled hidden>Lütfen Mesaj İçeriği Seçiniz</option>
                                    <?php foreach($message_topics as $rs){ ?>
                                        <option value="<?=$rs->Id?>"><?=$rs->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Mesaj Başlığı</label>
                            <div class="input-group">
                                <span class="input-group-custom-text d-flex align-items-center"><i class="fa-solid fa-heading"></i></span>
                                <input type="text" name="title" class="form-control form-control-custom" placeholder="Lütfen Mesaj Başlığı Giriniz" required>
                                <input type="text" name="code" value="<?=$this->session->oturum_data['code']?>" hidden>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">Mesajınız</label>
                            <textarea name="description" class="form-control form-control-custom" rows="5" placeholder="Lütfen iletmek istediğiniz detaylı mesajı bu alana yazınız..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-submit-custom pirulen">
                                <i class="fa-solid fa-paper-plane me-2"></i> MESAJI GÖNDER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    $('#profileImageInput').change(function() {
        const file = this.files[0];
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            } else {
                alert('Lütfen geçerli bir resim dosyası seçiniz.');
                $(this).val('');
            }
        }
    });

    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);
});
</script>

<?php $this->load->view('_footer'); ?>