<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list-ol"></i> Antrian Pasien
                    </h6>
                    <div>
                        <a href="<?= base_url('kunjungan/tambah_antrian'); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Antrian
                        </a>
                        <a href="<?= base_url('kunjungan'); ?>" class="btn btn-primary btn-sm">
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
                                <form action="<?= base_url('kunjungan/antrian'); ?>" method="get" class="form-inline">
                                    <div class="form-group mb-2 mr-3">
                                        <label for="tanggal" class="mr-2">Tanggal:</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $filter['tanggal'] ?? date('Y-m-d'); ?>">
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="id_poliklinik" class="mr-2">Poliklinik:</label>
                                        <select class="form-control" id="id_poliklinik" name="id_poliklinik">
                                            <option value="">Semua Poliklinik</option>
                                            <?php foreach($poliklinik as $poli): ?>
                                                <option value="<?= $poli->id_poliklinik; ?>" <?= (isset($filter['id_poliklinik']) && $filter['id_poliklinik'] == $poli->id_poliklinik) ? 'selected' : ''; ?>>
                                                    <?= $poli->nama; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="status" class="mr-2">Status:</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="menunggu" <?= (isset($filter['status']) && $filter['status'] == 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                                            <option value="diperiksa" <?= (isset($filter['status']) && $filter['status'] == 'diperiksa') ? 'selected' : ''; ?>>Diperiksa</option>
                                            <option value="selesai" <?= (isset($filter['status']) && $filter['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                            <option value="batal" <?= (isset($filter['status']) && $filter['status'] == 'batal') ? 'selected' : ''; ?>>Batal</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-secondary mb-2 ml-2">
                                        <i class="fas fa-redo"></i> Reset
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
                                        <i class="fas fa-calendar-day"></i> Antrian Tanggal: <?= date('d F Y', strtotime($filter['tanggal'] ?? date('Y-m-d'))); ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabel Antrian -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
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
                                <?php if(empty($antrian)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada antrian saat ini.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($antrian as $an): 
                                        // Format status
                                        $status_class = '';
                                        $status_text = '';
                                        switch($an->status) {
                                            case 'menunggu':
                                                $status_class = 'warning';
                                                $status_text = 'Menunggu';
                                                break;
                                            case 'diperiksa':
                                                $status_class = 'info';
                                                $status_text = 'Sedang Diperiksa';
                                                break;
                                            case 'selesai':
                                                $status_class = 'success';
                                                $status_text = 'Selesai';
                                                break;
                                            case 'batal':
                                                $status_class = 'danger';
                                                $status_text = 'Batal';
                                                break;
                                            default:
                                                $status_class = 'secondary';
                                                $status_text = ucfirst($an->status);
                                        }
                                    ?>
                                        <tr>
                                            <td><span class="badge badge-primary" style="font-size: 1.2em;"><?= $an->no_antrian; ?></span></td>
                                            <td><?= $an->nama_pasien; ?></td>
                                            <td><?= $an->nama_poli; ?></td>
                                            <td><?= $an->nama_dokter ?? '-'; ?></td>
                                            <td><?= date('H:i', strtotime($an->waktu_daftar)); ?> WIB</td>
                                            <td><span class="badge badge-<?= $status_class; ?>"><?= $status_text; ?></span></td>
                                            <td>
                                                <!-- Tombol Aksi -->
                                                <?php if ($an->status == 'menunggu'): ?>
                                                    <a href="<?= base_url('kunjungan/periksa/'.$an->id_antrian); ?>" class="btn btn-primary btn-sm" title="Periksa">
                                                        <i class="fas fa-stethoscope"></i> Periksa
                                                    </a>
                                                <?php elseif ($an->status == 'diperiksa'): ?>
                                                    <a href="<?= base_url('kunjungan/periksa/'.$an->id_antrian); ?>" class="btn btn-info btn-sm" title="Lanjutkan Pemeriksaan">
                                                        <i class="fas fa-stethoscope"></i> Lanjutkan
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <a href="<?= base_url('kunjungan/batal_antrian/' . $an->id_antrian); ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Apakah Anda yakin ingin membatalkan antrian ini?');" title="Batalkan">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                
                                                <a href="<?= base_url('kunjungan/cetak_antrian/' . $an->id_antrian); ?>" class="btn btn-secondary btn-sm mb-1" target="_blank" title="Cetak">
                                                    <i class="fas fa-print"></i>
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
        </div>
    </div>
</div>

<!-- DataTables -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [[ 0, "asc" ]],
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
    setInterval(function() {
        location.reload();
    }, 30000);
});
</script> 