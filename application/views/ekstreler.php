<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    /* Kurumsal Font ve Renk Uyumu */
    .pirulen { font-family: 'Pirulen', sans-serif; }
    
    /* Excel Buton Özelleştirme */
    .btn-excel { 
        background-color: #1d6f42 !important; 
        color: white !important; 
        border: none !important; 
        border-radius: 10px !important; 
        padding: 6px 15px !important; 
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-excel:hover { 
        background-color: #145532 !important; 
        transform: translateY(-1px);
    }
    
    /* Tablo Stil Düzenlemeleri */
    .main-content { padding: 20px; }
    #irsaliyeTable thead th { 
        background-color: #fcfcfc; 
        color: #444; 
        font-size: 12px; 
        vertical-align: middle;
    }
    .text-end { text-align: right !important; }
</style>

<div class="main-content">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <!-- Başlık ve Buton Alanı -->
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h2 class="fw-bold mb-0 pirulen" style="color: var(--nigtas-blue); font-size: 1.5rem;">EKSTRELER</h2>
            <div id="button-placeholder"></div> <!-- Excel Butonu Buraya Gelecek -->
        </div>
        <hr>

        <div class="table-responsive">
            <table id="irsaliyeTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>TARİH</th>
                        <th>FİŞ NO</th>
                        <th class="text-end">TUTAR</th>
                        <th class="text-end">BORÇ</th>
                        <th class="text-end">ALACAK</th>
                        <th class="text-end">BAKİYE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($ekstre_verileri)): ?>
                        <?php foreach($ekstre_verileri as $satir): ?>
                            <tr>
                                <!-- Tarih sıralaması için data-sort ekledik -->
                                <td data-sort="<?= strtotime($satir['Tarih']) ?>">
                                    <?= date('d.m.Y', strtotime($satir['Tarih'])) ?>
                                </td>
                                <td><?= $satir['FisNumarası'] ?></td>
                                <td class="text-end">
                                    <?= number_format($satir['Tutar'], 2, ',', '.') ?> <?= $satir['ParaBirimi'] ?>
                                </td>
                                <td class="text-end text-danger">
                                    <?= number_format($satir['BORÇ'], 2, ',', '.') ?> <?= $satir['ParaBirimi'] ?>
                                </td>
                                <td class="text-end text-success">
                                    <?= number_format($satir['ALACAK'], 2, ',', '.') ?> <?= $satir['ParaBirimi'] ?>
                                </td>
                                <td class="text-end fw-bold">
                                    <?= number_format($satir['BAKİYE'], 2, ',', '.') ?> <?= $satir['ParaBirimi'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript kısmı: Butonu üst kısma taşımak için script -->
<script>
$(document).ready(function() {
    // footer.php'deki tanımı ezmek ve butonları aktifleştirmek için
    if ($.fn.DataTable.isDataTable('#irsaliyeTable')) {
        $('#irsaliyeTable').DataTable().destroy();
    }

    var table = $('#irsaliyeTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Turkish.json"
        },
        "pageLength": 10,
        "order": [[0, "desc"]],
        "responsive": true,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel me-1"></i> EXCEL OLARAK İNDİR',
                className: 'btn-excel',
                title: 'Nigtas_Ekstre_Dokumu_<?= date("d_m_Y") ?>',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    // Butonu tasarımın üstündeki özel alana yerleştiriyoruz
    table.buttons().container().appendTo('#button-placeholder');
});
</script>

<?php $this->load->view('_footer'); ?>