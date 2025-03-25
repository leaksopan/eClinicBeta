<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk mengelola kunjungan pasien
 */
class Kunjungan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cek apakah pengguna sudah login
        check_auth();
        
        // Load model yang diperlukan
        $this->load->model('Kunjungan_model');
        $this->load->model('Antrian_model');
        $this->load->model('Pasien_model');
        $this->load->model('Dokter_model');
        $this->load->model('Poliklinik_model');
        $this->load->model('Rekam_medis_model');
        $this->load->model('Tindakan_model');
        
        // Load helper
        $this->load->helper(['form', 'url', 'date']);
        $this->load->library(['form_validation', 'session']);
    }
    
    /**
     * Halaman utama kunjungan
     */
    public function index() {
        $data['title'] = 'Kunjungan Pasien';
        $data['user'] = get_current_user();
        
        // Filter data
        $filter = [];
        if ($this->input->get('tanggal')) {
            $filter['tanggal'] = $this->input->get('tanggal');
        } else {
            $filter['tanggal'] = date('Y-m-d');
        }
        
        if ($this->input->get('id_poliklinik')) {
            $filter['id_poliklinik'] = $this->input->get('id_poliklinik');
        }
        
        if ($this->input->get('id_dokter')) {
            $filter['id_dokter'] = $this->input->get('id_dokter');
        }
        
        if ($this->input->get('status')) {
            $filter['status'] = $this->input->get('status');
        }
        
        // Ambil data kunjungan
        $data['kunjungan'] = $this->Kunjungan_model->get_all_kunjungan(NULL, NULL, $filter);
        
        // Ambil data poliklinik untuk filter
        $data['poliklinik'] = $this->Poliklinik_model->get_all_poli();
        
        // Ambil data dokter untuk filter
        $data['dokter'] = $this->Dokter_model->get_all_dokter();
        
        // Untuk filter aktif
        $data['filter'] = $filter;
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('kunjungan/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Halaman antrian pasien
     */
    public function antrian() {
        $data['title'] = 'Antrian Pasien';
        $data['user'] = get_current_user();
        
        // Filter data
        $filter = [];
        if ($this->input->get('tanggal')) {
            $filter['tanggal'] = $this->input->get('tanggal');
        } else {
            $filter['tanggal'] = date('Y-m-d');
        }
        
        if ($this->input->get('id_poliklinik')) {
            $filter['id_poliklinik'] = $this->input->get('id_poliklinik');
        }
        
        if ($this->input->get('status')) {
            $filter['status'] = $this->input->get('status');
        }
        
        // Ambil data antrian
        $data['antrian'] = $this->Antrian_model->get_all_antrian($filter);
        
        // Ambil data poliklinik untuk filter
        $data['poliklinik'] = $this->Poliklinik_model->get_all_poli();
        
        // Untuk filter aktif
        $data['filter'] = $filter;
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('kunjungan/antrian', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Halaman tambah antrian pasien
     */
    public function tambah_antrian() {
        $data['title'] = 'Tambah Antrian Pasien';
        $data['user'] = get_current_user();
        
        // Ambil data pasien dan poliklinik untuk dropdown
        $data['pasien'] = $this->Pasien_model->get_all_pasien();
        $data['poliklinik'] = $this->Poliklinik_model->get_all_poli();
        
        // Set aturan validasi form
        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required');
        $this->form_validation->set_rules('id_poliklinik', 'Poliklinik', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Tampilkan form tambah antrian
            $this->load->view('templates/header', $data);
            $this->load->view('kunjungan/tambah_antrian', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses tambah antrian
            $antrian_data = [
                'id_pasien' => $this->input->post('id_pasien'),
                'id_poliklinik' => $this->input->post('id_poliklinik'),
                'id_dokter' => $this->input->post('id_dokter') ?: NULL,
                'tanggal' => $this->input->post('tanggal'),
                'status' => 'menunggu'
            ];
            
            $id_antrian = $this->Antrian_model->create_antrian($antrian_data);
            
            if ($id_antrian) {
                // Jika berhasil, ambil data antrian untuk ditampilkan
                $antrian = $this->Antrian_model->get_antrian_by_id($id_antrian);
                
                $this->session->set_flashdata('success', 'Antrian berhasil dibuat. Nomor antrian: ' . $antrian->no_antrian);
                redirect('kunjungan/antrian');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat antrian. Silakan coba lagi.');
                redirect('kunjungan/tambah_antrian');
            }
        }
    }
    
    /**
     * Method untuk membatalkan antrian
     * 
     * @param int $id_antrian ID antrian
     */
    public function batal_antrian($id_antrian) {
        $antrian = $this->Antrian_model->get_antrian_by_id($id_antrian);
        
        if (!$antrian) {
            $this->session->set_flashdata('error', 'Antrian tidak ditemukan.');
            redirect('kunjungan/antrian');
        }
        
        $result = $this->Antrian_model->cancel_antrian($id_antrian);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Antrian berhasil dibatalkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membatalkan antrian.');
        }
        
        redirect('kunjungan/antrian');
    }
    
    /**
     * Halaman pemeriksaan pasien
     * 
     * @param int $id_antrian ID antrian
     */
    public function periksa($id_antrian = NULL) {
        check_auth();
        
        // Validasi ID antrian
        if (!$id_antrian) {
            $this->session->set_flashdata('error', 'ID Antrian tidak valid');
            redirect('kunjungan/antrian');
        }
        
        // Ambil data antrian
        $antrian = $this->Antrian_model->get_antrian_by_id($id_antrian);
        if (!$antrian) {
            $this->session->set_flashdata('error', 'Data antrian tidak ditemukan');
            redirect('kunjungan/antrian');
        }
        
        // Cek status antrian
        if ($antrian->status != 'menunggu' && $antrian->status != 'diperiksa') {
            $this->session->set_flashdata('error', 'Pasien sudah diperiksa atau dibatalkan');
            redirect('kunjungan/antrian');
        }
        
        // Load library form validation
        $this->load->library('form_validation');
        
        // Set rules validasi
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');
        
        // Jika form disubmit dan validasi sukses
        if ($this->form_validation->run() === TRUE) {
            // Siapkan data rekam medis baru
            $data_rekam_medis = array(
                'id_pasien' => $antrian->id_pasien,
                'id_dokter' => $antrian->id_dokter,
                'id_pendaftaran' => $id_antrian, // menggunakan id_antrian sebagai id_pendaftaran
                'tanggal_periksa' => date('Y-m-d H:i:s'),
                'keluhan_utama' => $this->input->post('keluhan'),
                'diagnosis' => $this->input->post('diagnosa'),
                'tindakan' => is_array($this->input->post('tindakan')) ? implode(',', $this->input->post('tindakan')) : $this->input->post('tindakan'),
                'catatan_pemeriksaan' => $this->input->post('keterangan'),
                'is_rujukan' => ($this->input->post('is_rujukan') == '1') ? 1 : 0,
                'rujuk_ke' => $this->input->post('rujuk_ke'),
                'catatan_rujukan' => $this->input->post('catatan_rujukan'),
                'id_petugas' => $this->session->userdata('user_id')
            );
            
            // Load model Rekam_medis jika belum loaded
            $this->load->model('Rekam_medis_model');
            
            // Debug untuk melihat query generate nomor
            $this->db->db_debug = TRUE;
            
            // Simpan data rekam medis
            try {
                $id_rekam_medis = $this->Rekam_medis_model->create_rekam_medis($data_rekam_medis);
                
                // Update status antrian menjadi 'selesai'
                $this->Antrian_model->update_antrian($id_antrian, array('status' => 'selesai'));
                
                // Set flash data berhasil
                $this->session->set_flashdata('success', 'Pemeriksaan berhasil disimpan');
                
                // Redirect ke halaman detail rekam medis atau kunjungan (karena rekam_medis/detail belum ada)
                redirect('kunjungan/antrian');
            } catch (Exception $e) {
                // Tangkap error jika ada
                $this->session->set_flashdata('error', 'Gagal menyimpan pemeriksaan: ' . $e->getMessage());
                redirect('kunjungan/periksa/' . $id_antrian);
            }
        }
        
        $data['title'] = 'Pemeriksaan Pasien';
        $data['user'] = get_current_user();
        
        // Ambil data antrian
        $data['antrian'] = $this->Antrian_model->get_antrian_by_id($id_antrian);
        
        if (!$data['antrian']) {
            $this->session->set_flashdata('error', 'Antrian tidak ditemukan.');
            redirect('kunjungan/antrian');
        }
        
        // Cek jika status antrian bukan 'menunggu' atau 'diperiksa', redirect ke halaman antrian
        if (!in_array($data['antrian']->status, ['menunggu', 'diperiksa'])) {
            $this->session->set_flashdata('error', 'Antrian sudah selesai atau dibatalkan.');
            redirect('kunjungan/antrian');
        }
        
        // Ambil data pasien
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($data['antrian']->id_pasien);
        
        // Ambil data dokter untuk dropdown
        $data['dokter'] = $this->Dokter_model->get_all_dokter();
        
        // Ambil data tindakan
        $data['tindakan'] = $this->Tindakan_model->get_dropdown();
        
        // Cek apakah sudah ada kunjungan untuk antrian ini
        $filter = ['id_antrian' => $id_antrian];
        $existing_kunjungan = $this->Kunjungan_model->get_all_kunjungan(1, 0, $filter);
        
        if ($existing_kunjungan) {
            // Jika sudah ada, redirect ke halaman edit
            redirect('kunjungan/edit/' . $existing_kunjungan[0]->id_kunjungan);
        }
        
        // Update status antrian menjadi "diperiksa" hanya jika status saat ini adalah "menunggu"
        if ($data['antrian']->status === 'menunggu') {
            $this->Antrian_model->start_periksa($id_antrian);
            // Refresh data antrian setelah status diupdate
            $data['antrian'] = $this->Antrian_model->get_antrian_by_id($id_antrian);
        }
        
        // Set aturan validasi form
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Tampilkan form pemeriksaan
            $this->load->view('templates/header', $data);
            $this->load->view('kunjungan/periksa', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses simpan hasil pemeriksaan
            $kunjungan_data = [
                'id_antrian' => $id_antrian,
                'id_pasien' => $data['antrian']->id_pasien,
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poliklinik' => $data['antrian']->id_poliklinik,
                'tanggal' => $data['antrian']->tanggal,
                'keluhan' => $this->input->post('keluhan'),
                'anamnesis' => $this->input->post('anamnesis'),
                'pemeriksaan_fisik' => $this->input->post('pemeriksaan_fisik'),
                'diagnosis' => $this->input->post('diagnosis'),
                'tindakan' => $this->input->post('tindakan'),
                'resep' => $this->input->post('resep'),
                'catatan' => $this->input->post('catatan'),
                'status' => 'aktif'
            ];
            
            $id_kunjungan = $this->Kunjungan_model->create_kunjungan($kunjungan_data);
            
            if ($id_kunjungan) {
                // Jika selesai, update status antrian
                $this->Antrian_model->finish_periksa($id_antrian);
                
                $this->session->set_flashdata('success', 'Data pemeriksaan berhasil disimpan.');
                redirect('kunjungan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data pemeriksaan.');
                redirect('kunjungan/periksa/' . $id_antrian);
            }
        }
    }
    
    /**
     * Halaman edit hasil pemeriksaan
     * 
     * @param int $id_kunjungan ID kunjungan
     */
    public function edit($id_kunjungan) {
        $data['title'] = 'Edit Pemeriksaan Pasien';
        $data['user'] = get_current_user();
        
        // Ambil data kunjungan
        $data['kunjungan'] = $this->Kunjungan_model->get_kunjungan_by_id($id_kunjungan);
        
        if (!$data['kunjungan']) {
            $this->session->set_flashdata('error', 'Data kunjungan tidak ditemukan.');
            redirect('kunjungan');
        }
        
        // Ambil data pasien
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($data['kunjungan']->id_pasien);
        
        // Ambil data dokter untuk dropdown
        $data['dokter'] = $this->Dokter_model->get_all_dokter();
        
        // Set aturan validasi form
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Tampilkan form edit pemeriksaan
            $this->load->view('templates/header', $data);
            $this->load->view('kunjungan/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses update hasil pemeriksaan
            $kunjungan_data = [
                'id_dokter' => $this->input->post('id_dokter'),
                'keluhan' => $this->input->post('keluhan'),
                'anamnesis' => $this->input->post('anamnesis'),
                'pemeriksaan_fisik' => $this->input->post('pemeriksaan_fisik'),
                'diagnosis' => $this->input->post('diagnosis'),
                'tindakan' => $this->input->post('tindakan'),
                'resep' => $this->input->post('resep'),
                'catatan' => $this->input->post('catatan'),
                'status' => $this->input->post('status')
            ];
            
            $result = $this->Kunjungan_model->update_kunjungan($id_kunjungan, $kunjungan_data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Data pemeriksaan berhasil diperbarui.');
                redirect('kunjungan');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pemeriksaan.');
                redirect('kunjungan/edit/' . $id_kunjungan);
            }
        }
    }
    
    /**
     * Halaman detail kunjungan
     * 
     * @param int $id_kunjungan ID kunjungan
     */
    public function detail($id_kunjungan) {
        $data['title'] = 'Detail Kunjungan';
        $data['user'] = get_current_user();
        
        // Ambil data kunjungan
        $data['kunjungan'] = $this->Kunjungan_model->get_kunjungan_by_id($id_kunjungan);
        
        if (!$data['kunjungan']) {
            $this->session->set_flashdata('error', 'Data kunjungan tidak ditemukan.');
            redirect('kunjungan');
        }
        
        // Ambil data pasien
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($data['kunjungan']->id_pasien);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('kunjungan/detail', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Halaman riwayat kunjungan pasien
     * 
     * @param int $id_pasien ID pasien
     */
    public function riwayat($id_pasien) {
        $data['title'] = 'Riwayat Kunjungan Pasien';
        $data['user'] = get_current_user();
        
        // Ambil data pasien
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('pasien');
        }
        
        // Ambil riwayat kunjungan
        $data['riwayat'] = $this->Kunjungan_model->get_riwayat_kunjungan_pasien($id_pasien);
        
        // Ambil rekam medis pasien
        $data['rekam_medis'] = $this->Rekam_medis_model->get_rekam_medis_by_pasien($id_pasien);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('kunjungan/riwayat', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Cetak kartu antrian
     * 
     * @param int $id_antrian ID antrian
     */
    public function cetak_antrian($id_antrian) {
        // Ambil data antrian
        $data['antrian'] = $this->Antrian_model->get_antrian_by_id($id_antrian);
        
        if (!$data['antrian']) {
            $this->session->set_flashdata('error', 'Antrian tidak ditemukan.');
            redirect('kunjungan/antrian');
        }
        
        // Load view cetak
        $this->load->view('kunjungan/cetak_antrian', $data);
    }
} 