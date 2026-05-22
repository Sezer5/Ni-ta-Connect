<?php 
    $bakiye = $risk_verisi['BAKIYE'] ?? 0;
    $risk_limiti = $risk_verisi['RISK'] ?? 0;
    $kalan_limit = ($risk_limiti > $bakiye) ? ($risk_limiti - $bakiye) : 0;
    $oran = ($risk_limiti > 0) ? round(($bakiye / $risk_limiti) * 100) : 0;
?>

<div class="row mt-4" onclick="window.location.href='<?= base_url('Risk') ?>';" style="cursor: pointer;">
    <!-- Grafik Alanı -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="pirulen mb-4" style="font-size: 10px; color: #666;">BAKİYE & RİSK KARŞILAŞTIRMASI</h6>
            <div class="position-relative" style="height: 300px;">
                <canvas id="mainRiskChart"></canvas>
                <div class="position-absolute top-50 start-50 translate-middle text-center">
                    <h3 class="fw-bold mb-0">%<?= $oran ?></h3>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-4 mt-3">
                <small class="text-muted"><i class="fas fa-circle text-primary me-1"></i> MEVCUT BAKİYE</small>
                <small class="text-muted"><i class="fas fa-circle text-light me-1" style="color: #e9ecef !important;"></i> KALAN KULLANILABİLİR LİMİT</small>
            </div>
        </div>
    </div>

    <!-- Firma Detayları -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="pirulen mb-4" style="font-size: 10px; color: #666;">FİRMA DETAYLARI</h6>
            
            <div class="mb-3">
                <label class="text-muted small d-block">Ünvan</label>
                <span class="fw-bold"><?= $risk_verisi['DEFINITION_'] ?? '-' ?></span>
            </div>

            <div class="mb-3">
                <label class="text-muted small d-block">E-Posta</label>
                <span class="text-primary small"><i class="fa-regular fa-envelope me-1"></i> <?= $risk_verisi['CARI_EMAIL'] ?? '-' ?></span>
            </div>

            <div class="mb-3">
                <label class="text-muted small d-block">Telefon</label>
                <span class="small"><i class="fa-solid fa-phone me-1"></i> <?= $risk_verisi['CARI_TEL'] ?? '-' ?></span>
            </div>

            <div class="mb-3">
                <label class="text-muted small d-block">Adres</label>
                <span class="small text-muted">
                    <i class="fa-solid fa-location-dot me-1"></i> 
                    <?= $risk_verisi['CARI_ADRES1'] ?? '' ?> <?= $risk_verisi['CARI_ADRES2'] ?? '' ?>
                    <br><strong><?= $risk_verisi['CARI_SEHIR'] ?? '' ?> / <?= $risk_verisi['CARI_ULKE'] ?? '' ?></strong>
                </span>
            </div>

            <div class="mt-auto text-end">
                <span class="badge bg-light text-muted border py-2" style="font-size: 8px; font-family: Pirulen;">SEKTÖR: <?= $risk_verisi['CARI_SEKTOR'] ?? '-' ?></span>
            </div>
        </div>
    </div>
</div>