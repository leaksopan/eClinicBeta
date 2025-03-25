<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list-alt mr-1"></i> Daftar Antrian
                    </h6>
                    <div class="d-flex align-items-center">
                        <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-sm btn-secondary mr-2">
                            <i class="fas fa-sync-alt"></i> Reset Filter
                        </a>
                        <a href="<?= base_url('kunjungan/tambah_antrian'); ?>" class="btn btn-sm btn-success mr-2">
                            <i class="fas fa-plus-circle"></i> Tambah Antrian
                        </a>
                        <a href="<?= base_url('kunjungan'); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-procedures"></i> Data Kunjungan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Filter Form -->
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="m-0 font-weight-bold text-dark">Filter Antrian</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('kunjungan/antrian'); ?>" method="get" class="form-inline" id="formFilter">
                                    <div class="form-group mb-2 mr-3">
                                        <label for="tanggal_awal" class="mr-2">Dari:</label>
                                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d'); ?>">
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="tanggal_akhir" class="mr-2">Sampai:</label>
                                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d'); ?>">
                                    </div>
                                    <?php if(isset($_GET['id_poliklinik'])): ?>
                                        <input type="hidden" name="id_poliklinik" value="<?= $_GET['id_poliklinik']; ?>">
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#lookupPoliModal">
                                        <i class="fas fa-clinic-medical"></i> Pilih Poliklinik
                                    </button>
                                    <button type="submit" class="btn btn-primary mb-2 mr-2">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-secondary mb-2">
                                        <i class="fas fa-sync-alt"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tampilan Antrian -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        <i class="fas fa-calendar-day"></i> Antrian Tanggal: 
                                        <?php 
                                        if (isset($filter['tanggal_awal']) && isset($filter['tanggal_akhir'])) {
                                            if ($filter['tanggal_awal'] == $filter['tanggal_akhir']) {
                                                echo date('d F Y', strtotime($filter['tanggal_awal']));
                                            } else {
                                                echo date('d F Y', strtotime($filter['tanggal_awal'])) . ' - ' . date('d F Y', strtotime($filter['tanggal_akhir']));
                                            }
                                        } else {
                                            echo date('d F Y');
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-fill mb-4" id="antrianTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-center py-3" id="aktif-tab" data-toggle="tab" href="#aktif" role="tab" style="font-size: 1.2em; background-color: #f8f9fc;">
                                <i class="fas fa-user-clock fa-lg"></i> BELUM PERIKSA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center py-3" id="riwayat-tab" data-toggle="tab" href="#riwayat" role="tab" style="font-size: 1.2em; background-color: #f8f9fc;">
                                <i class="fas fa-history fa-lg"></i> SUDAH PERIKSA
                            </a>
                        </li>
                    </ul>
                    
                    <style>
                    .nav-tabs {
                        border: none;
                    }

                    .nav-tabs .nav-link {
                        border: 2px solid #dee2e6;
                        margin: 0 5px;
                        font-weight: bold;
                        color: #6c757d;
                        border-radius: 5px;
                    }

                    .nav-tabs .nav-link.active {
                        border-color: #4e73df;
                        color: #4e73df;
                        background-color: #fff !important;
                    }

                    .nav-tabs .nav-link:hover {
                        border-color: #4e73df;
                        color: #4e73df;
                        background-color: #fff !important;
                    }
                    </style>
                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Tab Antrian Aktif -->
                        <div class="tab-pane fade show active" id="aktif" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tableAntrianAktif" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No. Antrian</th>
                                            <th>Nama Pasien</th>
                                            <th>Poliklinik</th>
                                            <th>Dokter</th>
                                            <th>Waktu Daftar</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $ada_antrian_aktif = false;
                                        if(!empty($antrian)): 
                                            foreach($antrian as $an): 
                                                if($an->status == 'menunggu' || $an->status == 'diperiksa'):
                                                    $ada_antrian_aktif = true;
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-primary" style="font-size: 1.2em; padding: 8px 12px;">
                                                        <?= $an->no_antrian ?>
                                                    </span>
                                                </td>
                                                <td><?= $an->nama_pasien; ?></td>
                                                <td><?= $an->nama_poli; ?></td>
                                                <td><?= $an->nama_dokter ?? '-'; ?></td>
                                                <td><?= date('H:i', strtotime($an->waktu_daftar)); ?> WIB</td>
                                                <td>
                                                    <span class="badge badge-<?= $an->status == 'menunggu' ? 'warning' : 'info' ?>">
                                                        <?= $an->status == 'menunggu' ? 'Menunggu' : 'Sedang Diperiksa' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($an->status == 'menunggu'): ?>
                                                        <a href="<?= base_url('kunjungan/periksa/'.$an->id_antrian); ?>" class="btn btn-primary btn-sm" title="Periksa">
                                                            <i class="fas fa-stethoscope"></i> Periksa
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?= base_url('kunjungan/periksa/'.$an->id_antrian); ?>" class="btn btn-info btn-sm" title="Lanjutkan Pemeriksaan">
                                                            <i class="fas fa-stethoscope"></i> Lanjutkan
                                                        </a>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?= base_url('kunjungan/batal_antrian/' . $an->id_antrian); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan antrian ini?');" title="Batalkan">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                    
                                                    <a href="<?= base_url('kunjungan/cetak_antrian/' . $an->id_antrian); ?>" class="btn btn-secondary btn-sm" target="_blank" title="Cetak">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php 
                                                endif;
                                            endforeach; 
                                        endif;
                                        
                                        if(!$ada_antrian_aktif): 
                                        ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada antrian aktif saat ini.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Riwayat Antrian -->
                        <div class="tab-pane fade" id="riwayat" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tableAntrianSelesai" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No. Antrian</th>
                                            <th>Nama Pasien</th>
                                            <th>Poliklinik</th>
                                            <th>Dokter</th>
                                            <th>Waktu Daftar</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $ada_antrian_selesai = false;
                                        if(!empty($antrian)): 
                                            foreach($antrian as $an): 
                                                if($an->status == 'selesai' || $an->status == 'batal'):
                                                    $ada_antrian_selesai = true;
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-secondary" style="font-size: 1.2em; padding: 8px 12px;">
                                                        <?= $an->no_antrian ?>
                                                    </span>
                                                </td>
                                                <td><?= $an->nama_pasien; ?></td>
                                                <td><?= $an->nama_poli; ?></td>
                                                <td><?= $an->nama_dokter ?? '-'; ?></td>
                                                <td><?= date('H:i', strtotime($an->waktu_daftar)); ?> WIB</td>
                                                <td>
                                                    <span class="badge badge-<?= $an->status == 'selesai' ? 'success' : 'danger' ?>">
                                                        <?= $an->status == 'selesai' ? 'Selesai' : 'Batal' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('kunjungan/cetak_antrian/' . $an->id_antrian); ?>" class="btn btn-secondary btn-sm" target="_blank" title="Cetak">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <?php if($an->status == 'batal'): ?>
                                                        <a href="<?= base_url('kunjungan/hapus_antrian/' . $an->id_antrian); ?>" 
                                                           class="btn btn-danger btn-sm" 
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini? Data yang dihapus tidak dapat dikembalikan.');" 
                                                           title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php 
                                                endif;
                                            endforeach; 
                                        endif;
                                        
                                        if(!$ada_antrian_selesai): 
                                        ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada riwayat antrian.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lookup Poliklinik -->
<div class="modal fade" id="lookupPoliModal" tabindex="-1" role="dialog" aria-labelledby="lookupPoliModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="lookupPoliModalLabel">
                    <i class="fas fa-clinic-medical"></i> Filter Antrian Berdasarkan Poliklinik
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchPoli" placeholder="Cari berdasarkan Nama Poliklinik">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="btnSearchPoli">
                                <i class="fas fa-search"></i> FILTER
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tablePoliklinik">
                        <thead class="thead-light">
                            <tr>
                                <th>KODE</th>
                                <th>NAMA POLIKLINIK</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($poliklinik as $poli): ?>
                            <tr>
                                <td><?= $poli->kode_poli ?></td>
                                <td><?= $poli->nama_poli ?></td>
                                <td>
                                    <span class="badge badge-<?= $poli->status == 'aktif' ? 'success' : 'danger' ?>">
                                        <?= strtoupper($poli->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('kunjungan/antrian?id_poliklinik=' . $poli->id_poli 
                                        . '&tanggal_awal=' . (isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d'))
                                        . '&tanggal_akhir=' . (isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d'))) ?>" 
                                       class="btn btn-sm btn-primary pilih-poli">
                                        <i class="fas fa-check"></i> FILTER
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // DataTable untuk antrian aktif
    $('#tableAntrianAktif').DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // DataTable untuk antrian selesai/batal
    $('#tableAntrianSelesai').DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
    
    // Auto refresh setiap 30 detik
    // setInterval(function() {
    //     location.reload();
    // }, 30000);

    // DataTable untuk tabel poliklinik
    var tablePoli = $('#tablePoliklinik').DataTable({
        "order": [[ 1, "asc" ]],
        "pageLength": 5,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Search poliklinik
    $('#btnSearchPoli').on('click', function() {
        tablePoli.search($('#searchPoli').val()).draw();
    });

    $('#searchPoli').on('keypress', function(e) {
        if(e.which == 13) {
            tablePoli.search($(this).val()).draw();
        }
    });

    // Validate date range before submit
    $('#formFilter').on('submit', function(e) {
        var tanggal_awal = $('#tanggal_awal').val();
        var tanggal_akhir = $('#tanggal_akhir').val();
        
        if (tanggal_awal > tanggal_akhir) {
            e.preventDefault();
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
            return false;
        }
    });

    // Set min date for tanggal_akhir based on tanggal_awal
    $('#tanggal_awal').on('change', function() {
        $('#tanggal_akhir').attr('min', $(this).val());
        if($('#tanggal_akhir').val() < $(this).val()) {
            $('#tanggal_akhir').val($(this).val());
        }
    });

    // Set max date for tanggal_awal based on tanggal_akhir
    $('#tanggal_akhir').on('change', function() {
        $('#tanggal_awal').attr('max', $(this).val());
        if($('#tanggal_awal').val() > $(this).val()) {
            $('#tanggal_awal').val($(this).val());
        }
    });
});
</script> 