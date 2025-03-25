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
                        <div class="form-group">
                            <label for="id_pasien">Pasien <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="id_pasien" name="id_pasien" required>
                                <option value="">-- Pilih Pasien --</option>
                                <?php foreach($pasien as $p): ?>
                                    <option value="<?= $p->id_pasien; ?>">
                                        <?= $p->nama_lengkap; ?> - <?= $p->no_identitas; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_pasien', '<small class="text-danger">', '</small>'); ?>
                            <small class="form-text text-muted">
                                <a href="<?= base_url('pasien/tambah'); ?>" target="_blank">
                                    <i class="fas fa-plus-circle"></i> Tambah Pasien Baru
                                </a>
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_poliklinik">Poliklinik <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_poliklinik" name="id_poliklinik" required>
                                <option value="">-- Pilih Poliklinik --</option>
                                <?php foreach($poliklinik as $poli): ?>
                                    <option value="<?= $poli->id_poli; ?>">
                                        <?= $poli->nama_poli; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_poliklinik', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_dokter">Dokter <small class="text-muted">(Opsional)</small></label>
                            <select class="form-control" id="id_dokter" name="id_dokter">
                                <option value="">-- Pilih Dokter --</option>
                                <!-- Dokter akan dimuat berdasarkan poliklinik yang dipilih (menggunakan AJAX) -->
                            </select>
                            <small class="form-text text-muted">Dokter akan diisi berdasarkan jadwal atau saat pemeriksaan jika tidak dipilih.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= set_value('tanggal', date('Y-m-d')); ?>" required>
                            <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Nomor antrian akan diberikan secara otomatis.
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('kunjungan/antrian'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Select2 dan AJAX -->
<script>
$(document).ready(function() {
    // Inisialisasi Select2 untuk dropdown pasien
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: "Pilih pasien",
        allowClear: true
    });
    
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
                }
            });
        } else {
            $('#id_dokter').empty();
            $('#id_dokter').append('<option value="">-- Pilih Dokter --</option>');
        }
    });
    
    // Update dokter jika tanggal berubah
    $('#tanggal').change(function() {
        $('#id_poliklinik').trigger('change');
    });
});
</script> 