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
        padding: 8px 16px !important; 
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-excel:hover { 
        background-color: #145532 !important; 
        transform: translateY(-1px);
    }
    
    /* Zaman Filtreleme Buton Tasarımları */
    .filter-date-btn {
        font-size: 11px !important; 
        border-radius: 7px !important;
        font-weight: 700 !important;
        transition: all 0.2s ease;
    }
    
    /* Tablo Stil Düzenlemeleri */
    .main-content { padding: 20px; }
    #cariEkstreTable thead th { 
        background-color: #fcfcfc; 
        color: #444; 
        font-size: 12px; 
        vertical-align: middle;
    }
    .text-end { text-align: right !important; }
</style>

<div class="main-content">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-0 pirulen" style="color: var(--nigtas-blue); font-size: 1.5rem;">CARİ DURUM</h2>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="btn-group border rounded-3 p-1 bg-light shadow-sm" role="group" aria-label="Tarih Filtresi" style="border-radius: 10px !important;">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 px-3 filter-date-btn" data-range="1-month">1 AY</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 px-3 filter-date-btn" data-range="3-months">3 AY</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 px-3 filter-date-btn" data-range="6-months">6 AY</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 px-3 filter-date-btn" data-range="this-year">BU YIL</button>
                    <button type="button" class="btn btn-sm btn-primary border-0 px-3 filter-date-btn active" data-range="all" style="background-color: var(--nigtas-blue);">TÜMÜ</button>
                </div>
                
                <div id="button-placeholder"></div>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table id="cariEkstreTable" class="table table-striped table-bordered w-100">
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        if ($.fn.DataTable.isDataTable('#cariEkstreTable')) {
            $('#cariEkstreTable').DataTable().destroy();
        }

        var table = $('#cariEkstreTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Turkish.json"
            },
            "pageLength": 10,
            "order": [[0, "desc"]],
            "responsive": true,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"Blf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-file-excel me-1"></i> EXCEL OLARAK İNDİR',
                    className: 'btn-excel',
                    title: 'Nigtas_Cari_Ekstre_Dokumu',
                    // 🎯 DÜZELTME: Sayfalama (Pagination) sınırına takılmadan arka plandaki tüm filtrelenmiş veriyi çekmesini sağlıyoruz
                    exportOptions: {
                        columns: ':visible',
                        rows: { filter: 'applied' }, // Sadece aktif sayfayı değil, filtrenin uygulandığı tüm sayfaları dahil et
                        modifier: {
                            page: 'all' // İlk sayfa sınırını kaldır, tüm sayfaları tara
                        }
                    }
                }
            ]
        });

        table.buttons().container().appendTo('#button-placeholder');

        var activeRange = 'all';

        // Tarih Filtreleme Motoru
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if (settings.nTable.id !== 'cariEkstreTable') return true;
                if (activeRange === 'all') return true;

                var cellElement = settings.aoData[dataIndex].anCells[0];
                var rowTimestamp = parseFloat($(cellElement).attr('data-sort')) * 1000;
                
                if (isNaN(rowTimestamp)) return true;

                var rowDate = new Date(rowTimestamp);
                var today = new Date();
                var targetDate = new Date();

                today.setHours(0,0,0,0);
                rowDate.setHours(0,0,0,0);

                if (activeRange === '1-month') {
                    targetDate.setMonth(today.getMonth() - 1);
                    return rowDate >= targetDate;
                }
                else if (activeRange === '3-months') {
                    targetDate.setMonth(today.getMonth() - 3);
                    return rowDate >= targetDate;
                } 
                else if (activeRange === '6-months') {
                    targetDate.setMonth(today.getMonth() - 6);
                    return rowDate >= targetDate;
                } 
                else if (activeRange === 'this-year') {
                    var firstDayOfYear = new Date(today.getFullYear(), 0, 1);
                    return rowDate >= firstDayOfYear;
                }

                return true;
            }
        );

        // Filtre Butonları Tıklama Olayları
        $('.filter-date-btn').on('click', function() {
            $('.filter-date-btn').removeClass('active btn-primary').addClass('btn-outline-secondary').css('background-color', 'transparent');
            $(this).addClass('active btn-primary').removeClass('btn-outline-secondary');
            
            if($(this).data('range') === 'all') {
                $(this).css('background-color', 'var(--nigtas-blue)');
            } else {
                $(this).css('background-color', '#6c757d');
            }

            activeRange = $(this).data('range');
            table.draw();
        });

    })(jQuery);
});
</script>

<?php $this->load->view('_footer'); ?>