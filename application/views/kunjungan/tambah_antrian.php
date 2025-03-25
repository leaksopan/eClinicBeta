<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Antrian Pasien Baru
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?= form_open('kunjungan/tambah_antrian'); ?>
                        <!-- Panel Pasien -->
                        <div class="card mb-4 border-left-primary">
                            <div class="card-header bg-light py-2">
                                <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                            </div>
                            <div class="card-body">
                        <div class="form-group">
                                    <label for="id_pasien">Pilih Pasien <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="hidden" id="id_pasien" name="id_pasien" required>
                                        <input type="text" class="form-control" id="nama_pasien" readonly placeholder="Pilih pasien" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btn-cari-pasien">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                            <?= form_error('id_pasien', '<small class="text-danger">', '</small>'); ?>
                            <small class="form-text text-muted">
                                <a href="<?= base_url('pasien/tambah'); ?>" target="_blank">
                                    <i class="fas fa-plus-circle"></i> Tambah Pasien Baru
                                </a>
                            </small>
                        </div>
                        
                                <!-- Info pasien yang dipilih -->
                                <div id="info-pasien" class="mb-3" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. RM</label>
                                                <input type="text" class="form-control" id="no_rm" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <input type="text" class="form-control" id="jenis_kelamin" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <input type="text" class="form-control" id="tgl_lahir" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telepon</label>
                                                <input type="text" class="form-control" id="telepon" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control" id="alamat" rows="2" readonly></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Terakhir Berobat</label>
                                                <input type="text" class="form-control" id="terakhir_berobat" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 d-flex justify-content-between">
                                            <a href="#" class="text-primary" id="btn-lihat-detail-pasien">
                                                <i class="fas fa-user-check"></i> Lihat Detail Pasien
                                            </a>
                                            <a href="#" class="text-success" id="btn-edit-pasien">
                                                <i class="fas fa-user-edit"></i> Edit Data Pasien
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Detail lengkap pasien -->
                                <div id="detail-lengkap-pasien" class="mt-3" style="display: none;">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 font-weight-bold">Data Lengkap Pasien</h6>
                                                <button type="button" class="close text-white" id="tutup-detail-pasien" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <!-- Data Identitas Pasien -->
                                                <div class="col-md-6">
                                                    <h6 class="border-bottom pb-2 mb-3 text-primary">Data Identitas</h6>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">No. RM</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-no-rm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-nama" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">NIK</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-nik" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-tempat-lahir" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Tgl Lahir</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-tgl-lahir" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-gender" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Golongan Darah</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-golongan-darah" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Agama</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-agama" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Status Nikah</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-status-nikah" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Pendidikan</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-pendidikan" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Pekerjaan</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-pekerjaan" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Data Kontak, Alamat, dan Medis -->
                                                <div class="col-md-6">
                                                    <h6 class="border-bottom pb-2 mb-3 text-primary">Kontak & Alamat</h6>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Telepon</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-telepon" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Email</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-email" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Alamat</label>
                                                        <div class="col-sm-8">
                                                            <p class="form-control-plaintext" id="detail-alamat"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Provinsi</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-provinsi" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Kota/Kab</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-kota" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Kecamatan</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-kecamatan" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">Data Medis</h6>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Tipe Pasien</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-tipe-pasien" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">No. BPJS</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-no-bpjs" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Alergi</label>
                                                        <div class="col-sm-8">
                                                            <p class="form-control-plaintext" id="detail-alergi"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Terakhir Berobat</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-terakhir-berobat" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Data Keluarga dan Kontak Darurat -->
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <h6 class="border-bottom pb-2 mb-3 text-primary">Data Keluarga & Kontak Darurat</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Nama Keluarga</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-nama-keluarga" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Hubungan</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-hubungan-keluarga" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Telepon Darurat</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext" id="detail-telepon-darurat" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-4 col-form-label">Alamat Keluarga</label>
                                                        <div class="col-sm-8">
                                                            <p class="form-control-plaintext" id="detail-alamat-keluarga"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Panel Poliklinik & Dokter -->
                        <div class="card mb-4 border-left-info">
                            <div class="card-header bg-light py-2">
                                <h6 class="m-0 font-weight-bold text-info">Poliklinik & Dokter</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_poliklinik">Poliklinik <span class="text-danger">*</span></label>
                                            <div class="input-group">
                            <select class="form-control" id="id_poliklinik" name="id_poliklinik" required>
                                <option value="">-- Pilih Poliklinik --</option>
                                <?php foreach($poliklinik as $poli): ?>
                                    <option value="<?= $poli->id_poli; ?>">
                                        <?= $poli->nama_poli; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" id="btn-cari-poli">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                            <?= form_error('id_poliklinik', '<small class="text-danger">', '</small>'); ?>
                        </div>
                                    </div>
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_dokter">Dokter <small class="text-muted">(Opsional)</small></label>
                                            <div class="input-group">
                            <select class="form-control" id="id_dokter" name="id_dokter">
                                <option value="">-- Pilih Dokter --</option>
                                                    <!-- Dokter akan dimuat berdasarkan poliklinik yang dipilih (AJAX) -->
                            </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" id="btn-cari-dokter">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <button class="btn btn-success" type="button" id="btn-jadwal-dokter">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                            <small class="form-text text-muted">Dokter akan diisi berdasarkan jadwal atau saat pemeriksaan jika tidak dipilih.</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Jadwal Dokter -->
                                <div id="jadwal-dokter-container" class="row mt-3" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_jadwal">Jam Praktek <span class="text-danger">*</span></label>
                                            <select class="form-control" id="id_jadwal" name="id_jadwal">
                                                <option value="">-- Pilih Jam Praktek --</option>
                                                <!-- Jadwal akan dimuat berdasarkan dokter yang dipilih (AJAX) -->
                                            </select>
                                            <small class="form-text text-muted">Pilih jam praktek dokter yang tersedia</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Preview Jadwal Yang Dipilih -->
                                    <div class="col-md-12">
                                        <div id="jadwal-info" class="alert alert-info" style="display: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <i class="fas fa-calendar-check fa-2x"></i>
                                                </div>
                                                <div>
                                                    <div class="mb-1" id="jadwal-section"></div>
                                                    <div class="mb-1" id="jadwal-dokter"></div>
                                                    <div id="jadwal-jam"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Panel Informasi Kunjungan -->
                        <div class="card mb-4 border-left-success">
                            <div class="card-header bg-light py-2">
                                <h6 class="m-0 font-weight-bold text-success">Informasi Kunjungan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                        <div class="form-group">
                                            <label for="tanggal">Tanggal Kunjungan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= set_value('tanggal', date('Y-m-d')); ?>" required>
                            <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="preview_nomor_antrian">Nomor Antrian</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white">
                                                        <i class="fas fa-ticket-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control bg-light text-center font-weight-bold" id="preview_nomor_antrian" readonly value="--" style="font-size: 1.2rem;">
                                            </div>
                                            <small class="form-text text-muted">Nomor antrian akan muncul setelah memilih poliklinik dan dokter</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Simpan Data Antrian
                        </button>
                                <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                            </div>
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lookup Data Pasien -->
<div class="modal fade" id="modal-lookup-pasien" tabindex="-1" role="dialog" aria-labelledby="pasienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="pasienModalLabel">Lookup Data Pasien</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search-pasien" placeholder="Cari berdasarkan Nama/No.RM/No.Identitas">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="btn-search-pasien">
                                <i class="fas fa-search"></i> FILTER
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-pasien">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">NO.RM</th>
                                <th>PASIEN</th>
                                <th>TGL LAHIR</th>
                                <th>JENIS KELAMIN</th>
                                <th>TIPE PASIEN</th>
                                <th>TELEPON</th>
                                <th>ALAMAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data pasien akan dimuat di sini menggunakan AJAX -->
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination-pasien">
                        <!-- Pagination akan dimuat di sini -->
                    </ul>
                </nav>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lookup Poliklinik -->
<div class="modal fade" id="modal-lookup-poli" tabindex="-1" role="dialog" aria-labelledby="poliModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="poliModalLabel">Lookup Poliklinik</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search-poli" placeholder="Cari Poliklinik">
                        <div class="input-group-append">
                            <button class="btn btn-info" id="btn-search-poli">
                                <i class="fas fa-search"></i> FILTER
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-poli">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>NAMA POLIKLINIK</th>
                                <th>LOKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($poliklinik as $poli): ?>
                                <tr class="pilih-poli" data-id="<?= $poli->id_poli; ?>" data-nama="<?= $poli->nama_poli; ?>" data-dismiss="modal" style="cursor:pointer">
                                    <td><?= $poli->id_poli; ?></td>
                                    <td><?= $poli->nama_poli; ?></td>
                                    <td><?= $poli->lokasi ?? '-'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lookup Dokter -->
<div class="modal fade" id="modal-lookup-dokter" tabindex="-1" role="dialog" aria-labelledby="dokterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="dokterModalLabel">Lookup Dokter</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-dokter">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>NAMA DOKTER</th>
                                <th>SPESIALISASI</th>
                                <th>JADWAL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data dokter akan dimuat di sini menggunakan AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Jadwal Dokter (Mingguan) -->
<div class="modal fade" id="modal-jadwal-mingguan" tabindex="-1" role="dialog" aria-labelledby="jadwalMingguanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="jadwalMingguanLabel">Jadwal Praktek Dokter</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jadwal-filter-dokter">Filter Dokter</label>
                            <select class="form-control" id="jadwal-filter-dokter">
                                <option value="">Semua Dokter</option>
                                <!-- Dokter akan dimuat menggunakan AJAX -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jadwal-filter-poli">Filter Poliklinik</label>
                            <select class="form-control" id="jadwal-filter-poli">
                                <option value="">Semua Poliklinik</option>
                                <?php foreach($poliklinik as $poli): ?>
                                    <option value="<?= $poli->id_poli; ?>">
                                        <?= $poli->nama_poli; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-sm btn-secondary" id="prev-week">
                                <i class="fas fa-chevron-left"></i> Minggu Sebelumnya
                            </button>
                            <h5 class="mb-0" id="current-week-text">Minggu Ini</h5>
                            <button type="button" class="btn btn-sm btn-secondary" id="next-week">
                                Minggu Berikutnya <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-jadwal-mingguan">
                        <thead class="thead-light">
                            <tr>
                                <th width="200">Dokter/Poli</th>
                                <th class="hari-column">Senin</th>
                                <th class="hari-column">Selasa</th>
                                <th class="hari-column">Rabu</th>
                                <th class="hari-column">Kamis</th>
                                <th class="hari-column">Jumat</th>
                                <th class="hari-column">Sabtu</th>
                                <th class="hari-column">Minggu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data jadwal akan dimuat di sini menggunakan AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="badge badge-success mr-2">●</span> Jadwal Tersedia
                        </div>
                        <div>
                            <span class="badge badge-danger mr-2">●</span> Tidak Ada Jadwal
                        </div>
                        <div>
                            <span class="badge badge-warning mr-2">●</span> Libur/Cuti
                        </div>
                        <div>
                            <a href="#" data-dismiss="modal" class="btn btn-sm btn-primary" id="pilih-tanggal-dari-jadwal">
                                <i class="fas fa-calendar-check"></i> Pilih Tanggal & Dokter Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk AJAX dan Modal -->
<!-- Tambahkan Moment.js untuk manipulasi tanggal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>
<script>
$(document).ready(function() {
    // ===== CALENDAR FEATURES =====
    var weeklySchedule = [];
    var currentWeekStart = moment().startOf('week');
    var selectedJadwalData = null;
    
    // Event klik pada tombol jadwal dokter
    $('#btn-jadwal-dokter').click(function() {
        loadAllDoctors();
        loadWeeklySchedule();
        $('#modal-jadwal-mingguan').modal('show');
    });
    
    // Filter jadwal berdasarkan dokter
    $('#jadwal-filter-dokter').change(function() {
        filterJadwalTable();
    });
    
    // Filter jadwal berdasarkan poliklinik
    $('#jadwal-filter-poli').change(function() {
        filterJadwalTable();
    });
    
    // Navigasi ke minggu sebelumnya
    $('#prev-week').click(function() {
        currentWeekStart = moment(currentWeekStart).subtract(1, 'weeks');
        loadWeeklySchedule();
    });
    
    // Navigasi ke minggu berikutnya
    $('#next-week').click(function() {
        currentWeekStart = moment(currentWeekStart).add(1, 'weeks');
        loadWeeklySchedule();
    });
    
    // Pilih tanggal dan dokter dari jadwal
    $('#pilih-tanggal-dari-jadwal').click(function() {
        if (selectedJadwalData) {
            // Set tanggal
            $('#tanggal').val(selectedJadwalData.tanggal);
            
            // Set dokter
            if (selectedJadwalData.id_dokter) {
                $('#id_dokter').val(selectedJadwalData.id_dokter);
            }
            
            // Set poliklinik
            if (selectedJadwalData.id_poliklinik) {
                $('#id_poliklinik').val(selectedJadwalData.id_poliklinik);
                $('#id_poliklinik').trigger('change');
            }
            
            // Setelah event change selesai (menggunakan setTimeout)
            setTimeout(function() {
                // Set ulang dokter karena poliklinik change event mengosongkannya
                if (selectedJadwalData.id_dokter) {
                    $('#id_dokter').val(selectedJadwalData.id_dokter);
                    $('#id_dokter').trigger('change');
                }
                
                // Pilih jadwal jika ada
                if (selectedJadwalData.id_jadwal) {
                    setTimeout(function() {
                        $('#id_jadwal').val(selectedJadwalData.id_jadwal);
                        $('#id_jadwal').trigger('change');
                    }, 500);
                }
            }, 500);
        }
    });
    
    // Fungsi untuk memuat semua dokter
    function loadAllDoctors() {
        $.ajax({
            url: '<?= base_url('dokter/get_all_dokter_json'); ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#jadwal-filter-dokter').empty();
                $('#jadwal-filter-dokter').append('<option value="">Semua Dokter</option>');
                
                if (response.length > 0) {
                    $.each(response, function(key, value) {
                        $('#jadwal-filter-dokter').append('<option value="' + value.id_dokter + '">' + value.nama + '</option>');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading doctors:", error);
            }
        });
    }
    
    // Fungsi untuk memuat jadwal mingguan
    function loadWeeklySchedule() {
        var startDate = moment(currentWeekStart).format('YYYY-MM-DD');
        var endDate = moment(currentWeekStart).add(6, 'days').format('YYYY-MM-DD');
        
        // Update teks minggu saat ini
        $('#current-week-text').text(moment(startDate).format('DD MMM YYYY') + ' - ' + moment(endDate).format('DD MMM YYYY'));
        
        // Update tanggal pada header tabel
        $('.hari-column').each(function(index) {
            var dayDate = moment(startDate).add(index, 'days');
            $(this).html(
                dayDate.format('dddd') + '<br>' +
                '<small>' + dayDate.format('DD/MM/YYYY') + '</small>'
            );
        });
        
        $.ajax({
            url: '<?= base_url('dokter/get_weekly_schedule'); ?>',
            type: 'post',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            beforeSend: function() {
                $('#table-jadwal-mingguan tbody').html('<tr><td colspan="8" class="text-center">Loading jadwal...</td></tr>');
            },
            success: function(response) {
                weeklySchedule = response;
                renderJadwalTable(response);
            },
            error: function(xhr, status, error) {
                console.error("Error loading schedule:", error);
                $('#table-jadwal-mingguan tbody').html('<tr><td colspan="8" class="text-center">Error loading jadwal</td></tr>');
            }
        });
    }
    
    // Fungsi untuk render tabel jadwal
    function renderJadwalTable(data) {
        $('#table-jadwal-mingguan tbody').empty();
        
        if (data && data.length > 0) {
            // Grup jadwal berdasarkan dokter
            var groupedSchedule = {};
            
            $.each(data, function(i, jadwal) {
                var key = jadwal.id_dokter + '-' + jadwal.id_poliklinik;
                
                if (!groupedSchedule[key]) {
                    groupedSchedule[key] = {
                        id_dokter: jadwal.id_dokter,
                        nama_dokter: jadwal.nama_dokter,
                        id_poliklinik: jadwal.id_poliklinik,
                        nama_poliklinik: jadwal.nama_poliklinik,
                        jadwal: Array(7).fill(null) // 7 hari dalam seminggu
                    };
                }
                
                // Hitung indeks hari dari startDate
                var dayIndex = moment(jadwal.tanggal).diff(moment(currentWeekStart), 'days');
                
                if (dayIndex >= 0 && dayIndex < 7) {
                    if (!groupedSchedule[key].jadwal[dayIndex]) {
                        groupedSchedule[key].jadwal[dayIndex] = [];
                    }
                    
                    groupedSchedule[key].jadwal[dayIndex].push(jadwal);
                }
            });
            
            // Render jadwal ke tabel
            $.each(groupedSchedule, function(key, group) {
                var row = '<tr class="jadwal-row" data-dokter="' + group.id_dokter + '" data-poli="' + group.id_poliklinik + '">' +
                         '<td><b>' + group.nama_dokter + '</b><br><small>' + group.nama_poliklinik + '</small></td>';
                
                // Jadwal per hari
                for (var i = 0; i < 7; i++) {
                    if (group.jadwal[i] && group.jadwal[i].length > 0) {
                        var cellContent = '';
                        var tanggal = moment(currentWeekStart).add(i, 'days').format('YYYY-MM-DD');
                        
                        $.each(group.jadwal[i], function(j, slot) {
                            var statusClass = 'success';
                            if (slot.status === 'cuti') {
                                statusClass = 'warning';
                            } else if (slot.status === 'penuh') {
                                statusClass = 'danger';
                            }
                            
                            cellContent += '<div class="jadwal-slot mb-1 p-1 border border-' + statusClass + ' rounded bg-' + statusClass + ' text-white" ' +
                                         'data-id="' + slot.id_jadwal + '" ' +
                                         'data-dokter="' + group.id_dokter + '" ' +
                                         'data-dokter-nama="' + group.nama_dokter + '" ' +
                                         'data-poli="' + group.id_poliklinik + '" ' +
                                         'data-tanggal="' + tanggal + '" ' +
                                         'style="cursor: pointer;">' +
                                         slot.jam_mulai + ' - ' + slot.jam_selesai +
                                         '</div>';
                        });
                        
                        row += '<td>' + cellContent + '</td>';
                    } else {
                        row += '<td class="text-center text-muted">-</td>';
                    }
                }
                
                row += '</tr>';
                $('#table-jadwal-mingguan tbody').append(row);
            });
            
            // Event klik pada slot jadwal
            $('.jadwal-slot').click(function() {
                // Hapus highlight sebelumnya
                $('.jadwal-slot').removeClass('selected-slot');
                
                // Highlight slot yang dipilih
                $(this).addClass('selected-slot');
                
                // Simpan data jadwal yang dipilih
                selectedJadwalData = {
                    id_jadwal: $(this).data('id'),
                    id_dokter: $(this).data('dokter'),
                    nama_dokter: $(this).data('dokter-nama'),
                    id_poliklinik: $(this).data('poli'),
                    tanggal: $(this).data('tanggal')
                };
                
                // Aktifkan tombol pilih
                $('#pilih-tanggal-dari-jadwal').removeClass('disabled').addClass('btn-primary');
            });
        } else {
            $('#table-jadwal-mingguan tbody').html('<tr><td colspan="8" class="text-center">Tidak ada jadwal tersedia</td></tr>');
        }
        
        // Terapkan filter
        filterJadwalTable();
    }
    
    // Fungsi untuk filter tabel jadwal
    function filterJadwalTable() {
        var filterDokter = $('#jadwal-filter-dokter').val();
        var filterPoli = $('#jadwal-filter-poli').val();
        
        $('.jadwal-row').show();
        
        if (filterDokter) {
            $('.jadwal-row:not([data-dokter="' + filterDokter + '"])').hide();
        }
        
        if (filterPoli) {
            $('.jadwal-row:not([data-poli="' + filterPoli + '"])').hide();
        }
        
        // Cek jika tidak ada baris yang visible
        if ($('.jadwal-row:visible').length === 0) {
            $('#table-jadwal-mingguan tbody').append('<tr class="no-results"><td colspan="8" class="text-center">Tidak ada jadwal yang sesuai dengan filter</td></tr>');
        } else {
            $('.no-results').remove();
        }
    }

    // ===== PATIENT SEARCH FUNCTIONS =====
    // Event klik pada tombol cari pasien
    $('#btn-cari-pasien').click(function() {
        // Reset search field
        $('#search-pasien').val('');
        
        // Load data pasien
        loadPasienData();
        
        // Tampilkan modal
        $('#modal-lookup-pasien').modal('show');
    });
    
    // Event search pada modal pasien
    $('#btn-search-pasien').click(function() {
        loadPasienData(1);
    });
    
    // Key press Enter pada field search pasien
    $('#search-pasien').keypress(function(e) {
        if(e.which == 13) {
            loadPasienData(1);
            return false;
        }
    });
    
    // Event untuk edit data pasien
    $('#btn-edit-pasien').click(function(e) {
        e.preventDefault();
        var id_pasien = $('#id_pasien').val();
        if (id_pasien) {
            window.open('<?= base_url('pasien/edit/'); ?>' + id_pasien, '_blank');
        }
    });
    
    // Event untuk melihat detail pasien
    $('#btn-lihat-detail-pasien').click(function(e) {
        e.preventDefault();
        var id_pasien = $('#id_pasien').val();
        if (id_pasien) {
            // Ambil data lengkap pasien
            getPasienDetailLengkap(id_pasien);
        }
    });
    
    // Event untuk menutup detail pasien
    $('#tutup-detail-pasien').click(function() {
        $('#detail-lengkap-pasien').slideUp();
    });
    
    // Fungsi untuk mengambil detail lengkap pasien
    function getPasienDetailLengkap(id_pasien) {
        $.ajax({
            url: '<?= base_url('pasien/get_detail_lengkap_json'); ?>',
            type: 'post',
            data: {
                id_pasien: id_pasien
            },
            dataType: 'json',
            beforeSend: function() {
                // Bisa tambahkan loading indicator di sini
            },
            success: function(response) {
                if(response.status) {
                    // Set value untuk detail pasien
                    var data = response.data;
                    
                    // Data Identitas
                    $('#detail-no-rm').val(data.no_rm || '-');
                    $('#detail-nama').val(data.nama_lengkap || '-');
                    $('#detail-nik').val(data.nik || '-');
                    $('#detail-tempat-lahir').val(data.tempat_lahir || '-');
                    $('#detail-tgl-lahir').val(data.tgl_lahir || '-');
                    $('#detail-gender').val(data.jenis_kelamin || '-');
                    $('#detail-golongan-darah').val(data.golongan_darah || '-');
                    $('#detail-agama').val(data.agama || '-');
                    $('#detail-status-nikah').val(data.status_nikah || '-');
                    $('#detail-pendidikan').val(data.pendidikan || '-');
                    $('#detail-pekerjaan').val(data.pekerjaan || '-');
                    
                    // Data Kontak & Alamat
                    $('#detail-telepon').val(data.telepon || '-');
                    $('#detail-email').val(data.email || '-');
                    $('#detail-alamat').text(data.alamat || '-');
                    $('#detail-provinsi').val(data.provinsi || '-');
                    $('#detail-kota').val(data.kota || '-');
                    $('#detail-kecamatan').val(data.kecamatan || '-');
                    
                    // Data Medis
                    $('#detail-tipe-pasien').val(data.tipe_pasien || '-');
                    $('#detail-no-bpjs').val(data.no_bpjs || '-');
                    $('#detail-alergi').text(data.riwayat_alergi || '-');
                    $('#detail-terakhir-berobat').val(response.terakhir_berobat || '-');
                    
                    // Data Keluarga
                    $('#detail-nama-keluarga').val(data.nama_keluarga || '-');
                    $('#detail-hubungan-keluarga').val(data.hubungan_keluarga || '-');
                    $('#detail-telepon-darurat').val(data.telepon_keluarga || '-');
                    $('#detail-alamat-keluarga').text(data.alamat_keluarga || '-');
                    
                    // Tampilkan panel detail
                    $('#detail-lengkap-pasien').slideDown();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading patient details:", error);
                alert('Gagal memuat data detail pasien. Silakan coba lagi.');
            }
        });
    }
    
    // Fungsi untuk memuat data pasien ke dalam tabel
    function loadPasienData(page = 1) {
        var search = $('#search-pasien').val();
        
        $.ajax({
            url: '<?= base_url('pasien/get_pasien_json'); ?>',
            type: 'post',
            data: {
                search: search,
                page: page
            },
            dataType: 'json',
            beforeSend: function() {
                $('#table-pasien tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#table-pasien tbody').empty();
                
                if(response.data && response.data.length > 0) {
                    $.each(response.data, function(key, value) {
                        var row = '<tr class="pilih-pasien" data-id="' + value.id_pasien + '" data-dismiss="modal" style="cursor:pointer">' +
                                 '<td>' + value.no_rm + '</td>' +
                                 '<td>' + value.nama_lengkap + '</td>' +
                                 '<td>' + value.tgl_lahir + '</td>' +
                                 '<td>' + value.jenis_kelamin + '</td>' +
                                 '<td>' + value.tipe_pasien + '</td>' +
                                 '<td>' + value.telepon + '</td>' +
                                 '<td>' + value.alamat + '</td>' +
                                 '</tr>';
                        $('#table-pasien tbody').append(row);
                    });
                    
                    // Generate pagination
                    renderPagination(response.total_page, page);
                } else {
                    $('#table-pasien tbody').html('<tr><td colspan="7" class="text-center">Tidak ada data yang ditemukan</td></tr>');
                    $('#pagination-pasien').empty();
                }
                
                // Event klik pada baris pasien
                $('.pilih-pasien').click(function() {
                    var id = $(this).data('id');
                    getPasienDetail(id);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error loading patients:", error);
                $('#table-pasien tbody').html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
            }
        });
    }
    
    // Fungsi untuk membuat pagination
    function renderPagination(totalPage, currentPage) {
        $('#pagination-pasien').empty();
        
        // Previous button
        var prevDisabled = (currentPage == 1) ? 'disabled' : '';
        var prevPage = currentPage - 1;
        var prevBtn = '<li class="page-item ' + prevDisabled + '">' +
                      '<a class="page-link page-nav" href="#" data-page="' + prevPage + '">Previous</a>' +
                      '</li>';
        $('#pagination-pasien').append(prevBtn);
        
        // Page numbers
        for(var i = 1; i <= totalPage; i++) {
            var activeClass = (i == currentPage) ? 'active' : '';
            var pageBtn = '<li class="page-item ' + activeClass + '">' +
                          '<a class="page-link page-number" href="#" data-page="' + i + '">' + i + '</a>' +
                          '</li>';
            $('#pagination-pasien').append(pageBtn);
        }
        
        // Next button
        var nextDisabled = (currentPage == totalPage) ? 'disabled' : '';
        var nextPage = parseInt(currentPage) + 1;
        var nextBtn = '<li class="page-item ' + nextDisabled + '">' +
                      '<a class="page-link page-nav" href="#" data-page="' + nextPage + '">Next</a>' +
                      '</li>';
        $('#pagination-pasien').append(nextBtn);
        
        // Event klik pada pagination
        $('.page-number, .page-nav').click(function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if(!$(this).parent().hasClass('disabled') && page != currentPage) {
                loadPasienData(page);
            }
        });
    }
    
    // Fungsi untuk mengambil detail pasien
    function getPasienDetail(id_pasien) {
        $.ajax({
            url: '<?= base_url('pasien/get_detail_json'); ?>',
            type: 'post',
            data: {
                id_pasien: id_pasien
            },
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    // Set value pada form
                    $('#id_pasien').val(response.data.id_pasien);
                    $('#nama_pasien').val(response.data.nama_lengkap);
                    
                    // Tampilkan detail pasien
                    $('#no_rm').val(response.data.no_rm);
                    $('#jenis_kelamin').val(response.data.jenis_kelamin);
                    $('#tgl_lahir').val(response.data.tgl_lahir);
                    $('#telepon').val(response.data.telepon);
                    $('#alamat').val(response.data.alamat);
                    $('#terakhir_berobat').val(response.terakhir_berobat || '-');
                    
                    // Tampilkan info pasien
                    $('#info-pasien').show();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading patient details:", error);
            }
        });
    }

    // ===== POLY AND DOCTOR SEARCH FUNCTIONS =====
    // Event klik pada tombol cari poliklinik
    $('#btn-cari-poli').click(function() {
        $('#search-poli').val('');
        $('#modal-lookup-poli').modal('show');
    });
    
    // Event search pada modal poliklinik
    $('#btn-search-poli').keyup(function() {
        var value = $(this).val().toLowerCase();
        $("#table-poli tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    // Event klik pada baris poliklinik
    $('.pilih-poli').click(function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        $('#id_poliklinik').val(id);
        // Trigger change event untuk memuat dokter
        $('#id_poliklinik').trigger('change');
    });
    
    // Event klik pada tombol cari dokter
    $('#btn-cari-dokter').click(function() {
        var id_poliklinik = $('#id_poliklinik').val();
        var tanggal = $('#tanggal').val();
        
        if(!id_poliklinik) {
            alert('Pilih poliklinik terlebih dahulu');
            return;
        }
        
        loadDokterData(id_poliklinik, tanggal);
        $('#modal-lookup-dokter').modal('show');
    });
    
    // Fungsi untuk memuat data dokter berdasarkan poliklinik
    function loadDokterData(id_poliklinik, tanggal) {
        $.ajax({
            url: '<?= base_url('dokter/get_dokter_by_poli'); ?>',
            type: 'post',
            data: {
                id_poliklinik: id_poliklinik,
                tanggal: tanggal
            },
            dataType: 'json',
            beforeSend: function() {
                $('#table-dokter tbody').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
            },
            success: function(response) {
                $('#table-dokter tbody').empty();
                
                if(response && response.length > 0) {
                    $.each(response, function(key, value) {
                        var status = value.has_jadwal ? '<span class="badge badge-success">Ada Jadwal</span>' : '<span class="badge badge-warning">Tidak Ada Jadwal</span>';
                        var jadwal = value.jadwal ? value.jadwal : '-';
                        
                        var row = '<tr class="pilih-dokter" data-id="' + value.id_dokter + '" data-nama="' + value.nama + '" data-dismiss="modal" style="cursor:pointer">' +
                                 '<td>' + value.id_dokter + '</td>' +
                                 '<td>' + value.nama + '</td>' +
                                 '<td>' + value.spesialis + '</td>' +
                                 '<td>' + jadwal + '</td>' +
                                 '<td>' + status + '</td>' +
                                 '</tr>';
                        $('#table-dokter tbody').append(row);
                    });
                } else {
                    $('#table-dokter tbody').html('<tr><td colspan="5" class="text-center">Tidak ada dokter yang tersedia</td></tr>');
                }
                
                // Event klik pada baris dokter
                $('.pilih-dokter').click(function() {
                    var id = $(this).data('id');
                    var nama = $(this).data('nama');
                    
                    // Set nilai ke form
                    $('#id_dokter').val(id);
                    // Jika menggunakan select2 atau custom dropdown
                    if ($('#id_dokter').is('select')) {
                        $('#id_dokter option').filter(function() {
                            return $(this).val() == id;
                        }).prop('selected', true);
                    }
                    
                    // Trigger change event untuk memuat jadwal
                    $('#id_dokter').trigger('change');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error loading doctors:", error);
                $('#table-dokter tbody').html('<tr><td colspan="5" class="text-center">Error loading data</td></tr>');
            }
        });
    }

    // ===== SCHEDULING AND OTHER FUNCTIONS =====
    // Load dokter berdasarkan poliklinik yang dipilih
    $('#id_poliklinik').change(function() {
        var id_poliklinik = $(this).val();
        var tanggal = $('#tanggal').val();
        
        if(id_poliklinik) {
            $.ajax({
                url: '<?= base_url('dokter/get_dokter_by_poli'); ?>',
                type: 'post',
                data: {
                    id_poliklinik: id_poliklinik,
                    tanggal: tanggal
                },
                dataType: 'json',
                success: function(response) {
                    $('#id_dokter').empty();
                    $('#id_dokter').append('<option value="">-- Pilih Dokter --</option>');
                    
                    $.each(response, function(key, value) {
                        // Tambahkan class untuk menandai dokter dengan jadwal
                        var optionClass = value.has_jadwal ? 'text-success' : 'text-warning';
                        $('#id_dokter').append('<option value="' + value.id_dokter + '" class="' + optionClass + '">' + value.nama + '</option>');
                    });
                    
                    // Reset jadwal
                    $('#jadwal-dokter-container').hide();
                    $('#id_jadwal').empty();
                    $('#jadwal-info').hide();
                },
                error: function(xhr, status, error) {
                    console.error("Error loading doctors by poly:", error);
                    $('#id_dokter').empty();
                    $('#id_dokter').append('<option value="">-- Error loading data --</option>');
                }
            });
        } else {
            $('#id_dokter').empty();
            $('#id_dokter').append('<option value="">-- Pilih Dokter --</option>');
            
            // Reset jadwal
            $('#jadwal-dokter-container').hide();
            $('#id_jadwal').empty();
            $('#jadwal-info').hide();
        }
    });
    
    // Load jadwal berdasarkan dokter yang dipilih
    $('#id_dokter').change(function() {
        var id_dokter = $(this).val();
        var id_poliklinik = $('#id_poliklinik').val();
        var tanggal = $('#tanggal').val();
        
        if(id_dokter) {
            $.ajax({
                url: '<?= base_url('dokter/get_jadwal_dokter'); ?>',
                type: 'post',
                data: {
                    id_dokter: id_dokter,
                    id_poliklinik: id_poliklinik,
                    tanggal: tanggal
                },
                dataType: 'json',
                success: function(response) {
                    $('#id_jadwal').empty();
                    $('#id_jadwal').append('<option value="">-- Pilih Jam Praktek --</option>');
                    
                    if(response && response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#id_jadwal').append('<option value="' + value.id_jadwal + '" data-jam="' + value.jam_mulai + ' - ' + value.jam_selesai + '" data-section="' + value.section + '">' + value.jam_mulai + ' - ' + value.jam_selesai + '</option>');
                        });
                        
                        // Tampilkan dropdown jadwal
                        $('#jadwal-dokter-container').show();
                    } else {
                        // Jika tidak ada jadwal, sembunyikan dropdown
                        $('#jadwal-dokter-container').hide();
                    }
                    
                    // Reset info jadwal
                    $('#jadwal-info').hide();
                },
                error: function(xhr, status, error) {
                    console.error("Error loading doctor schedule:", error);
                    $('#jadwal-dokter-container').hide();
                }
            });
        } else {
            // Reset jadwal
            $('#jadwal-dokter-container').hide();
            $('#id_jadwal').empty();
            $('#jadwal-info').hide();
        }
    });
    
    // Tampilkan info jadwal ketika jadwal dipilih
    $('#id_jadwal').change(function() {
        var selected = $(this).find('option:selected');
        var jam = selected.data('jam');
        var section = selected.data('section');
        var dokter = $('#id_dokter option:selected').text();
        
        if($(this).val()) {
            $('#jadwal-section').html('<strong>Section:</strong> ' + section);
            $('#jadwal-dokter').html('<strong>Dokter:</strong> ' + dokter);
            $('#jadwal-jam').html('<strong>Jam Praktek:</strong> ' + jam);
            $('#jadwal-info').show();
        } else {
            $('#jadwal-info').hide();
        }
    });
    
    // Update dokter jika tanggal berubah
    $('#tanggal').change(function() {
        $('#id_poliklinik').trigger('change');
        
        // Reset jadwal
        $('#jadwal-dokter-container').hide();
        $('#id_jadwal').empty();
        $('#jadwal-info').hide();
    });

    // CSS untuk styling
    $("<style>")
        .prop("type", "text/css")
        .html(`
        .jadwal-slot.selected-slot {
            box-shadow: 0 0 0 3px #007bff;
            position: relative;
            z-index: 1;
        }
        .jadwal-slot:hover {
            opacity: 0.8;
        }
        `)
        .appendTo("head");

    // Menampilkan nomor antrian setelah memilih dokter
    $('#id_dokter').on('change', function() {
        console.log("Dokter changed:", $(this).val(), $('#id_poliklinik').val(), $('#tanggal').val());
        if ($(this).val() && $('#id_poliklinik').val() && $('#tanggal').val()) {
            getEstimatedQueueNumber();
        }
    });

    $('#id_poliklinik').on('change', function() {
        console.log("Poliklinik changed:", $(this).val(), $('#id_dokter').val(), $('#tanggal').val());
        if ($(this).val() && $('#id_dokter').val() && $('#tanggal').val()) {
            getEstimatedQueueNumber();
        }
    });

    $('#tanggal').on('change', function() {
        console.log("Tanggal changed:", $(this).val(), $('#id_poliklinik').val(), $('#id_dokter').val());
        if ($('#id_poliklinik').val() && $('#id_dokter').val() && $(this).val()) {
            getEstimatedQueueNumber();
        }
    });

    // Fungsi untuk mengambil estimasi nomor antrian
    function getEstimatedQueueNumber() {
        var data = {
            id_poli: $('#id_poliklinik').val(),
            id_dokter: $('#id_dokter').val(),
            tanggal: $('#tanggal').val()
        };
        
        console.log("Sending data to server:", data);
        
        $.ajax({
            url: '<?= base_url('kunjungan/get_estimasi_nomor_antrian') ?>',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log("Server response:", response);
                if (response.success) {
                    $('#preview_nomor_antrian').val(response.nomor_antrian);
                } else {
                    $('#preview_nomor_antrian').val('--');
                    console.error('Error: ' + (response.message || 'Gagal memperoleh nomor antrian'));
                }
            },
            error: function(xhr, status, error) {
                $('#preview_nomor_antrian').val('--');
                console.error('AJAX Error: ' + error);
                
                // Coba tampilkan nomor antrian dengan format dasar jika gagal
                var poliId = $('#id_poliklinik :selected').text().substring(0, 3).toUpperCase();
                var urutan = "001";
                if (poliId) {
                    var nomorAntrian = poliId + '-' + urutan;
                    $('#preview_nomor_antrian').val(nomorAntrian);
                }
            }
        });
    }
});
</script> 