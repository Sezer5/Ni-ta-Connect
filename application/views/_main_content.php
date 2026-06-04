<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<?php $this->load->view('dashboard/_styles'); ?>

<div class="main-content">
    <?php $this->load->view('dashboard/_welcome_card'); ?>
    
    <!-- Sayaç Satırı: İrsaliye + Sipariş + Finansal Özet -->
    <div class="row g-4 mb-4">
        <?php $this->load->view('dashboard/acik_irsaliye_istatistik'); ?>
        <?php $this->load->view('dashboard/acik_siparis_istatistik'); ?>
        <?php 
    $this->load->view('dashboard/finansal_ozet_istatistik', [
        'tanimli_vade'     => $tanimli_vade ?? 0,
        'gerceklesen_vade' => $gerceklesen_vade ?? 0
    ]); 
?>
    </div>

    <!-- Grafik ve Firma Detayları -->
    <?php $this->load->view('dashboard/risk_ozet_istatistik'); ?>
</div>

<?php $this->load->view('dashboard/_scripts'); ?>



<?php $this->load->view('_footer'); ?>