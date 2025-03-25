<?php // Hapus komentar load header ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-plus mr-1"></i> Tambah Jadwal Praktek Dokter
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
                    
                    <form action="<?= base_url('jadwal/tambah_multiple') ?>" method="post" id="form-jadwal">
                        <div class="form-group row">
                            <label for="id_dokter" class="col-sm-2 col-form-label">Dokter</label>
                            <div class="col-sm-10">
                                <select name="id_dokter" id="id_dokter" class="form-control select2" required>
                                    <option value="">- Pilih Dokter -</option>
                                    <?php foreach ($dokter as $row) : ?>
                                        <option value="<?= $row['id_dokter'] ?>"><?= $row['nama_dokter'] ?> - <?= $row['spesialis'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_poli" class="col-sm-2 col-form-label">Poliklinik</label>
                            <div class="col-sm-10">
                                <select name="id_poli" id="id_poli" class="form-control select2" required>
                                    <option value="">- Pilih Poliklinik -</option>
                                    <?php foreach ($poli as $row) : ?>
                                        <option value="<?= $row['id_poli'] ?>"><?= $row['nama_poli'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Jadwal dokter yang sudah ada (ditampilkan jika dokter dipilih) -->
                        <div id="jadwal-dokter-container" class="mb-4 d-none">
                            <div class="card">
                                <div class="card-header py-3 bg-info text-white">
                                    <h6 class="m-0 font-weight-bold">Jadwal Praktek Dokter yang Sudah Ada</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam</th>
                                                    <th>Poliklinik</th>
                                                </tr>
                                            </thead>
                                            <tbody id="jadwal-dokter-list">
                                                <!-- Data jadwal akan dimuat melalui AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3 font-weight-bold text-primary">Jadwal Praktik</h5>

                        <div id="jadwal-container">
                            <!-- Template untuk jadwal pertama -->
                            <div class="jadwal-item mb-4" data-index="0">
                                <div class="card">
                                    <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold">Jadwal #1</h6>
                                        <button type="button" class="btn btn-sm btn-danger btn-hapus-jadwal d-none">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Hari</label>
                                            <div class="col-sm-10">
                                                <select name="jadwal[0][hari]" class="form-control hari-select" required>
                                                    <option value="">- Pilih Hari -</option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Jam Mulai</label>
                                            <div class="col-sm-4">
                                                <input type="time" name="jadwal[0][jam_mulai]" class="form-control jam-mulai" required>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Jam Selesai</label>
                                            <div class="col-sm-4">
                                                <input type="time" name="jadwal[0][jam_selesai]" class="form-control jam-selesai" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Kuota Pasien</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="jadwal[0][kuota_pasien]" class="form-control" value="10" min="1" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="jadwal[0][keterangan]" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" id="btn-add-jadwal" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Jadwal Lain
                            </button>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                                <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">Kembali</a>
                            </div>
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
        
        // Counter untuk index jadwal
        var jadwalIndex = 0;
        
        // Fungsi untuk menambahkan jadwal baru
        $('#btn-add-jadwal').on('click', function() {
            jadwalIndex++;
            
            // Clone template jadwal pertama
            var newJadwal = $('.jadwal-item:first').clone();
            
            // Update index, judul, dan bersihkan nilai
            newJadwal.attr('data-index', jadwalIndex);
            newJadwal.find('h6').text('Jadwal #' + (jadwalIndex + 1));
            
            // Hapus pesan error jika ada
            newJadwal.find('.jadwal-error').remove();
            
            // Update nama field dengan index baru
            newJadwal.find('.hari-select').attr('name', 'jadwal[' + jadwalIndex + '][hari]').val('');
            newJadwal.find('.jam-mulai').attr('name', 'jadwal[' + jadwalIndex + '][jam_mulai]').val('');
            newJadwal.find('.jam-selesai').attr('name', 'jadwal[' + jadwalIndex + '][jam_selesai]').val('');
            newJadwal.find('input[type="number"]').attr('name', 'jadwal[' + jadwalIndex + '][kuota_pasien]').val('10');
            newJadwal.find('textarea').attr('name', 'jadwal[' + jadwalIndex + '][keterangan]').val('');
            
            // Tampilkan tombol hapus
            newJadwal.find('.btn-hapus-jadwal').removeClass('d-none');
            
            // Tambahkan jadwal baru ke container
            $('#jadwal-container').append(newJadwal);
            
            // Jika ini jadwal kedua, tampilkan tombol hapus pada jadwal pertama juga
            if (jadwalIndex === 1) {
                $('.jadwal-item:first').find('.btn-hapus-jadwal').removeClass('d-none');
            }
            
            // Pasang kembali event handler untuk validasi jam
            attachTimeValidation();
            
            // Pasang event handler untuk validasi jadwal
            attachScheduleValidation();
        });
        
        // Fungsi untuk menghapus jadwal (event delegation)
        $('#jadwal-container').on('click', '.btn-hapus-jadwal', function() {
            $(this).closest('.jadwal-item').remove();
            
            // Re-index jadwal items dan update nomor urut
            $('.jadwal-item').each(function(idx) {
                $(this).attr('data-index', idx);
                $(this).find('h6').text('Jadwal #' + (idx + 1));
                
                // Update nama field dengan index baru
                $(this).find('.hari-select').attr('name', 'jadwal[' + idx + '][hari]');
                $(this).find('.jam-mulai').attr('name', 'jadwal[' + idx + '][jam_mulai]');
                $(this).find('.jam-selesai').attr('name', 'jadwal[' + idx + '][jam_selesai]');
                $(this).find('input[type="number"]').attr('name', 'jadwal[' + idx + '][kuota_pasien]');
                $(this).find('textarea').attr('name', 'jadwal[' + idx + '][keterangan]');
            });
            
            // Jika hanya tersisa 1 jadwal, sembunyikan tombol hapus
            if ($('.jadwal-item').length === 1) {
                $('.jadwal-item:first').find('.btn-hapus-jadwal').addClass('d-none');
            }
            
            // Reset jadwalIndex
            jadwalIndex = $('.jadwal-item').length - 1;
        });
        
        // Fungsi untuk attach validasi jam
        function attachTimeValidation() {
            // Hapus event handler lama
            $('.jam-selesai, .jam-mulai').off('change');
            
            // Validasi jam selesai > jam mulai
            $('.jadwal-item').each(function() {
                var item = $(this);
                var jamMulai = item.find('.jam-mulai');
                var jamSelesai = item.find('.jam-selesai');
                
                jamMulai.on('change', function() {
                    validateScheduleTime(item);
                });
                
                jamSelesai.on('change', function() {
                    validateScheduleTime(item);
                });
            });
        }
        
        // Fungsi untuk attach validasi jadwal
        function attachScheduleValidation() {
            // Hapus event handler lama
            $('.hari-select').off('change');
            
            // Validasi saat hari berubah
            $('.jadwal-item').each(function() {
                var item = $(this);
                var hariSelect = item.find('.hari-select');
                
                hariSelect.on('change', function() {
                    validateSchedule(item);
                });
            });
        }
        
        // Validasi jadwal berdasarkan hari, jam mulai, dan jam selesai
        function validateSchedule(item) {
            var id_dokter = $('#id_dokter').val();
            var hari = item.find('.hari-select').val();
            var jam_mulai = item.find('.jam-mulai').val();
            var jam_selesai = item.find('.jam-selesai').val();
            var index = item.attr('data-index');
            
            // Hapus pesan error yang sudah ada
            item.find('.jadwal-error').remove();
            
            // Validasi input
            if (!id_dokter || !hari || !jam_mulai || !jam_selesai) {
                return; // Tidak cukup data untuk validasi
            }
            
            // Ajax request untuk cek bentrok
            $.ajax({
                url: '<?= base_url('jadwal/check_conflict_ajax') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_dokter: id_dokter,
                    hari: hari,
                    jam_mulai: jam_mulai,
                    jam_selesai: jam_selesai
                },
                success: function(response) {
                    if (!response.status) {
                        // Tambahkan pesan error
                        var errorDiv = $('<div class="alert alert-danger mt-2 jadwal-error">' + response.message + '</div>');
                        item.find('.card-body').append(errorDiv);
                    }
                },
                error: function() {
                    console.error('Gagal melakukan validasi jadwal');
                }
            });
        }
        
        // Validasi waktu jadwal (jam mulai & jam selesai)
        function validateScheduleTime(item) {
            var jam_mulai = item.find('.jam-mulai').val();
            var jam_selesai = item.find('.jam-selesai').val();
            
            // Hapus pesan error jam yang sudah ada
            item.find('.time-error').remove();
            
            // Validasi jam mulai dan jam selesai
            if (jam_mulai && jam_selesai) {
                if (jam_mulai >= jam_selesai) {
                    var errorDiv = $('<div class="alert alert-danger mt-2 time-error jadwal-error">Jam mulai harus lebih awal dari jam selesai</div>');
                    item.find('.card-body').append(errorDiv);
                    return false;
                } else {
                    // Jika waktu valid, lakukan validasi jadwal
                    validateSchedule(item);
                    return true;
                }
            }
            return true;
        }
        
        // Saat dokter berubah, muat jadwal yang sudah ada
        $('#id_dokter').on('change', function() {
            var id_dokter = $(this).val();
            
            if (id_dokter) {
                // Load jadwal dokter
                $.ajax({
                    url: '<?= base_url('jadwal/get_jadwal_dokter') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_dokter: id_dokter
                    },
                    success: function(response) {
                        if (response && response.length > 0) {
                            var html = '';
                            $.each(response, function(index, jadwal) {
                                html += '<tr>';
                                html += '<td>' + jadwal.hari + '</td>';
                                html += '<td>' + jadwal.jam_mulai + ' - ' + jadwal.jam_selesai + '</td>';
                                html += '<td>' + jadwal.nama_poli + '</td>';
                                html += '</tr>';
                            });
                            $('#jadwal-dokter-list').html(html);
                            $('#jadwal-dokter-container').removeClass('d-none');
                        } else {
                            $('#jadwal-dokter-list').html('<tr><td colspan="3" class="text-center">Tidak ada jadwal</td></tr>');
                            $('#jadwal-dokter-container').removeClass('d-none');
                        }
                    },
                    error: function() {
                        console.error('Gagal memuat jadwal dokter');
                    }
                });
            } else {
                $('#jadwal-dokter-container').addClass('d-none');
            }
        });
        
        // Panggil fungsi attach saat pertama kali load
        attachTimeValidation();
        attachScheduleValidation();
    });
</script>

<?php // Hapus load footer ?> 