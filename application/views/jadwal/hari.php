<?php //$this->load->view('templates/header', ['title' => $title]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-day mr-1"></i> Jadwal Praktek Hari <?= ucfirst($hari) ?>
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi Jadwal:</div>
                            <a class="dropdown-item" href="<?= base_url('jadwal/tambah') ?>">
                                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                Tambah Jadwal
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('jadwal') ?>">
                                <i class="fas fa-calendar-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Kembali ke Semua Jadwal
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="btn-group" role="group" aria-label="Filter Hari">
                                <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-primary">
                                    Semua
                                </a>
                                <?php foreach($this->Jadwal_model->get_hari() as $h): ?>
                                    <a href="<?= base_url('jadwal/hari/'.$h) ?>" class="btn btn-outline-primary <?= ($h == $hari) ? 'active' : '' ?>">
                                        <?= $h ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(empty($jadwal)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Tidak ada jadwal praktek untuk hari <?= $hari ?>.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="jadwalTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Dokter</th>
                                        <th>Poliklinik</th>
                                        <th>Jam Praktek</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($jadwal as $j): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <a href="<?= base_url('jadwal/dokter/'.$j->id_dokter) ?>">
                                                    <?= $j->nama_dokter ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('jadwal/poli/'.$j->id_poli) ?>">
                                                    <?= $j->nama_poli ?>
                                                </a>
                                            </td>
                                            <td><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                                            <td><?= $j->kuota_pasien ?> pasien</td>
                                            <td>
                                                <?php if($j->status == 'aktif'): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('jadwal/edit/'.$j->id_jadwal) ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $j->id_jadwal ?>" data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jadwal praktek ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="btn-delete-confirm" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#jadwalTable').DataTable();
        
        $('.btn-hapus').on('click', function() {
            var id = $(this).data('id');
            $('#btn-delete-confirm').attr('href', '<?= base_url('jadwal/hapus/') ?>' + id);
        });
    });
</script>

<?php //$this->load->view('templates/footer'); ?> 