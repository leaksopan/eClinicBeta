<?php //$this->load->view('templates/header', ['title' => $title]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt mr-1"></i> Jadwal Praktek Dokter
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
                            <a class="dropdown-item" href="<?= base_url('dokter') ?>">
                                <i class="fas fa-user-md fa-sm fa-fw mr-2 text-gray-400"></i>
                                Manajemen Dokter
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
                        <div class="col-md-6">
                            <a href="<?= base_url('jadwal/tambah') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Jadwal
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group float-right" role="group" aria-label="Filter Hari">
                                <a href="<?= base_url('jadwal') ?>" class="btn btn-outline-primary active">
                                    Semua
                                </a>
                                <?php foreach($hari as $h): ?>
                                    <a href="<?= base_url('jadwal/hari/'.$h) ?>" class="btn btn-outline-primary">
                                        <?= $h ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <!-- Tabel visual yang dikelompokkan (tanpa DataTables) -->
                        <table class="table table-bordered table-striped" id="jadwalVisualTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Dokter</th>
                                    <th>Poliklinik</th>
                                    <th>Hari</th>
                                    <th>Jam Praktek</th>
                                    <th width="5%">Kuota</th>
                                    <th width="8%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($grouped_jadwal)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data jadwal</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach($grouped_jadwal as $id_dokter => $grup): ?>
                                        <?php $jadwal_count = count($grup['jadwal']); ?>
                                        <?php foreach($grup['jadwal'] as $index => $j): ?>
                                            <tr class="<?= ($index === 0) ? 'border-top border-primary border-3' : '' ?>">
                                                <?php if($index === 0): ?>
                                                    <td rowspan="<?= $jadwal_count ?>" class="align-middle text-center bg-light"><?= $no++ ?></td>
                                                    <td rowspan="<?= $jadwal_count ?>" class="align-middle bg-light shadow-sm">
                                                        <div class="d-flex flex-column p-2 border-left border-primary border-3">
                                                            <a href="<?= base_url('jadwal/dokter/'.$j->id_dokter) ?>" class="font-weight-bold">
                                                                <?= $j->nama_dokter ?>
                                                            </a>
                                                            <span class="badge badge-info mt-1"><?= $j->spesialis ?></span>
                                                            <small class="text-muted mt-1"><?= $jadwal_count ?> jadwal</small>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <a href="<?= base_url('jadwal/poli/'.$j->id_poli) ?>">
                                                        <?= $j->nama_poli ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary"><?= $j->hari ?></span>
                                                </td>
                                                <td><i class="far fa-clock mr-1"></i><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                                                <td class="text-center"><?= $j->kuota_pasien ?></td>
                                                <td class="text-center">
                                                    <?php if($j->status == 'aktif'): ?>
                                                        <span class="badge badge-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('jadwal/edit/'.$j->id_jadwal) ?>" class="btn btn-sm btn-warning" title="Edit Jadwal">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $j->id_jadwal ?>" data-toggle="modal" data-target="#deleteModal" title="Hapus Jadwal">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                        <!-- Tabel tersembunyi untuk DataTables (untuk pencarian dan filter) -->
                        <table class="table table-bordered" id="jadwalTable" style="display: none;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Dokter</th>
                                    <th>Poliklinik</th>
                                    <th>Hari</th>
                                    <th>Jam Praktek</th>
                                    <th>Kuota</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($jadwal)): ?>
                                    <?php $no = 1; foreach($jadwal as $j): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $j->nama_dokter ?> (<?= $j->spesialis ?>)</td>
                                            <td><?= $j->nama_poli ?></td>
                                            <td><?= $j->hari ?></td>
                                            <td><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                                            <td><?= $j->kuota_pasien ?></td>
                                            <td><?= $j->status ?></td>
                                            <td>
                                                <a href="<?= base_url('jadwal/edit/'.$j->id_jadwal) ?>" class="btn-edit">Edit</a>
                                                <a href="#" class="btn-delete" data-id="<?= $j->id_jadwal ?>">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
        // Inisialisasi DataTables pada tabel tersembunyi (untuk pencarian)
        var dataTable = $('#jadwalTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [7] }
            ],
            "info": false,
            "paging": false,
            "dom": 'f',
            "language": {
                "search": "Cari Jadwal:",
                "zeroRecords": "Tidak ada jadwal yang ditemukan"
            }
        });
        
        // Sinkronkan pencarian DataTable ke tabel visual
        $('#jadwalTable_filter input').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            
            // Reset tampilan - tampilkan semua baris terlebih dahulu
            $('#jadwalVisualTable tbody tr').show();
            
            if (searchText.length > 0) {
                // Kumpulkan ID dokter yang tidak cocok dengan pencarian
                var hiddenDoctorIds = [];
                var processedDoctorIds = {}; // Track dokter yang sudah diproses
                
                // Periksa apakah setiap grup dokter memiliki data yang cocok dengan pencarian
                $('#jadwalVisualTable tbody tr.border-top').each(function() {
                    var dokterElement = $(this).find('a[href*="dokter/"]');
                    if (dokterElement.length > 0) {
                        var dokterHref = dokterElement.attr('href');
                        var dokterID = dokterHref.split('/').pop();
                        
                        // Skip jika dokter sudah diproses
                        if (processedDoctorIds[dokterID]) {
                            return true; // lanjutkan ke iterasi berikutnya
                        }
                        
                        processedDoctorIds[dokterID] = true; // Tandai dokter ini sudah diproses
                        
                        // Dapatkan semua baris dalam grup yang sama
                        var rows = [];
                        var startRow = $(this).index();
                        var rowCount = parseInt($(this).find('td:first').attr('rowspan') || 1);
                        
                        for (var i = 0; i < rowCount; i++) {
                            var row = $('#jadwalVisualTable tbody tr').eq(startRow + i);
                            if (row.length) {
                                rows.push(row);
                            }
                        }
                        
                        // Periksa apakah ada baris dalam grup yang cocok
                        var groupHasMatch = false;
                        $.each(rows, function(i, row) {
                            if (row.text().toLowerCase().indexOf(searchText) > -1) {
                                groupHasMatch = true;
                                return false; // keluar dari loop
                            }
                        });
                        
                        // Jika tidak ada yang cocok, tambahkan ID dokter ke daftar yang disembunyikan
                        if (!groupHasMatch) {
                            hiddenDoctorIds.push(dokterID);
                        }
                    }
                });
                
                // Sembunyikan grup yang tidak cocok
                for (var i = 0; i < hiddenDoctorIds.length; i++) {
                    $('#jadwalVisualTable tbody tr').each(function() {
                        var row = $(this);
                        var isDoctorRow = row.hasClass('border-top');
                        
                        if (isDoctorRow) {
                            var dokterElement = row.find('a[href*="dokter/"]');
                            if (dokterElement.length > 0) {
                                var dokterHref = dokterElement.attr('href');
                                var thisID = dokterHref.split('/').pop();
                                
                                if (thisID === hiddenDoctorIds[i]) {
                                    var rowCount = parseInt(row.find('td:first').attr('rowspan') || 1);
                                    var startRow = row.index();
                                    
                                    // Sembunyikan baris dokter
                                    row.hide();
                                    
                                    // Sembunyikan baris jadwal yang sesuai
                                    for (var j = 1; j < rowCount; j++) {
                                        var childRow = $('#jadwalVisualTable tbody tr').eq(startRow + j);
                                        if (childRow.length) {
                                            childRow.hide();
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        });
        
        // Pindahkan kotak pencarian ke posisi yang lebih baik jika elemen ada
        if ($('#jadwalTable_filter').length) {
            $('#jadwalTable_filter').addClass('float-right mb-3');
            $('#jadwalVisualTable').before($('#jadwalTable_filter'));
            
            // Sembunyikan tabel DataTables sepenuhnya
            if ($('#jadwalTable_wrapper').length) {
                $('#jadwalTable_wrapper').hide();
            }
        }
        
        // Event handler modal konfirmasi hapus
        $('.btn-hapus').on('click', function() {
            var id = $(this).data('id');
            $('#btn-delete-confirm').attr('href', '<?= base_url('jadwal/hapus/') ?>' + id);
        });
    });
</script>

<style>
    .border-3 {
        border-width: 3px !important;
    }
    #jadwalVisualTable tbody tr:last-child {
        border-bottom: 2px solid #e3e6f0;
    }
    #jadwalVisualTable tbody tr.border-top {
        border-top: 3px solid #4e73df !important;
    }
</style>

<?//php $this->load->view('templates/footer'); ?> 