<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron bg-primary text-white">
                <h2><i class="fas fa-clinic-medical"></i> Selamat Datang di e-Clinic</h2>
                <p class="lead">Sistem Manajemen Klinik Terpadu</p>
            </div>
        </div>
    </div>

    <!-- Quick Access Tab -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Akses Cepat Modul</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-fill" id="moduleTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pasien-tab" data-toggle="tab" href="#pasien" role="tab">
                                <i class="fas fa-user-injured"></i> Pasien
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="dokter-tab" data-toggle="tab" href="#dokter" role="tab">
                                <i class="fas fa-user-md"></i> Dokter
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="kunjungan-tab" data-toggle="tab" href="#kunjungan" role="tab">
                                <i class="fas fa-procedures"></i> Kunjungan
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="obat-tab" data-toggle="tab" href="#obat" role="tab">
                                <i class="fas fa-pills"></i> Obat
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="surat-tab" data-toggle="tab" href="#surat" role="tab">
                                <i class="fas fa-envelope"></i> Surat
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="laporan-tab" data-toggle="tab" href="#laporan" role="tab">
                                <i class="fas fa-chart-bar"></i> Laporan
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content border border-top-0 rounded-bottom p-3" id="moduleTabContent">
                        <!-- Pasien Tab -->
                        <div class="tab-pane fade show active" id="pasien" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                                            <h5>Tambah Pasien Baru</h5>
                                            <a href="<?= base_url('pasien/tambah') ?>" class="btn btn-primary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-search fa-3x mb-3 text-primary"></i>
                                            <h5>Cari Pasien</h5>
                                            <a href="<?= base_url('pasien') ?>" class="btn btn-primary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-medical fa-3x mb-3 text-primary"></i>
                                            <h5>Rekam Medis</h5>
                                            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-primary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-id-card fa-3x mb-3 text-primary"></i>
                                            <h5>Kartu Pasien</h5>
                                            <a href="<?= base_url('pasien/kartu') ?>" class="btn btn-primary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dokter Tab -->
                        <div class="tab-pane fade" id="dokter" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-md fa-3x mb-3 text-success"></i>
                                            <h5>Daftar Dokter</h5>
                                            <a href="<?= base_url('dokter') ?>" class="btn btn-success btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-plus fa-3x mb-3 text-success"></i>
                                            <h5>Tambah Dokter</h5>
                                            <a href="<?= base_url('dokter/tambah') ?>" class="btn btn-success btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calendar-alt fa-3x mb-3 text-success"></i>
                                            <h5>Jadwal Praktek</h5>
                                            <a href="<?= base_url('jadwal') ?>" class="btn btn-success btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-money-bill-wave fa-3x mb-3 text-success"></i>
                                            <h5>Tarif Dokter</h5>
                                            <a href="<?= base_url('dokter/tarif') ?>" class="btn btn-success btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kunjungan Tab -->
                        <div class="tab-pane fade" id="kunjungan" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-clipboard-list fa-3x mb-3 text-info"></i>
                                            <h5>Pendaftaran</h5>
                                            <a href="<?= base_url('kunjungan/tambah_antrian') ?>" class="btn btn-info btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-list-ol fa-3x mb-3 text-info"></i>
                                            <h5>Antrian</h5>
                                            <a href="<?= base_url('kunjungan/antrian') ?>" class="btn btn-info btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-procedures fa-3x mb-3 text-info"></i>
                                            <h5>Pemeriksaan</h5>
                                            <a href="<?= base_url('pemeriksaan') ?>" class="btn btn-info btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-history fa-3x mb-3 text-info"></i>
                                            <h5>Riwayat Kunjungan</h5>
                                            <a href="<?= base_url('kunjungan') ?>" class="btn btn-info btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Obat Tab -->
                        <div class="tab-pane fade" id="obat" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-pills fa-3x mb-3 text-danger"></i>
                                            <h5>Daftar Obat</h5>
                                            <a href="<?= base_url('obat') ?>" class="btn btn-danger btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-plus-circle fa-3x mb-3 text-danger"></i>
                                            <h5>Tambah Obat</h5>
                                            <a href="<?= base_url('obat/tambah') ?>" class="btn btn-danger btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-clipboard-check fa-3x mb-3 text-danger"></i>
                                            <h5>Stok Obat</h5>
                                            <a href="<?= base_url('obat/stok') ?>" class="btn btn-danger btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-invoice fa-3x mb-3 text-danger"></i>
                                            <h5>Resep Obat</h5>
                                            <a href="<?= base_url('resep') ?>" class="btn btn-danger btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Surat Tab -->
                        <div class="tab-pane fade" id="surat" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-envelope fa-3x mb-3 text-warning"></i>
                                            <h5>Daftar Surat</h5>
                                            <a href="<?= base_url('surat') ?>" class="btn btn-warning btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-envelope-open-text fa-3x mb-3 text-warning"></i>
                                            <h5>Buat Surat Baru</h5>
                                            <a href="<?= base_url('surat/buat') ?>" class="btn btn-warning btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-signature fa-3x mb-3 text-warning"></i>
                                            <h5>Surat Keterangan Sakit</h5>
                                            <a href="<?= base_url('surat/buat/SKS') ?>" class="btn btn-warning btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-medical fa-3x mb-3 text-warning"></i>
                                            <h5>Surat Rujukan</h5>
                                            <a href="<?= base_url('surat/buat/SRJ') ?>" class="btn btn-warning btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Laporan Tab -->
                        <div class="tab-pane fade" id="laporan" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calendar-day fa-3x mb-3 text-secondary"></i>
                                            <h5>Laporan Harian</h5>
                                            <a href="<?= base_url('laporan/harian') ?>" class="btn btn-secondary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calendar-week fa-3x mb-3 text-secondary"></i>
                                            <h5>Laporan Bulanan</h5>
                                            <a href="<?= base_url('laporan/bulanan') ?>" class="btn btn-secondary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-users fa-3x mb-3 text-secondary"></i>
                                            <h5>Laporan Pasien</h5>
                                            <a href="<?= base_url('laporan/pasien') ?>" class="btn btn-secondary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-money-bill-alt fa-3x mb-3 text-secondary"></i>
                                            <h5>Laporan Keuangan</h5>
                                            <a href="<?= base_url('laporan/keuangan') ?>" class="btn btn-secondary btn-sm mt-2">Akses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pasien Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. 2.500.000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">578</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Surat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_surat ?: 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrian & Jadwal Cards -->
    <div class="row">
        <!-- Antrian Pasien -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Antrian Pasien Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ahmad Zulkarnain</td>
                                    <td>dr. Budi Santoso</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>dr. Rina Wijaya</td>
                                    <td><span class="badge badge-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Rudi Hermawan</td>
                                    <td>dr. Budi Santoso</td>
                                    <td><span class="badge badge-info">Proses</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Dewi Safitri</td>
                                    <td>dr. Rina Wijaya</td>
                                    <td><span class="badge badge-warning">Menunggu</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= base_url('kunjungan/antrian') ?>" class="btn btn-primary btn-sm float-right">Lihat Semua</a>
                </div>
            </div>
        </div>

        <!-- Jadwal Dokter -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Jadwal Dokter Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Dokter</th>
                                    <th>Spesialis</th>
                                    <th>Jam Praktek</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>dr. Budi Santoso</td>
                                    <td>Umum</td>
                                    <td>08:00 - 12:00</td>
                                    <td><span class="badge badge-success">Hadir</span></td>
                                </tr>
                                <tr>
                                    <td>dr. Rina Wijaya</td>
                                    <td>Gigi</td>
                                    <td>09:00 - 14:00</td>
                                    <td><span class="badge badge-success">Hadir</span></td>
                                </tr>
                                <tr>
                                    <td>dr. Dimas Prayoga</td>
                                    <td>Anak</td>
                                    <td>13:00 - 17:00</td>
                                    <td><span class="badge badge-warning">Belum Hadir</span></td>
                                </tr>
                                <tr>
                                    <td>dr. Siska Meliana</td>
                                    <td>Kulit</td>
                                    <td>16:00 - 20:00</td>
                                    <td><span class="badge badge-warning">Belum Hadir</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= base_url('jadwal') ?>" class="btn btn-success btn-sm float-right">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Atur tab aktif berdasarkan localStorage jika ada
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#moduleTab a[href="' + activeTab + '"]').tab('show');
        }

        // Simpan tab aktif ke localStorage ketika tab berubah
        $('#moduleTab a').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
    });
</script>

<?php $this->load->view('templates/footer'); ?> 