<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Riwayat Kunjungan Pasien
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('kunjungan'); ?>">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Daftar Kunjungan
                            </a>
                            <a class="dropdown-item" href="<?= base_url('kunjungan/tambah_antrian'); ?>">
                                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i> Tambah Antrian
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('pasien/detail/'.$pasien->id_pasien); ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Detail Pasien
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mx-auto">
                            <div class="card border-left-primary mb-3">
                                <div class="card-body py-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-2 text-center">
                                            <i class="fas fa-user-injured fa-3x text-gray-300"></i>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"><?= $pasien->nama_lengkap; ?></div>
                                            <div class="text-sm">
                                                No. RM: <?= $pasien->no_rekam_medis; ?> | 
                                                <?= $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>, <?= $pasien->umur; ?> tahun
                                            </div>
                                            <div class="text-sm text-muted">
                                                <?= $pasien->alamat; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs" id="riwayatTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="kunjungan-tab" data-toggle="tab" href="#kunjungan" role="tab">
                                <i class="fas fa-clipboard-list mr-1"></i> Kunjungan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="diagnosa-tab" data-toggle="tab" href="#diagnosa" role="tab">
                                <i class="fas fa-stethoscope mr-1"></i> Riwayat Diagnosa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tindakan-tab" data-toggle="tab" href="#tindakan" role="tab">
                                <i class="fas fa-procedures mr-1"></i> Riwayat Tindakan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="obat-tab" data-toggle="tab" href="#obat" role="tab">
                                <i class="fas fa-pills mr-1"></i> Riwayat Obat
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3" id="riwayatTabContent">
                        <!-- Tab Riwayat Kunjungan -->
                        <div class="tab-pane fade show active" id="kunjungan" role="tabpanel" aria-labelledby="kunjungan-tab">
                            <?php if(!empty($riwayat)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="15%">No. Kunjungan</th>
                                                <th width="17%">Poliklinik</th>
                                                <th width="17%">Dokter</th>
                                                <th width="25%">Diagnosa</th>
                                                <th width="9%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($riwayat as $r): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($r->tanggal)); ?></td>
                                                    <td><?= $r->no_kunjungan; ?></td>
                                                    <td><?= $r->nama_poli; ?></td>
                                                    <td><?= $r->nama_dokter ?? '-'; ?></td>
                                                    <td><?= $r->diagnosa ?? '<span class="text-muted">Belum ada diagnosa</span>'; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('kunjungan/detail/'.$r->id_kunjungan); ?>" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Belum ada riwayat kunjungan untuk pasien ini.
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tab Riwayat Diagnosa -->
                        <div class="tab-pane fade" id="diagnosa" role="tabpanel" aria-labelledby="diagnosa-tab">
                            <?php if(!empty($riwayat_diagnosa)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableDiagnosa" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="18%">Kode ICD</th>
                                                <th width="45%">Diagnosa</th>
                                                <th width="20%">Dokter</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($riwayat_diagnosa as $d): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($d->tanggal)); ?></td>
                                                    <td><?= $d->kode_icd ?? '-'; ?></td>
                                                    <td><?= $d->diagnosa; ?></td>
                                                    <td><?= $d->nama_dokter ?? '-'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Belum ada riwayat diagnosa untuk pasien ini.
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tab Riwayat Tindakan -->
                        <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                            <?php if(!empty($riwayat_tindakan)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableTindakan" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="20%">No. Kunjungan</th>
                                                <th width="43%">Nama Tindakan</th>
                                                <th width="20%">Dokter</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($riwayat_tindakan as $t): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($t->tanggal)); ?></td>
                                                    <td><?= $t->no_kunjungan; ?></td>
                                                    <td><?= $t->nama_tindakan; ?></td>
                                                    <td><?= $t->nama_dokter ?? '-'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Belum ada riwayat tindakan untuk pasien ini.
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tab Riwayat Obat -->
                        <div class="tab-pane fade" id="obat" role="tabpanel" aria-labelledby="obat-tab">
                            <?php if(!empty($riwayat_obat)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableObat" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="18%">No. Kunjungan</th>
                                                <th width="30%">Nama Obat</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="20%">Aturan Pakai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($riwayat_obat as $o): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($o->tanggal)); ?></td>
                                                    <td><?= $o->no_kunjungan; ?></td>
                                                    <td><?= $o->nama_obat; ?></td>
                                                    <td><?= $o->jumlah; ?> <?= $o->satuan; ?></td>
                                                    <td><?= $o->aturan_pakai ?? '-'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Belum ada riwayat pemberian obat untuk pasien ini.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="javascript:history.back()" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#dataTable').DataTable({
        order: [[1, 'desc']]
    });
    
    $('#tableDiagnosa').DataTable({
        order: [[1, 'desc']]
    });
    
    $('#tableTindakan').DataTable({
        order: [[1, 'desc']]
    });
    
    $('#tableObat').DataTable({
        order: [[1, 'desc']]
    });
});
</script> 