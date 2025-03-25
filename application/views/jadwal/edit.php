<?php //$this->load->view('templates/header', ['title' => $title]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-1"></i> Edit Jadwal Praktek Dokter
                    </h6>
                </div>
                <div class="card-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                            <?= validation_errors() ?>
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
                    
                    <form action="<?= base_url('jadwal/edit/' . $jadwal->id_jadwal) ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                                    <select name="id_dokter" id="id_dokter" class="form-control select2" required>
                                        <option value="">Pilih Dokter</option>
                                        <?php foreach($dokter as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= set_select('id_dokter', $key, ($jadwal->id_dokter == $key)) ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <!-- Jadwal yang sudah ada dari dokter yang dipilih -->
                                <div id="jadwal-dokter-container" class="d-none">
                                    <div class="card border-left-info shadow mb-3">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="m-0 font-weight-bold text-info">Jadwal Praktek Dokter yang Dipilih</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Jam</th>
                                                        <th>Poliklinik</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="jadwal-dokter-list">
                                                    <tr>
                                                        <td colspan="3" class="text-center">Pilih dokter terlebih dahulu</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer bg-light py-1">
                                            <small class="text-muted font-italic">* Jadwal yang sedang diedit ditandai dengan warna berbeda</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="id_poli">Poliklinik <span class="text-danger">*</span></label>
                                    <select name="id_poli" id="id_poli" class="form-control select2" required>
                                        <option value="">Pilih Poliklinik</option>
                                        <?php foreach($poli as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= set_select('id_poli', $key, ($jadwal->id_poli == $key)) ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="hari">Hari <span class="text-danger">*</span></label>
                                    <select name="hari" id="hari" class="form-control" required>
                                        <option value="">Pilih Hari</option>
                                        <?php foreach($hari as $h): ?>
                                            <option value="<?= $h ?>" <?= set_select('hari', $h, ($jadwal->hari == $h)) ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required value="<?= set_value('jam_mulai', $jadwal->jam_mulai) ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required value="<?= set_value('jam_selesai', $jadwal->jam_selesai) ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="kuota_pasien">Kuota Pasien</label>
                                    <input type="number" name="kuota_pasien" id="kuota_pasien" class="form-control" value="<?= set_value('kuota_pasien', $jadwal->kuota_pasien) ?>" min="1">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"><?= set_value('keterangan', $jadwal->keterangan) ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="aktif" <?= set_select('status', 'aktif', ($jadwal->status == 'aktif')) ?>>Aktif</option>
                                        <option value="nonaktif" <?= set_select('status', 'nonaktif', ($jadwal->status == 'nonaktif')) ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Informasi:
                            <ul class="mb-0">
                                <li>Dokter dapat memiliki lebih dari 1 jadwal praktek di hari yang sama dengan jam berbeda.</li>
                                <li>Dokter dapat praktek di beberapa hari dengan jam yang sama atau berbeda.</li>
                                <li>Sistem akan mendeteksi apakah jadwal yang ditambahkan tumpang tindih (overlap) dengan jadwal yang sudah ada.</li>
                            </ul>
                        </div>
                        
                        <div class="form-group text-right">
                            <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        
        // Validasi jam
        $('#jam_selesai').on('change', function() {
            var jamMulai = $('#jam_mulai').val();
            var jamSelesai = $(this).val();
            
            if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
                alert('Jam selesai harus lebih besar dari jam mulai');
                $(this).val('<?= $jadwal->jam_selesai ?>');
            }
        });
        
        $('#jam_mulai').on('change', function() {
            var jamMulai = $(this).val();
            var jamSelesai = $('#jam_selesai').val();
            
            if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
                alert('Jam mulai harus lebih kecil dari jam selesai');
                $(this).val('<?= $jadwal->jam_mulai ?>');
            }
        });
        
        // ID jadwal yang sedang diedit
        var currentJadwalId = <?= $jadwal->id_jadwal ?>;
        
        // Ambil jadwal dokter saat dokter dipilih
        $('#id_dokter').on('change', function() {
            var idDokter = $(this).val();
            
            if (idDokter) {
                $.ajax({
                    url: '<?= base_url('jadwal/get_jadwal_dokter') ?>',
                    type: 'POST',
                    data: {
                        id_dokter: idDokter
                    },
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        
                        if (response.length > 0) {
                            $.each(response, function(index, value) {
                                // Tandai jadwal yang sedang diedit dengan warna berbeda
                                var rowClass = (value.id_jadwal == currentJadwalId) ? 'table-warning' : '';
                                
                                html += '<tr class="' + rowClass + '">';
                                html += '<td>' + value.hari + '</td>';
                                html += '<td>' + value.jam_mulai + ' - ' + value.jam_selesai + '</td>';
                                html += '<td>' + value.nama_poli + '</td>';
                                html += '</tr>';
                            });
                            
                            $('#jadwal-dokter-container').removeClass('d-none');
                        } else {
                            html = '<tr><td colspan="3" class="text-center">Dokter belum memiliki jadwal praktek</td></tr>';
                            $('#jadwal-dokter-container').removeClass('d-none');
                        }
                        
                        $('#jadwal-dokter-list').html(html);
                    },
                    error: function() {
                        $('#jadwal-dokter-list').html('<tr><td colspan="3" class="text-center">Gagal mengambil jadwal</td></tr>');
                        $('#jadwal-dokter-container').removeClass('d-none');
                    }
                });
            } else {
                $('#jadwal-dokter-container').addClass('d-none');
            }
        });
        
        // Jalankan secara otomatis saat halaman dimuat
        $('#id_dokter').trigger('change');
    });
</script>

<?php $this->load->view('templates/footer'); ?> 