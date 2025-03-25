<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Antrian <?= $antrian->no_antrian; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
        }
        .container {
            width: 80mm; /* Ukuran kertas thermal biasanya 80mm */
            margin: 0 auto;
            padding: 5mm;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5mm;
            margin-bottom: 5mm;
        }
        .logo {
            max-width: 60mm;
            height: auto;
            margin-bottom: 2mm;
        }
        .clinic-name {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }
        .clinic-address {
            font-size: 9pt;
            margin: 2mm 0;
        }
        .ticket-number {
            font-size: 24pt;
            font-weight: bold;
            text-align: center;
            margin: 10mm 0;
        }
        .patient-info {
            margin-bottom: 5mm;
        }
        .label {
            font-weight: bold;
            width: 40%;
            display: inline-block;
        }
        .value {
            width: 60%;
            display: inline-block;
        }
        .footer {
            text-align: center;
            margin-top: 10mm;
            font-size: 9pt;
            border-top: 1px solid #ddd;
            padding-top: 5mm;
        }
        .notes {
            font-style: italic;
            text-align: center;
            margin-top: 5mm;
            font-size: 9pt;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if(!empty($klinik->logo)): ?>
                <img src="<?= base_url('assets/img/'.$klinik->logo); ?>" alt="Logo Klinik" class="logo">
            <?php endif; ?>
            <div class="clinic-name"><?= $klinik->nama; ?></div>
            <div class="clinic-address">
                <?= $klinik->alamat; ?><br>
                Telp: <?= $klinik->telepon; ?>
            </div>
        </div>
        
        <div class="ticket-content">
            <div style="text-align: center; font-weight: bold; margin-bottom: 2mm;">
                NOMOR ANTRIAN
            </div>
            
            <div class="ticket-number">
                <?= $antrian->no_antrian; ?>
            </div>
            
            <div class="patient-info">
                <div><span class="label">Tanggal</span>: <span class="value"><?= date('d F Y', strtotime($antrian->tanggal)); ?></span></div>
                <div><span class="label">Jam Daftar</span>: <span class="value"><?= date('H:i', strtotime($antrian->created_at)); ?> WIB</span></div>
                <div><span class="label">Nama Pasien</span>: <span class="value"><?= $antrian->nama_pasien; ?></span></div>
                <div><span class="label">No. Rekam Medis</span>: <span class="value"><?= $antrian->no_rekam_medis; ?></span></div>
                <div><span class="label">Poliklinik</span>: <span class="value"><?= $antrian->nama_poli; ?></span></div>
                <?php if(!empty($antrian->nama_dokter)): ?>
                <div><span class="label">Dokter</span>: <span class="value"><?= $antrian->nama_dokter; ?></span></div>
                <?php endif; ?>
            </div>
            
            <div class="notes">
                Silakan tunggu nomor antrian Anda dipanggil.<br>
                Terima kasih atas kesabaran Anda.
            </div>
        </div>
        
        <div class="footer">
            <?= $klinik->nama; ?> - <?= date('Y'); ?><br>
            Semoga Lekas Sembuh
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin: 20px;">
        <button onclick="window.print();" style="padding: 8px 16px; background: #4e73df; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak
        </button>
        <button onclick="window.close();" style="padding: 8px 16px; background: #858796; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <script>
        window.onload = function() {
            // Auto print ketika halaman dimuat
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html> 