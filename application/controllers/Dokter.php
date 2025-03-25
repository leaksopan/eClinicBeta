<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dokter Controller
 * 
 * Controller untuk mengelola data dokter dan jadwal praktek
 * 
 * @package     eClinic
 * @subpackage  Controllers
 * @category    Dokter
 */

/**
 * @property Dokter_model $Dokter_model
 * @property Jadwal_model $Jadwal_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Dokter extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Dokter_model');
        $this->load->model('Jadwal_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    public function index() {
        $data['title'] = 'Daftar Dokter';
        $data['dokter'] = $this->Dokter_model->get_all_dokter();
        
        $this->load->view('dokter/index', $data);
    }
    
    public function tambah() {
        $this->form_validation->set_rules('id_pengguna', 'Pengguna', 'required');
        $this->form_validation->set_rules('sip', 'SIP', 'required');
        $this->form_validation->set_rules('tarif_konsultasi', 'Tarif Konsultasi', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Dokter';
            $data['pengguna'] = $this->Dokter_model->get_pengguna_dropdown();
            
            $this->load->view('dokter/tambah', $data);
        } else {
            // Cek apakah pengguna sudah terdaftar sebagai dokter
            $id_pengguna = $this->input->post('id_pengguna');
            $dokter_exist = $this->Dokter_model->get_dokter_by_user_id($id_pengguna);
            
            if ($dokter_exist) {
                $this->session->set_flashdata('error', 'Pengguna ini sudah terdaftar sebagai dokter');
                redirect('dokter/tambah');
                return;
            }
            
            $data_dokter = [
                'id_pengguna' => $id_pengguna,
                'sip' => $this->input->post('sip'),
                'spesialis' => $this->input->post('spesialis'),
                'tarif_konsultasi' => $this->input->post('tarif_konsultasi'),
                'komisi_persen' => $this->input->post('komisi_persen'),
                'status_praktek' => $this->input->post('status_praktek'),
                'jatah_pasien' => $this->input->post('jatah_pasien'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'alumni' => $this->input->post('alumni'),
                'tahun_lulus' => $this->input->post('tahun_lulus'),
                'mulai_praktek' => $this->input->post('mulai_praktek')
            ];
            
            if ($this->Dokter_model->save_dokter($data_dokter)) {
                $this->session->set_flashdata('success', 'Data dokter berhasil ditambahkan');
                redirect('dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data dokter');
                redirect('dokter/tambah');
            }
        }
    }
    
    public function edit($id) {
        $dokter = $this->Dokter_model->get_dokter_by_id($id);
        
        if (empty($dokter)) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('dokter');
        }
        
        $this->form_validation->set_rules('sip', 'SIP', 'required');
        $this->form_validation->set_rules('tarif_konsultasi', 'Tarif Konsultasi', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Dokter';
            $data['dokter'] = $dokter;
            $data['pengguna'] = $this->Dokter_model->get_pengguna_dropdown();
            
            $this->load->view('dokter/edit', $data);
        } else {
            $data_dokter = [
                'sip' => $this->input->post('sip'),
                'spesialis' => $this->input->post('spesialis'),
                'tarif_konsultasi' => $this->input->post('tarif_konsultasi'),
                'komisi_persen' => $this->input->post('komisi_persen'),
                'status_praktek' => $this->input->post('status_praktek'),
                'jatah_pasien' => $this->input->post('jatah_pasien'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'alumni' => $this->input->post('alumni'),
                'tahun_lulus' => $this->input->post('tahun_lulus'),
                'mulai_praktek' => $this->input->post('mulai_praktek')
            ];
            
            if ($this->Dokter_model->update_dokter($id, $data_dokter)) {
                $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui');
                redirect('dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data dokter');
                redirect('dokter/edit/' . $id);
            }
        }
    }
    
    public function lihat($id) {
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id);
        
        if (empty($data['dokter'])) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('dokter');
        }
        
        $data['title'] = 'Detail Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_dokter($id);
        
        $this->load->view('dokter/lihat', $data);
    }
    
    public function hapus($id) {
        $dokter = $this->Dokter_model->get_dokter_by_id($id);
        
        if (empty($dokter)) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('dokter');
        }
        
        if ($this->Dokter_model->delete_dokter($id)) {
            $this->session->set_flashdata('success', 'Data dokter berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data dokter');
        }
        
        redirect('dokter');
    }
    
    public function cari() {
        $keyword = $this->input->post('keyword');
        
        if (empty($keyword)) {
            redirect('dokter');
        }
        
        $data['title'] = 'Hasil Pencarian Dokter';
        $data['dokter'] = $this->Dokter_model->search_dokter($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('dokter/index', $data);
    }
    
    public function statistik() {
        $data['title'] = 'Statistik Dokter';
        
        // Ambil data statistik dokter
        $data['total_dokter'] = $this->Dokter_model->count_all_dokter();
        $data['dokter_aktif'] = $this->Dokter_model->count_dokter_by_status('Aktif');
        $data['dokter_cuti'] = $this->Dokter_model->count_dokter_by_status('Cuti');
        $data['dokter_tidak_aktif'] = $this->Dokter_model->count_dokter_by_status('Berhenti');
        
        $this->load->view('dokter/statistik', $data);
    }
    
    public function jadwal($id_dokter) {
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        
        if (empty($data['dokter'])) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('dokter');
        }
        
        $data['title'] = 'Jadwal Praktek Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_dokter($id_dokter);
        
        $this->load->view('dokter/jadwal', $data);
    }
    
    public function tambah_jadwal($id_dokter) {
        $dokter = $this->Dokter_model->get_dokter_by_id($id_dokter);
        
        if (empty($dokter)) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('dokter');
        }
        
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Jadwal Praktek';
            $data['dokter'] = $dokter;
            
            // Load model poliklinik
            $this->load->model('Poliklinik_model');
            // Tambahkan data poliklinik untuk dropdown
            $data['poliklinik'] = $this->Poliklinik_model->get_dropdown_poli();
            
            $this->load->view('dokter/tambah_jadwal', $data);
        } else {
            $data_jadwal = [
                'id_dokter' => $id_dokter,
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'id_poli' => $this->input->post('id_poli'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            // Periksa konflik jadwal
            $is_conflict = $this->Jadwal_model->check_jadwal_conflict(
                $id_dokter,
                $data_jadwal['hari'],
                $data_jadwal['jam_mulai'],
                $data_jadwal['jam_selesai']
            );
            
            if ($is_conflict) {
                $this->session->set_flashdata('error', 'Jadwal bentrok dengan jadwal dokter yang sudah ada.');
                $data['title'] = 'Tambah Jadwal Praktek';
                $data['dokter'] = $dokter;
                $this->load->view('dokter/tambah_jadwal', $data);
            } else {
                $jadwal_id = $this->Jadwal_model->save_jadwal($data_jadwal);
                if ($jadwal_id) {
                    $this->session->set_flashdata('success', 'Jadwal praktek berhasil ditambahkan');
                    
                    // Redirect ke halaman jadwal
                    redirect('jadwal');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan jadwal praktek');
                    redirect('dokter/jadwal/' . $id_dokter);
                }
            }
        }
    }
    
    public function edit_jadwal($id_jadwal) {
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id_jadwal);
        
        if (empty($jadwal)) {
            $this->session->set_flashdata('error', 'Jadwal praktek tidak ditemukan');
            redirect('dokter');
        }
        
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Jadwal Praktek';
            $data['jadwal'] = $jadwal;
            $data['dokter'] = $this->Dokter_model->get_dokter_by_id($jadwal->id_dokter);
            
            $this->load->view('dokter/edit_jadwal', $data);
        } else {
            $data_jadwal = [
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'id_poli' => $this->input->post('id_poli'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            if ($this->Jadwal_model->update_jadwal($id_jadwal, $data_jadwal)) {
                $this->session->set_flashdata('success', 'Jadwal praktek berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui jadwal praktek');
            }
            
            redirect('dokter/jadwal/' . $jadwal->id_dokter);
        }
    }
    
    public function hapus_jadwal($id_jadwal) {
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id_jadwal);
        
        if (empty($jadwal)) {
            $this->session->set_flashdata('error', 'Jadwal praktek tidak ditemukan');
            redirect('dokter');
        }
        
        $id_dokter = $jadwal->id_dokter;
        
        if ($this->Jadwal_model->delete_jadwal($id_jadwal)) {
            $this->session->set_flashdata('success', 'Jadwal praktek berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jadwal praktek');
        }
        
        redirect('jadwal');
    }
    
    /**
     * Mendapatkan dokter berdasarkan poliklinik untuk AJAX
     */
    public function get_dokter_by_poli() {
        // Pastikan ini adalah request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id_poliklinik = $this->input->post('id_poliklinik');
        $tanggal = $this->input->post('tanggal');
        
        // Jika kosong, kembalikan array kosong
        if (empty($id_poliklinik)) {
            echo json_encode([]);
            return;
        }
        
        // Ambil semua dokter yang terdaftar di poliklinik ini
        $this->load->model('Jadwal_model');
        
        // Menggunakan Dokter_model daripada langsung query
        $dokter_list = $this->Dokter_model->get_dokter_by_poliklinik($id_poliklinik);
        
        $formatted_dokter = [];
        
        foreach ($dokter_list as $dokter) {
            // Cek jadwal dokter di tanggal yang dipilih
            $hari = date('w', strtotime($tanggal));
            $hari_text = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$hari];
            
            $jadwal = $this->Jadwal_model->get_jadwal_by_dokter_hari($dokter->id_dokter, $hari);
            
            $jadwal_text = "";
            if ($jadwal) {
                $jadwal_text = " (" . $hari_text . ": " . date('H:i', strtotime($jadwal->jam_mulai)) . 
                               " - " . date('H:i', strtotime($jadwal->jam_selesai)) . ")";
            } else {
                $jadwal_text = " (Tidak ada jadwal hari " . $hari_text . ")";
            }
            
            $gelar_depan = !empty($dokter->gelar_depan) ? $dokter->gelar_depan . ' ' : '';
            $gelar_belakang = !empty($dokter->gelar_belakang) ? ', ' . $dokter->gelar_belakang : '';
            $nama_lengkap = $gelar_depan . $dokter->nama_lengkap . $gelar_belakang;
            
            $formatted_dokter[] = [
                'id_dokter' => $dokter->id_dokter,
                'nama' => $nama_lengkap . $jadwal_text,
                'spesialis' => $dokter->spesialis,
                'has_jadwal' => $jadwal ? true : false
            ];
        }
        
        echo json_encode($formatted_dokter);
    }
} 