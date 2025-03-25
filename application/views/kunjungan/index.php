<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-procedures"></i> Daftar Kunjungan Pasien
            </h6>
            <div>
                <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-list-ol"></i> Kelola Antrian
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
                        <h6 class="m-0 font-weight-bold text-dark">Filter Data</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('kunjungan'); ?>" method="get" class="form-inline">
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
                                <label for="id_dokter" class="mr-2">Dokter:</label>
                                <select class="form-control" id="id_dokter" name="id_dokter">
                                    <option value="">Semua Dokter</option>
                                    <?php foreach($dokter as $dok): ?>
                                        <option value="<?= $dok->id_dokter; ?>" <?= (isset($filter['id_dokter']) && $filter['id_dokter'] == $dok->id_dokter) ? 'selected' : ''; ?>>
                                            <?= $dok->nama; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-2 mr-3">
                                <label for="status" class="mr-2">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" <?= (isset($filter['status']) && $filter['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="selesai" <?= (isset($filter['status']) && $filter['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="batal" <?= (isset($filter['status']) && $filter['status'] == 'batal') ? 'selected' : ''; ?>>Batal</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="<?= base_url('kunjungan'); ?>" class="btn btn-secondary mb-2 ml-2">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Tabel Kunjungan -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Kunjungan</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($kunjungan)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data kunjungan.</td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $no = 1;
                            foreach($kunjungan as $kj): 
                                // Format status
                                $status_class = '';
                                switch($kj->status) {
                                    case 'aktif':
                                        $status_class = 'primary';
                                        break;
                                    case 'selesai':
                                        $status_class = 'success';
                                        break;
                                    case 'batal':
                                        $status_class = 'danger';
                                        break;
                                    default:
                                        $status_class = 'secondary';
                                }
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $kj->no_kunjungan; ?></td>
                                    <td><?= date('d-m-Y', strtotime($kj->tanggal)); ?></td>
                                    <td><?= $kj->nama_pasien; ?></td>
                                    <td><?= $kj->nama_poli; ?></td>
                                    <td><?= $kj->nama_dokter; ?></td>
                                    <td><?= $kj->diagnosis ? substr($kj->diagnosis, 0, 50) . (strlen($kj->diagnosis) > 50 ? '...' : '') : '-'; ?></td>
                                    <td><span class="badge badge-<?= $status_class; ?>"><?= ucfirst($kj->status); ?></span></td>
                                    <td>
                                        <!-- Tombol Aksi -->
                                        <a href="<?= base_url('kunjungan/detail/' . $kj->id_kunjungan); ?>" class="btn btn-info btn-sm mb-1" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if($kj->status == 'aktif'): ?>
                                            <a href="<?= base_url('kunjungan/edit/' . $kj->id_kunjungan); ?>" class="btn btn-primary btn-sm mb-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
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

<!-- DataTables -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [[ 2, "desc" ], [ 1, "desc" ]],
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
});
</script>