<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    .risk-card { border-radius: 15px; transition: transform 0.3s; border: none; min-height: 140px; }
    .risk-card:hover { transform: translateY(-5px); }
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 1px; }
    .money-val { font-family: 'Inter', sans-serif; font-weight: 800; }
    .progress { height: 12px; border-radius: 6px; background-color: #f0f2f5; overflow: hidden; }
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
</style>

<div class="main-content">
    <div class="container-fluid">
        
        <div class="d-flex align-items-center mb-4">
            <h2 class="pirulen mb-0" style="color: #1a237e; font-size: 1.4rem;">FİNANSAL DURUM ANALİZİ</h2>
            <div class="ms-auto">
                <span class="badge bg-white text-muted shadow-sm p-2 border">
                    <i class="fa-solid fa-calendar-check me-1 text-primary"></i> <?= date('d.m.Y H:i') ?>
                </span>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <!-- 1. GÜNCEL BAKİYE (Risk API'den) -->
            <div class="col-md-4">
                <div class="card risk-card shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary-light p-2 rounded-3 me-3">
                            <i class="fa-solid fa-wallet text-primary fs-4"></i>
                        </div>
                        <small class="text-muted pirulen" style="font-size: 9px;">GÜNCEL BAKİYE</small>
                    </div>
                    <h2 class="money-val mb-0 text-dark">
                        <?= number_format($risk_verisi['BAKIYE'] ?? 0, 2, ',', '.') ?> 
                        <span class="fs-6 fw-normal">TL</span>
                    </h2>
                </div>
            </div>
            
            <!-- 2. TANIMLI VADE -->
            <div class="col-md-4">
                <div class="card risk-card shadow-sm p-4 bg-white border-start border-success border-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-light p-2 rounded-3 me-3">
                            <i class="fa-solid fa-clock text-success fs-4"></i>
                        </div>
                        <small class="text-muted pirulen" style="font-size: 9px;">TANIMLI VADE</small>
                    </div>
                    <h2 class="money-val mb-0 text-success">
                        <?php 
                            // Güvenli kontrol: vade_verisi dizisi içinde TANIMLI_VADE anahtarı var mı?
                            $vade_goster = isset($vade_verisi['TANIMLI_VADE']) ? $vade_verisi['TANIMLI_VADE'] : 0;
                        ?>
                        <?= is_numeric($vade_goster) ? number_format($vade_goster, 0) : $vade_goster ?>
                        
                    </h2>
                </div>
            </div>

            <!-- 3. GERÇEKLEŞEN VADE -->
                <div class="col-md-4">
                    <div class="card risk-card shadow-sm p-4 bg-white border-start border-primary border-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary-light p-2 rounded-3 me-3">
                                <i class="fa-solid fa-clock text-primary fs-4"></i>
                            </div>
                            <small class="text-muted pirulen" style="font-size: 9px;">GERÇEKLEŞEN VADE</small>
                        </div>
                        <h2 class="money-val mb-0 text-primary">
                            <?php 
                                // Güvenli kontrol: vade_verisi dizisi içinde GERCEKLESEN_VADE anahtarı var mı?
                                $vade_goster = isset($vade_verisi['GERCEKLESEN_VADE']) ? $vade_verisi['GERCEKLESEN_VADE'] : 0;
                            ?>
                            
                            <h2 class="money-val mb-0 text-primary">
                                <?= is_numeric($vade_goster) ? number_format($vade_goster, 0) : $vade_goster ?>
                                GÜN
                            </h2>
                        </h2>
                    </div>
                </div>
        </div>

        <div class="row">
            <!-- Grafik Bölümü -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="pirulen mb-4" style="font-size: 11px; color: #555;">BAKİYE & KALAN LİMİT DAĞILIMI</h6>
                    <div class="chart-container">
                        <canvas id="riskDonutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Firma Detayları -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 h-100 bg-white">
                    <h6 class="pirulen mb-4" style="font-size: 11px; color: #555;">FİRMA DETAYLARI</h6>
                    <div class="detail-item mb-4">
                        <label class="text-muted small d-block mb-1">Cari Ünvan</label>
                        <span class="fw-bold text-dark fs-6"><?= $risk_verisi['DEFINITION_'] ?? '-' ?></span>
                    </div>
                    <div class="detail-item mb-4">
                        <label class="text-muted small d-block mb-1">E-Posta</label>
                        <span class="text-dark small"><i class="fa-regular fa-envelope me-2 text-primary"></i><?= $risk_verisi['CARI_EMAIL'] ?? '-' ?></span>
                    </div>
                    <div class="detail-item">
                        <label class="text-muted small d-block mb-1">Adres</label>
                        <p class="text-dark small mb-0">
                            <i class="fa-solid fa-location-dot me-2 text-primary"></i>
                            <?= $risk_verisi['CARI_ADRES1'] ?? '' ?> <?= $risk_verisi['CARI_SEHIR'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('riskDonutChart').getContext('2d');
    
    // API'lerden gelen ham veriler
    const bakiye = <?= (float)($risk_verisi['BAKIYE'] ?? 0) ?>;
    const kalanLimit = <?= (float)($kalan_limit_api ?? 0) ?>;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Mevcut Bakiye', 'Kalan Kullanılabilir Limit'],
            datasets: [{
                data: [bakiye, kalanLimit],
                backgroundColor: ['#0d6efd', '#2ecc71'], // Bakiye Mavi, Kalan Limit Yeşil
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: 'Pirulen', size: 9 } } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.label + ': ' + context.raw.toLocaleString('tr-TR', { minimumFractionDigits: 2 }) + ' ₺';
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php $this->load->view('_footer'); ?>