<?php $this->load->view('admin/_header'); ?>
<?php $this->load->view('admin/_sidebar'); ?>
<?php $this->load->view('admin/_topbar'); ?>

<style>
    .pirulen { font-family: 'Pirulen', sans-serif; }
    /* Profil resmi önizleme alanı için şık stiller */
    .addrole-preview-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin-bottom: 15px;
    }
    .addrole-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="pirulen mb-4" style="color: #1a237e; font-size: 1.2rem;">ROLLER</h2>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab" aria-controls="roles" aria-selected="true">Roller</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="addrole-tab" data-bs-toggle="tab" data-bs-target="#addrole" type="button" role="tab" aria-controls="addrole" aria-selected="false">Rol Ekle</button>
                        </li>
                    </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                                <div
                                    class="table-responsive p-3"
                                >
                                    <table
                                        class="table table-striped table-bordered"
                                    >
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Adı</th>
                                                <th scope="col">Açıklama</th>
                                                <th scope="col">Sil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($roles as $role){?>
                                            <tr>
                                                <td><?=$role->Id?></td>
                                                <td><?=$role->name?></td>
                                                <td><?=$role->description?></td>
                                                <td>
                                                    <a href="<?=base_url()?>admin/roles/role_delete/<?=$role->Id?>">
                                                        <button class="btn btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="addrole" role="tabpanel" aria-labelledby="addrole-tab">
                                <div class="p-3">
                                    <table class="table table-bordered">
                                        <form action="<?=base_url()?>admin/roles/role_add" method="post">
                                            <tr>
                                                <td>Rol Adı:</td>
                                                <td>
                                                    <input type="text" class="form-control" name="name">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rol Açıklaması:</td>
                                                <td>
                                                    <textarea class="form-control" name="description"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ekle:</td>
                                                <td>
                                                    <button class="btn btn-success float-right">
                                                        <i class="fa fa-plus"></i> EKLE
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
                   
                                    </table>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('_footer'); ?>