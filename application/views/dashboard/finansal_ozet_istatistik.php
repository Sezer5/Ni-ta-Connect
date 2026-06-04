<div class="col-lg-4 mb-4"> <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" 
         onclick="window.location.href='<?= base_url('Risk') ?>';" 
         style="cursor: pointer; transition: 0.3s;">
        
        <div class="card-body p-4 d-flex flex-column">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="flex-grow-1">
                    <h6 class="pirulen mb-0 text-muted" style="font-size: 9px; letter-spacing: 0.5px;">TANIMLI VADE</h6>
                    <div class="d-flex align-items-baseline">
                        <h3 class="fw-bold mb-0 text-primary"><?= (int)($tanimli_vade ?? 0) ?></h3>
                        <span class="ms-1 fw-bold text-primary" style="font-size: 0.9rem;">GÜN</span>
                    </div>
                </div>
                <div class="bg-primary-light p-2 rounded-3">
                    <i class="fa-solid fa-calendar-check text-primary fs-4"></i>
                </div>
            </div>

            <hr class="my-2 opacity-25">

            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="flex-grow-1">
                    <h6 class="pirulen mb-0 text-muted" style="font-size: 9px; letter-spacing: 0.5px;">GERÇEKLEŞEN VADE</h6>
                    <div class="d-flex align-items-baseline">
                        <h4 class="fw-bold mb-0 text-danger"><?= (int)($gerceklesen_vade ?? 0) ?></h4>
                        <span class="ms-1 fw-bold text-danger" style="font-size: 0.9rem;">GÜN</span>
                    </div>
                </div>
                <div class="bg-danger-light p-2 rounded-3">
                    <i class="fa-solid fa-clock text-danger fs-4"></i>
                </div>
            </div>
            
            <div class="mt-auto pt-3">
                <div class="progress" style="height: 4px;">
                    <?php 
                        $t_vade = (int)($tanimli_vade ?? 1);
                        $g_vade = (int)($gerceklesen_vade ?? 0);
                        $oran = ($g_vade > $t_vade) ? 100 : (($t_vade > 0) ? ($g_vade / $t_vade) * 100 : 0);
                    ?>
                    <div class="progress-bar <?= ($g_vade > $t_vade) ? 'bg-danger' : 'bg-success' ?>" 
                         role="progressbar" 
                         style="width: <?= $oran ?>%"></div>
                </div>
                <small class="text-muted d-block mt-1" style="font-size: 9px;">
                    <?= ($g_vade > $t_vade) ? 'VADE AŞIMI!' : 'VADE DURUMU: NORMAL' ?>
                </small>
            </div>
        </div>
    </div>
</div>