<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    /* Kurumsal Font ve Renk Uyumu */
    .pirulen { font-family: 'Pirulen', sans-serif; letter-spacing: 0.5px; }
    
    /* Excel Buton Özelleştirme */
    .btn-excel { 
        background: linear-gradient(135deg, #1d6f42 0%, #145532 100%) !important; 
        color: white !important; 
        border: none !important; 
        border-radius: 10px !important; 
        padding: 8px 18px !important; 
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(29, 111, 66, 0.15);
    }
    .btn-excel:hover { 
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(29, 111, 66, 0.25);
    }
    
    /* Tablo ve Stil Düzenlemeleri */
    .main-content { padding: 20px; }
    #messagesTable thead th { 
        background-color: #f8fafc; 
        color: #334155; 
        font-size: 11px; 
        font-weight: 700;
        text-transform: uppercase;
        vertical-align: middle;
        border-bottom: 2px solid #e2e8f0;
    }

    /* İncele Buton Stili */
    .btn-examine {
        background-color: #f1f5f9;
        color: #1a237e;
        border: 1px solid #e2e8f0;
        font-size: 11px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-examine:hover {
        background-color: #1a237e;
        color: #ffffff;
        border-color: #1a237e;
    }
</style>

<div class="main-content">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="d-flex align-items-center gap-3">
                <h2 class="fw-bold mb-0 pirulen" style="color: var(--nigtas-blue); font-size: 1.4rem;">GELEN MESAJLAR</h2>
            </div>
            <div id="button-placeholder"></div> 
        </div>
        <hr class="mt-3 mb-4" style="opacity: 0.1;">

        <div class="table-responsive">
            <table id="messagesTable" class="table table-hover table-bordered w-100 m-0">
                <thead>
                    <tr>
                        <th>TARİH</th>
                        <th>KULLANICI</th>
                        <th>KONU KATEGORİSİ</th>
                        <th>MESAJ BAŞLIĞI</th>
                        <th>İLGİLENEN ADMİN</th>
                        <th>OKUNMA DURUMU</th>
                        <th>DURUM</th> <th style="width: 80px;" class="text-center">İŞLEM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($messages)): ?>
                        <?php foreach($messages as $rs): ?>
                            <tr>
                                <td data-sort="<?= strtotime($rs->created_at) ?>">
                                    <?= date('d.m.Y H:i', strtotime($rs->created_at)) ?>
                                </td>
                                
                                <td class="fw-medium text-dark">
                                    <?= $rs->user_name ?> <small class="text-muted d-block" style="font-size:11px;">Kod: <?= $rs->code ?></small>
                                </td>
                                
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(26, 35, 126, 0.1); color: #1a237e; font-size: 11px;">
                                        <?= $rs->topic_name ?>
                                    </span>
                                </td>
                                
                                <td class="fw-semibold text-secondary"><?= $rs->title ?></td>
                                
                                <td>
                                    <?= !empty($rs->admin_name) ? '<span class="text-success fw-bold"><i class="fa-solid fa-user-shield me-1"></i> '.$rs->admin_name.'</span>' : '<span class="text-muted italic">Atanmadı</span>'; ?>
                                </td>

                                <td>
                                    <?php if($rs->is_read == 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 11px;">Okundu</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 11px;">Okunmadı</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if(isset($rs->status) && $rs->status == 1): ?>
                                        <span class="badge bg-success text-white border-0 px-2 py-1 fw-bold" style="font-size: 11px; min-width: 65px; text-center;">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary text-white border-0 px-2 py-1 fw-bold" style="font-size: 11px; min-width: 65px; text-center;">Pasif</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center vertical-middle">
                                    <a href="<?= base_url('admin/messages/detail/'.$rs->Id) ?>" class="btn btn-examine pirulen">
                                        <i class="fa-solid fa-eye me-1"></i> İNCELE
                                    </a>
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
<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#messagesTable')) {
        $('#messagesTable').DataTable().destroy();
    }

    var table = $('#messagesTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Turkish.json"
        },
        "pageLength": 10,
        "order": [[0, "desc"]], 
        "responsive": true,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Sütun eklendiği için İncele butonu indeksi 7 oldu. Sıralama kapatıldı.
        ],
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel me-2"></i> EXCEL LİSTESİ AL',
                className: 'btn-excel',
                title: 'Nigtas_Gelen_Mesaj_Raporu_<?= date("d_m_Y") ?>',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6] // Excel çıktısına durum alanı dahil edildi, buton hariç tutuldu.
                }
            }
        ]
    });

    // Excel butonunu placeholder alanına taşıyoruz
    table.buttons().container().appendTo('#button-placeholder');
});
</script>

<?php $this->load->view('admin/_footer'); ?>