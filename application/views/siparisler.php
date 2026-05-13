<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>
<div class="main-content">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h2 class="fw-bold mb-1" style="color: var(--nigtas-blue);font-family:Pirulen">AÇIK SİPARİŞLER</h2>
        <hr>
        <div class="table-responsive"> <!-- Mobilde taşmaması için eklendi -->
            <table id="irsaliyeTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Sipariş No</th>
                        <th>Mamul</th>
                        <th>Vade</th>
                        <th>Tonaj</th>
                        <th>Ton / Fiyat</th>
                        <th>Toplam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($siparis_verileri)): ?>
                        <?php foreach($siparis_verileri as $satir): ?>
                            <tr>
                                <td><?= date('d.m.Y', strtotime($satir['Tarih'])) ?></td>
                                <td><?= $satir['SIPARIS_NO'] ?></td>
                                <td><?= $satir['MAMUL'] ?></td>
                                <td><?= $satir['VADE'] ?></td>
                                <td><?= $satir['TONAJ'] ?></td>
                                <td><?= number_format($satir['TON_FIYAT'], 2, ',', '.') ?> ₺</td>
                                <td><?= number_format($satir['TOPLAM'], 2, ',', '.') ?> ₺</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('_footer'); ?>