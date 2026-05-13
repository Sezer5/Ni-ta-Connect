<div class="col-lg-4">
    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
        <div class="card-body p-4 d-flex flex-column justify-content-center">
            <!-- Güncel Bakiye Satırı -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="pirulen mb-0 text-muted" style="font-size: 9px; letter-spacing: 0.5px;">GÜNCEL BAKİYE</h6>
                    <div class="d-flex align-items-baseline">
                        <h3 class="fw-bold mb-0 text-danger" id="header-bakiye">0</h3>
                        <span class="ms-1 fw-bold text-danger">₺</span>
                    </div>
                </div>
                <div class="bg-light-danger p-2 rounded-3">
                    <i class="fa-solid fa-wallet text-danger fs-4"></i>
                </div>
            </div>

            <hr class="my-2 opacity-25">

            <!-- Risk Limiti Satırı -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>
                    <h6 class="pirulen mb-0 text-muted" style="font-size: 9px; letter-spacing: 0.5px;">RİSK LİMİTİ</h6>
                    <div class="d-flex align-items-baseline">
                        <h4 class="fw-bold mb-0 text-dark" id="header-limit">0</h4>
                        <span class="ms-1 fw-bold text-dark">₺</span>
                    </div>
                </div>
                <div class="bg-light p-2 rounded-3">
                    <i class="fa-solid fa-shield-halved text-muted fs-4"></i>
                </div>
            </div>
            
            <!-- Alt Bilgi (Opsiyonel) -->
            <div class="mt-3">
                <div class="progress" style="height: 4px;">
                    <?php 
                        $bakiye = $risk_verisi['BAKIYE'] ?? 0;
                        $limit = $risk_verisi['RISK'] ?? 1;
                        $oran = ($bakiye / $limit) * 100;
                    ?>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $oran ?>%"></div>
                </div>
                <small class="text-muted" style="font-size: 9px;">LİMİT DOLULUK: %<?= round($oran) ?></small>
            </div>
        </div>
    </div>
</div>