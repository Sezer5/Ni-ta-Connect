<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    .risk-card {
        border-radius: 15px;
        transition: transform 0.3s;
        border: none;
        min-height: 140px;
    }

    .risk-card:hover {
        transform: translateY(-5px);
    }

    .pirulen {
        font-family: 'Pirulen', sans-serif;
        letter-spacing: 1px;
    }

    .money-val {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
    }

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }

    /* Tab Tasarımı */
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        background: #f8f9fa;
        transition: all 0.3s;
        margin-right: 10px;
    }

    .nav-tabs .nav-link.active {
        background: #0d6efd !important;
        color: #fff !important;
    }
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

        <ul class="nav nav-tabs mb-4 border-0" id="riskTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4" data-bs-toggle="tab" data-bs-target="#ozet-pane" type="button">Genel Özet</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4" data-bs-toggle="tab" data-bs-target="#fatura-pane" type="button">Açık Faturalar</button>
            </li>
        </ul>

        <div class="tab-content" id="riskTabsContent">

            <div class="tab-pane fade show active" id="ozet-pane" role="tabpanel">
                <div class="row mb-4 g-3">
                    <div class="col-md-4">
                        <div class="card risk-card shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-primary-light p-2 rounded-3 me-3"><i class="fa-solid fa-wallet text-primary fs-4"></i></div>
                                <small class="text-muted pirulen" style="font-size: 9px;">GÜNCEL BAKİYE</small>
                            </div>
                            <h2 class="money-val mb-0 text-dark"><?= number_format($risk_verisi['BAKIYE'] ?? 0, 2, ',', '.') ?> <span class="fs-6 fw-normal">TL</span></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card risk-card shadow-sm p-4 bg-white border-start border-success border-5">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-success-light p-2 rounded-3 me-3"><i class="fa-solid fa-clock text-success fs-4"></i></div>
                                <small class="text-muted pirulen" style="font-size: 9px;">TANIMLI VADE</small>
                            </div>
                            <h2 class="money-val mb-0 text-success"><?= is_numeric($vade_verisi['TANIMLI_VADE'] ?? 0) ? number_format($vade_verisi['TANIMLI_VADE'] ?? 0, 0) : ($vade_verisi['TANIMLI_VADE'] ?? 0) ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card risk-card shadow-sm p-4 bg-white border-start border-primary border-5">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-primary-light p-2 rounded-3 me-3"><i class="fa-solid fa-clock text-primary fs-4"></i></div>
                                <small class="text-muted pirulen" style="font-size: 9px;">GERÇEKLEŞEN VADE</small>
                            </div>
                            <h2 class="money-val mb-0 text-primary"><?= is_numeric($vade_verisi['GERCEKLESEN_VADE'] ?? 0) ? number_format($vade_verisi['GERCEKLESEN_VADE'] ?? 0, 0) : ($vade_verisi['GERCEKLESEN_VADE'] ?? 0) ?> <span class="fs-6">GÜN</span></h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                            <h6 class="pirulen mb-4" style="font-size: 11px; color: #555;">BAKİYE & KALAN LİMİT DAĞILIMI</h6>
                            <div class="chart-container" style="height: 300px;"><canvas id="riskDonutChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 h-100">
                            <h6 class="pirulen mb-4" style="font-size: 11px; color: #555;">FİRMA DETAYLARI</h6>
                            <div class="detail-item mb-4"><label class="text-muted small d-block">Cari Ünvan</label><span class="fw-bold"><?= $risk_verisi['DEFINITION_'] ?? '-' ?></span></div>
                            <div class="detail-item mb-4"><label class="text-muted small d-block">E-Posta</label><span><?= $risk_verisi['CARI_EMAIL'] ?? '-' ?></span></div>
                            <div class="detail-item"><label class="text-muted small d-block">Adres</label>
                                <p class="small"><?= $risk_verisi['CARI_ADRES1'] ?? '' ?> <?= $risk_verisi['CARI_SEHIR'] ?? '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="fatura-pane" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="pirulen mb-4" style="font-size: 11px; color: #555;">AÇIK FATURA LİSTESİ</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-muted" style="font-size: 10px;">
                                <tr>
                                    <th>FATURA NO</th>
                                    <th>TARİH</th>
                                    <th>SON ÖDEME</th>
                                    <th class="text-end">TOPLAM</th>
                                    <th class="text-end">KALAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($acik_faturalar)): foreach ($acik_faturalar as $f): ?>
                                        <tr style="font-size: 13px;">
                                            <td class="fw-bold"><?= $f['FATURA_NO'] ?></td>
                                            <td><?= date('d.m.Y', strtotime($f['FATURA_TARIHI'])) ?></td>
                                            <td class="text-danger fw-bold"><?= date('d.m.Y', strtotime($f['SON_ODEME_TARIHI'])) ?></td>
                                            <td class="text-end"><?= number_format($f['FATURA_TOPLAM'], 2, ',', '.') ?> ₺</td>
                                            <td class="text-end fw-bold"><?= number_format($f['KALAN'], 2, ',', '.') ?> ₺</td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Açık fatura bulunamadı.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Mevcut Bakiye', 'Kalan Limit'],
                datasets: [{
                    data: [<?= (float)($risk_verisi['BAKIYE'] ?? 0) ?>, <?= (float)($kalan_limit_api ?? 0) ?>],
                    backgroundColor: ['#0d6efd', '#2ecc71'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>

<?php $this->load->view('_footer'); ?>