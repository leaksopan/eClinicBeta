<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list"></i> Detail Kunjungan
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('kunjungan'); ?>">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Daftar Kunjungan
                            </a>
                            <?php if($rekam_medis->status == 'aktif'): ?>
                                <a class="dropdown-item" href="<?= base_url('kunjungan/edit/'.$rekam_medis->id_kunjungan); ?>">
                                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i> Edit Kunjungan
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('pasien/detail/'.$rekam_medis->id_pasien); ?>" target="_blank">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Detail Pasien
                            </a>
                            <a class="dropdown-item" href="<?= base_url('rekam_medis/riwayat/'.$rekam_medis->id_pasien); ?>" target="_blank">
                                <i class="fas fa-notes-medical fa-sm fa-fw mr-2 text-gray-400"></i> Riwayat Medis
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('kunjungan/cetak/'.$rekam_medis->id_kunjungan); ?>" target="_blank">
                                <i class="fas fa-print fa-sm fa-fw mr-2 text-gray-400"></i> Cetak Resume
                            </a>
                            <a class="dropdown-item" href="<?= base_url('kunjungan/cetak_resep/'.$rekam_medis->id_kunjungan); ?>" target="_blank">
                                <i class="fas fa-prescription fa-sm fa-fw mr-2 text-gray-400"></i> Cetak Resep
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-left-primary">
                                <div class="card-body py-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pasien</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rekam_medis->nama_pasien; ?></div>
                                            <div class="text-xs text-muted">
                                                No. RM: <?= $rekam_medis->no_rekam_medis; ?> <br>
                                                <?= $rekam_medis->no_identitas; ?> <br>
                                                <?= $rekam_medis->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>, <?= $rekam_medis->umur; ?> tahun
                                            </div>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kunjungan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= date('d F Y', strtotime($rekam_medis->tanggal)); ?>
                                            </div>
                                            <div class="text-xs text-muted">
                                                No. Kunjungan: <?= $rekam_medis->no_kunjungan; ?> <br>
                                                Poliklinik: <?= $rekam_medis->nama_poli; ?> <br>
                                                Dokter: <?= $rekam_medis->nama_dokter; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabs untuk detail -->
                    <ul class="nav nav-tabs" id="detailTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pemeriksaan-tab" data-toggle="tab" href="#pemeriksaan" role="tab" aria-controls="pemeriksaan" aria-selected="true">Pemeriksaan</a>
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
                    
                    <div class="tab-content" id="detailTabContent">
                        <!-- Tab Pemeriksaan -->
                        <div class="tab-pane fade show active p-3" id="pemeriksaan" role="tabpanel" aria-labelledby="pemeriksaan-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="m-0 font-weight-bold text-primary">Keluhan & Riwayat</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <h6 class="font-weight-bold">Keluhan Utama:</h6>
                                                <p><?= nl2br($rekam_medis->keluhan); ?></p>
                                            </div>
                                            
                                            <?php if(!empty($rekam_medis->riwayat_penyakit)): ?>
                                            <div>
                                                <h6 class="font-weight-bold">Riwayat Penyakit:</h6>
                                                <p><?= nl2br($rekam_medis->riwayat_penyakit); ?></p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Fisik</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <span class="font-weight-bold">Tekanan Darah:</span> 
                                                        <?= !empty($rekam_medis->tekanan_darah) ? $rekam_medis->tekanan_darah . ' mmHg' : '-'; ?>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="font-weight-bold">Suhu Tubuh:</span> 
                                                        <?= !empty($rekam_medis->suhu_tubuh) ? $rekam_medis->suhu_tubuh . ' °C' : '-'; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <span class="font-weight-bold">Berat Badan:</span> 
                                                        <?= !empty($rekam_medis->berat_badan) ? $rekam_medis->berat_badan . ' kg' : '-'; ?>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="font-weight-bold">Tinggi Badan:</span> 
                                                        <?= !empty($rekam_medis->tinggi_badan) ? $rekam_medis->tinggi_badan . ' cm' : '-'; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php if(!empty($rekam_medis->pemeriksaan_fisik)): ?>
                                            <div class="mt-3">
                                                <h6 class="font-weight-bold">Catatan Pemeriksaan:</h6>
                                                <p><?= nl2br($rekam_medis->pemeriksaan_fisik); ?></p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab Diagnosa -->
                        <div class="tab-pane fade p-3" id="diagnosa" role="tabpanel" aria-labelledby="diagnosa-tab">
                            <div class="card mb-3">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Hasil Diagnosa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="font-weight-bold">Diagnosa:</h6>
                                        <p><?= nl2br($rekam_medis->diagnosa); ?></p>
                                    </div>
                                    
                                    <?php if(!empty($rekam_medis->kode_icd)): ?>
                                    <div class="mb-3">
                                        <h6 class="font-weight-bold">Kode ICD:</h6>
                                        <p><?= $rekam_medis->kode_icd; ?> - <?= $rekam_medis->nama_icd; ?></p>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($rekam_medis->catatan_tambahan)): ?>
                                    <div>
                                        <h6 class="font-weight-bold">Catatan Tambahan:</h6>
                                        <p><?= nl2br($rekam_medis->catatan_tambahan); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab Tindakan -->
                        <div class="tab-pane fade p-3" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                            <?php if(!empty($tindakan)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="65%">Nama Tindakan</th>
                                                <th width="30%">Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; $total_biaya = 0; foreach($tindakan as $tindak): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $tindak->nama_tindakan; ?></td>
                                                    <td>Rp <?= number_format($tindak->biaya, 0, ',', '.'); ?></td>
                                                </tr>
                                                <?php $total_biaya += $tindak->biaya; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light">
                                                <th colspan="2" class="text-right">Total Biaya Tindakan:</th>
                                                <th>Rp <?= number_format($total_biaya, 0, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Tidak ada tindakan yang dilakukan.
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tab Resep Obat -->
                        <div class="tab-pane fade p-3" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                            <?php if(!empty($obat)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="40%">Nama Obat</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="40%">Aturan Pakai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($obat as $o): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $o->nama_obat; ?></td>
                                                    <td><?= $o->jumlah; ?> <?= $o->satuan; ?></td>
                                                    <td><?= $o->aturan_pakai; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Tidak ada resep obat yang diberikan.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="<?= base_url('kunjungan'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        
                        <div class="float-right">
                            <span class="mr-2">
                                Status: 
                                <?php if($rekam_medis->status == 'aktif'): ?>
                                    <span class="badge badge-primary">Aktif</span>
                                <?php elseif($rekam_medis->status == 'selesai'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Batal</span>
                                <?php endif; ?>
                            </span>
                            
                            <?php if($rekam_medis->status == 'aktif'): ?>
                                <a href="<?= base_url('kunjungan/selesai/'.$rekam_medis->id_kunjungan); ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan kunjungan ini?');">
                                    <i class="fas fa-check-circle"></i> Selesaikan
                                </a>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('kunjungan/cetak/'.$rekam_medis->id_kunjungan); ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-print"></i> Cetak Resume
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 