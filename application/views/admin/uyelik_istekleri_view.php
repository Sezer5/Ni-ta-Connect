<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>
<div class="main-content p-4">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i>Üyelik Başvuru Listesi</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle" id="requestTable">
                <thead class="table-light">
                    <tr>
                        <th>BAŞVURU TARİHİ</th>
                        <th>DURUM</th> <th>FİRMA / ÜYE ADI</th>
                        <th>YETKİLİ KİŞİ</th>
                        <th>VERGİ / TC NO</th>
                        <th>TELEFON</th>
                        <th class="text-center">ONAY DURUMU</th>
                        <th class="text-end">İŞLEM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($istekler)): foreach($istekler as $istek): ?>
                        <tr class="<?= $istek['is_read'] == 0 ? 'table-warning' : '' ?>">
                            <td><?= date('d.m.Y H:i', strtotime($istek['created_at'])) ?></td>
                            
                            <td>
                                <?php if($istek['is_read'] == 1): ?>
                                    <span class="text-muted small"><i class="fa-solid fa-envelope-open me-1"></i> Okundu</span>
                                <?php else: ?>
                                    <span class="text-primary fw-bold small"><i class="fa-solid fa-envelope me-1"></i> Yeni İstek</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $istek['name'] ?></td>
                            <td><?= $istek['person'] ?></td>
                            <td><code class="text-dark"><?= $istek['taxnumber'] ?></code></td>
                            <td><?= $istek['tel'] ?></td>
                            
                            <td class="text-center">
                                <?php if($istek['status'] == 1): ?>
                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill">Beklemede</span>
                                <?php elseif($istek['status'] == 2): ?>
                                    <span class="badge bg-success px-3 py-1.5 rounded-pill">Admin Ataması Yapıldı</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-3 py-1.5 rounded-pill">Pasif</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-end">
                                <a href="<?= base_url('admin/AccountRequest/uyelik_detay/'.$istek['Id']) ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                    <i class="fa-regular fa-eye me-1"></i> İncele
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#requestTable').DataTable({
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Turkish.json" },
            "order": [[0, "desc"]]
        });
    });
</script>
<?php $this->load->view('admin/_footer'); ?>