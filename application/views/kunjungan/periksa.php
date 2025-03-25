<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-stethoscope"></i> Pemeriksaan Pasien
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('kunjungan/antrian'); ?>">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Daftar Antrian
                            </a>
                            <a class="dropdown-item" href="<?= base_url('kunjungan'); ?>">
                                <i class="fas fa-clipboard-list fa-sm fa-fw mr-2 text-gray-400"></i> Daftar Kunjungan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('pasien/detail/'.$antrian->id_pasien); ?>" target="_blank">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Detail Pasien
                            </a>
                            <a class="dropdown-item" href="<?= base_url('rekam_medis/riwayat/'.$antrian->id_pasien); ?>" target="_blank">
                                <i class="fas fa-notes-medical fa-sm fa-fw mr-2 text-gray-400"></i> Riwayat Medis
                            </a>
                        </div>
                    </div>
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
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-left-primary">
                                <div class="card-body py-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pasien</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $antrian->nama_pasien; ?></div>
                                            <div class="text-xs text-muted"><?= $pasien->no_identitas ?? '-'; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-success">
                                <div class="card-body py-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Antrian</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $antrian->no_antrian; ?></div>
                                            <div class="text-xs text-muted"><?= date('d F Y', strtotime($antrian->tanggal)); ?> - <?= $antrian->nama_poli; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?= form_open('kunjungan/periksa/'.$antrian->id_antrian); ?>
                        <!-- Tabs untuk pemeriksaan -->
                        <ul class="nav nav-tabs" id="pemeriksaanTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="umum-tab" data-toggle="tab" href="#umum" role="tab" aria-controls="umum" aria-selected="true">Pemeriksaan Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="diagnosa-tab" data-toggle="tab" href="#diagnosa" role="tab" aria-controls="diagnosa" aria-selected="false">Diagnosa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tindakan-tab" data-toggle="tab" href="#tindakan" role="tab" aria-controls="tindakan" aria-selected="false">Tindakan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resep-tab" data-toggle="tab" href="#resep" role="tab" aria-controls="resep" aria-selected="false">Resep Obat</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="pemeriksaanTabContent">
                            <!-- Tab Pemeriksaan Umum -->
                            <div class="tab-pane fade show active p-3" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                                            <select class="form-control" id="id_dokter" name="id_dokter" required>
                                                <option value="">-- Pilih Dokter --</option>
                                                <?php foreach($dokter as $d): ?>
                                                    <option value="<?= $d->id_dokter; ?>" <?= ($antrian->id_dokter == $d->id_dokter) ? 'selected' : ''; ?>>
                                                        <?= $d->nama_lengkap; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('id_dokter', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="keluhan">Keluhan Utama <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required><?= set_value('keluhan'); ?></textarea>
                                            <?= form_error('keluhan', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="riwayat_penyakit">Riwayat Penyakit</label>
                                            <textarea class="form-control" id="riwayat_penyakit" name="riwayat_penyakit" rows="3"><?= set_value('riwayat_penyakit'); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tekanan_darah">Tekanan Darah (mmHg)</label>
                                                    <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="<?= set_value('tekanan_darah'); ?>" placeholder="120/80">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="suhu_tubuh">Suhu Tubuh (°C)</label>
                                                    <input type="text" class="form-control" id="suhu_tubuh" name="suhu_tubuh" value="<?= set_value('suhu_tubuh'); ?>" placeholder="36.5">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="berat_badan">Berat Badan (kg)</label>
                                                    <input type="text" class="form-control" id="berat_badan" name="berat_badan" value="<?= set_value('berat_badan'); ?>" placeholder="65">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                                    <input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" value="<?= set_value('tinggi_badan'); ?>" placeholder="170">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="pemeriksaan_fisik">Pemeriksaan Fisik</label>
                                            <textarea class="form-control" id="pemeriksaan_fisik" name="pemeriksaan_fisik" rows="3"><?= set_value('pemeriksaan_fisik'); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tab Diagnosa -->
                            <div class="tab-pane fade p-3" id="diagnosa" role="tabpanel" aria-labelledby="diagnosa-tab">
                                <div class="form-group">
                                    <label for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3" required><?= set_value('diagnosa'); ?></textarea>
                                    <?= form_error('diagnosa', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="kode_icd">Kode ICD</label>
                                    <select class="form-control select2" id="kode_icd" name="kode_icd">
                                        <option value="">-- Pilih Kode ICD --</option>
                                        <?php foreach($icd as $i): ?>
                                            <option value="<?= $i->kode; ?>">
                                                <?= $i->kode; ?> - <?= $i->nama; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="catatan_tambahan">Catatan Tambahan</label>
                                    <textarea class="form-control" id="catatan_tambahan" name="catatan_tambahan" rows="3"><?= set_value('catatan_tambahan'); ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Tab Tindakan -->
                            <div class="tab-pane fade p-3" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabelTindakan">
                                        <thead>
                                            <tr>
                                                <th width="50%">Nama Tindakan</th>
                                                <th width="30%">Biaya</th>
                                                <th width="20%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control select2 tindakan-select" name="tindakan[]">
                                                        <option value="">-- Pilih Tindakan --</option>
                                                        <?php foreach($tindakan as $t): ?>
                                                            <option value="<?= $t->id_tindakan_master; ?>" data-biaya="<?= $t->tarif; ?>">
                                                                <?= $t->nama_tindakan; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control biaya-tindakan" name="biaya_tindakan[]" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm hapus-tindakan">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="button" class="btn btn-primary btn-sm" id="tambahTindakan">
                                                        <i class="fas fa-plus"></i> Tambah Tindakan
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pemeriksaan
                            </button>
                            <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Select2 dan dynamic fields -->
<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
    
    // Menampilkan biaya tindakan saat dipilih
    $(document).on('change', '.tindakan-select', function() {
        var biaya = $(this).find(':selected').data('biaya') || '';
        $(this).closest('tr').find('.biaya-tindakan').val(biaya);
    });
    
    // Inisialisasi nilai biaya untuk tindakan yang sudah dipilih
    $('.tindakan-select').each(function() {
        var biaya = $(this).find(':selected').data('biaya') || '';
        $(this).closest('tr').find('.biaya-tindakan').val(biaya);
    });
    
    // Ulangi inisialisasi Select2 setelah DOM ready
    setTimeout(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    }, 500);
    
    // Tambah baris tindakan
    $('#tambahTindakan').click(function() {
        var row = '<tr>' +
            '<td>' +
                '<select class="form-control select2 tindakan-select" name="tindakan[]">' +
                    '<option value="">-- Pilih Tindakan --</option>' +
                    <?php foreach($tindakan as $t): ?>
                    '<option value="<?= $t->id_tindakan_master; ?>" data-biaya="<?= $t->tarif; ?>">' +
                        '<?= $t->nama_tindakan; ?>' +
                    '</option>' +
                    <?php endforeach; ?>
                '</select>' +
            '</td>' +
            '<td>' +
                '<input type="text" class="form-control biaya-tindakan" name="biaya_tindakan[]" readonly>' +
            '</td>' +
            '<td>' +
                '<button type="button" class="btn btn-danger btn-sm hapus-tindakan">' +
                    '<i class="fas fa-trash"></i>' +
                '</button>' +
            '</td>' +
        '</tr>';
        
        $('#tabelTindakan tbody').append(row);
        
        // Re-initialize select2 for new row
        setTimeout(function() {
            $('#tabelTindakan').find('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        }, 100);
    });
    
    // Hapus baris tindakan
    $(document).on('click', '.hapus-tindakan', function() {
        if ($('#tabelTindakan tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('Minimal harus ada satu baris tindakan');
        }
    });
});
</script> 