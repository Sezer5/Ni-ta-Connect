<?php $this->load->view('_header'); ?>
<?php $this->load->view('_sidebar'); ?>
<?php $this->load->view('_topbar'); ?>

<style>
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 600;
        border-radius: 6px;
        font-size: 11px;
    }

    .bg-kahverengi {
        background-color: #8B4513;
        color: white;
    }

    .bg-kirmizi {
        background-color: #dc3545;
        color: white;
    }

    .bg-mavi {
        background-color: #0d6efd;
        color: white;
    }

    .bg-mor {
        background-color: #6f42c1;
        color: white;
    }

    .bg-oneri {
        background-color: #6c757d;
        color: white;
    }

    .bg-pembe {
        background-color: #d63384;
        color: white;
    }

    .bg-sari {
        background-color: #ffc107;
        color: #000;
    }

    .bg-turkuaz {
        background-color: #0dcaf0;
        color: #000;
    }

    .bg-yesil {
        background-color: #198754;
        color: white;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h2 class="fw-bold mb-4" style="color: #1a237e; font-family: 'Pirulen', sans-serif;">SİPARİŞLER</h2>

            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="fw-bold text-muted small mb-1">SİPARİŞ DURUMU FİLTRELE:</label>
                    <select id="durumFiltre" class="form-select border-primary shadow-sm">
                        <option value="">TÜMÜNÜ GÖSTER</option>
                        <option value="ONAYLI SEVK EDİLMİŞ">ONAYLI SEVK EDİLMİŞ</option>
                        <option value="DURDURULDU">DURDURULDU</option>
                        <option value="REVİZE">REVİZE</option>
                        <option value="SEVKİYATA HAZIR">SEVKİYATA HAZIR</option>
                        <option value="ÖNERİ">ÖNERİ</option>
                        <option value="ARAÇ YÜKLENİYOR">ARAÇ YÜKLENİYOR</option>
                        <option value="ONAYLI SEVK EDİLMEMİŞ">ONAYLI SEVK EDİLMEMİŞ</option>
                        <option value="RED">RED</option>
                        <option value="ÜRETİMİ PLANLANDI">ÜRETİMİ PLANLANDI</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table id="siparisTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Tarih</th>
                            <th>Sipariş No</th>
                            <th>Durum</th>
                            <th>Mamul</th>
                            <th>Tonaj</th>
                            <th>Toplam</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            }
        });

        var table = $('#siparisTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('Siparisler/get_siparisler_ajax') ?>",
                "type": "POST",
                "data": function(d) {
                    // Sütun 2'nin arama değerine bizim select kutusunun değerini ata
                    d.columns[2].search.value = $('#durumFiltre').val();
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
            },
            "columns": [{
                    "data": "Tarih",
                    "render": (data) => data ? new Date(data).toLocaleDateString('tr-TR') : ''
                },
                {
                    "data": "SIPARIS_NO"
                },
                {
                    "data": "SIPARIS_DURUM",
                    "render": function(data) {
                        if (!data) return '';
                        let colorClass = 'bg-secondary';
                        if (data.includes('ONAYLI SEVK EDİLMİŞ')) colorClass = 'bg-yesil';
                        else if (data.includes('DURDURULDU')) colorClass = 'bg-turkuaz';
                        else if (data.includes('REVİZE')) colorClass = 'bg-sari';
                        else if (data.includes('SEVKİYATA HAZIR')) colorClass = 'bg-pembe';
                        else if (data.includes('ÖNERİ')) colorClass = 'bg-oneri';
                        else if (data.includes('ARAÇ YÜKLENİYOR')) colorClass = 'bg-mor';
                        else if (data.includes('ONAYLI SEVK EDİLMEMİŞ')) colorClass = 'bg-mavi';
                        else if (data.includes('RED')) colorClass = 'bg-kirmizi';
                        else if (data.includes('ÜRETİMİ PLANLANDI')) colorClass = 'bg-kahverengi';
                        return `<span class="badge ${colorClass}">${data}</span>`;
                    }
                },
                {
                    "data": "MAMUL"
                },
                {
                    "data": "TONAJ",
                    "render": (data) => parseFloat(data || 0).toLocaleString('tr-TR', {
                        minimumFractionDigits: 2
                    })
                },
                {
                    "data": "TOPLAM",
                    "render": (data) => parseFloat(data || 0).toLocaleString('tr-TR', {
                        minimumFractionDigits: 2
                    }) + ' ₺'
                }
            ],
            "order": [
                [0, "desc"]
            ]
        });

        // Durum değişince tabloyu güncelle
        $('#durumFiltre').on('change', function() {
            table.ajax.reload();
        });
    });
</script>

<?php $this->load->view('_footer'); ?>