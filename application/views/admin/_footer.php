<!-- jQuery (Zaten mevcut) -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTables Temel JS (Zaten mevcut) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- EXCEL İÇİN GEREKLİ EK KÜTÜPHANELER (Eklendi) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    // Partial View kullanıldığı için eğer tablo daha önce initialize edildiyse temizliyoruz
    if ($.fn.DataTable.isDataTable('#irsaliyeTable')) {
        $('#irsaliyeTable').DataTable().destroy();
    }

    $('#irsaliyeTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Turkish.json"
        },
        "pageLength": 10,
        "order": [[0, "desc"]],
        "responsive": true,
        /**
         * DOM ayarı: 
         * B: Buttons (Excel butonu için kritik)
         * l: Length (Sayfa başı kayıt)
         * f: Filter (Arama)
         */
        "dom": '<"d-flex justify-content-between align-items-center mb-3"lBf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel me-2"></i> EXCEL İNDİR',
                className: 'btn btn-success btn-sm rounded-3 shadow-sm ms-2',
                title: 'Nigtas_Ekstre_Dokumu',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });
});
</script>

<style>
    /* Mevcut stilleriniz */
    .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
        background-color: var(--nigtas-blue) !important;
        border-color: var(--nigtas-blue) !important;
    }
    .dataTables_filter input {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 5px 10px;
    }
    .dataTables_length select {
        border-radius: 8px;
    }
    /* Excel butonu için ekstra stil */
    .dt-buttons.btn-group {
        flex-wrap: nowrap;
    }
    .btn-success {
        background-color: #1d6f42 !important;
        border: none !important;
        font-family: inherit;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>