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
 * @property CI_DB_query_builder $db
 * @property Dokter_model $Dokter_model
 * @property Jadwal_model $Jadwal_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Poliklinik_model $Poliklinik_model
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
            
            $gelar_depan = !empty($dokter->gelar_depan) ? $dokter->gelar_depan . ' ' : '';
            $gelar_belakang = !empty($dokter->gelar_belakang) ? ', ' . $dokter->gelar_belakang : '';
            $nama_lengkap = $gelar_depan . $dokter->nama_lengkap . $gelar_belakang;
            
            $formatted_dokter[] = [
                'id_dokter' => $dokter->id_dokter,
                'nama' => $nama_lengkap,
                'spesialis' => $dokter->spesialis,
                'has_jadwal' => $jadwal ? true : false
            ];
        }
        
        echo json_encode($formatted_dokter);
    }
    
    /**
     * API: Mendapatkan semua data dokter dalam format JSON
     */
    public function get_all_dokter_json() {
        // Pastikan ini adalah request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        // Ambil semua data dokter aktif
        $doctors = $this->Dokter_model->get_all_dokter_simple();
        
        // Format output JSON
        $result = [];
        foreach ($doctors as $doctor) {
            $result[] = [
                'id_dokter' => $doctor->id_dokter,
                'nama' => $doctor->nama_lengkap,
                'spesialis' => $doctor->spesialis
            ];
        }
        
        echo json_encode($result);
    }
    
    /**
     * API: Mendapatkan jadwal mingguan dokter
     */
    public function get_weekly_schedule() {
        // Pastikan ini adalah request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        // Ambil tanggal awal dan akhir dari request
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        if (empty($start_date) || empty($end_date)) {
            echo json_encode([]);
            return;
        }
        
        // Load model yang diperlukan
        $this->load->model('Jadwal_model');
        $this->load->model('Poliklinik_model');
        
        // Konversi tanggal ke objek DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        
        // Mapping antara nama hari dalam Bahasa Indonesia dan nomor hari (1-7, 1=Senin)
        $dayMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];
        
        // Inisialisasi array untuk menyimpan jadwal mingguan
        $weeklySchedule = [];
        
        // Ambil semua data dokter aktif
        $doctors = $this->Dokter_model->get_all_dokter();
        
        // Loop untuk setiap dokter
        foreach ($doctors as $doctor) {
            // Ambil jadwal dokter
            $schedules = $this->Jadwal_model->get_jadwal_by_dokter($doctor->id_dokter);
            
            // Jika dokter tidak memiliki jadwal, lewati
            if (empty($schedules)) {
                continue;
            }
            
            // Loop untuk setiap hari dalam rentang tanggal
            $currentDate = clone $start;
            while ($currentDate <= $end) {
                // Dapatkan nama hari dalam bahasa Indonesia
                $dayOfWeek = (int)$currentDate->format('N'); // 1 (Senin) hingga 7 (Minggu)
                $dayName = $dayMapping[$dayOfWeek];
                
                // Cari jadwal untuk hari ini
                foreach ($schedules as $schedule) {
                    if ($schedule->hari == $dayName) {
                        // Dapatkan informasi poliklinik
                        $poliklinik = $this->Poliklinik_model->get_poli_by_id($schedule->id_poli);
                        
                        // Format jadwal untuk output JSON
                        $scheduleData = [
                            'id_jadwal' => $schedule->id_jadwal,
                            'id_dokter' => $doctor->id_dokter,
                            'nama_dokter' => $doctor->nama_lengkap,
                            'id_poliklinik' => $schedule->id_poli,
                            'nama_poliklinik' => $poliklinik->nama_poli,
                            'jam_mulai' => $schedule->jam_mulai,
                            'jam_selesai' => $schedule->jam_selesai,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'hari' => $dayName,
                            'section' => $schedule->keterangan ?? 'Umum',
                            'status' => $this->check_jadwal_status($schedule->id_jadwal, $currentDate->format('Y-m-d'))
                        ];
                        
                        $weeklySchedule[] = $scheduleData;
                    }
                }
                
                // Pindah ke hari berikutnya
                $currentDate->modify('+1 day');
            }
        }
        
        echo json_encode($weeklySchedule);
    }
    
    /**
     * Mengecek status jadwal (tersedia, penuh, cuti)
     * 
     * @param int $id_jadwal ID jadwal
     * @param string $tanggal Tanggal dalam format Y-m-d
     * @return string Status jadwal ('tersedia', 'penuh', 'cuti')
     */
    private function check_jadwal_status($id_jadwal, $tanggal) {
        // Di sini Anda bisa menambahkan logika untuk memeriksa status jadwal
        // Misalnya, cek apakah dokter cuti, atau apakah kuota sudah penuh
        
        // Sementara kita return 'tersedia' untuk semua jadwal
        return 'tersedia';
        
        // Contoh logika yang bisa diimplementasikan:
        /*
        // Cek apakah dokter cuti
        $is_cuti = $this->Dokter_model->is_dokter_cuti($id_dokter, $tanggal);
        if ($is_cuti) {
            return 'cuti';
        }
        
        // Cek jumlah pasien terdaftar vs kuota
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id_jadwal);
        $jumlah_pasien = $this->Kunjungan_model->count_pasien_by_jadwal($id_jadwal, $tanggal);
        
        if ($jumlah_pasien >= $jadwal->kuota_pasien) {
            return 'penuh';
        }
        
        return 'tersedia';
        */
    }
    
    /**
     * Mendapatkan jadwal dokter tertentu
     */
    public function get_jadwal_dokter() {
        // Pastikan ini adalah request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id_dokter = $this->input->post('id_dokter');
        $id_poliklinik = $this->input->post('id_poliklinik');
        $tanggal = $this->input->post('tanggal');
        
        if (empty($id_dokter) || empty($tanggal)) {
            echo json_encode([]);
            return;
        }
        
        // Ambil hari dari tanggal
        $hari_index = date('w', strtotime($tanggal));
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$hari_index];
        
        // Query untuk mendapatkan jadwal dokter pada hari tersebut
        $this->db->select('jadwal_dokter.*');
        $this->db->from('jadwal_dokter');
        $this->db->where('id_dokter', $id_dokter);
        $this->db->where('hari', $hari);
        $this->db->where('status', 'aktif');
        
        if (!empty($id_poliklinik)) {
            $this->db->where('id_poli', $id_poliklinik);
        }
        
        $this->db->order_by('jam_mulai', 'ASC');
        $jadwal = $this->db->get()->result();
        
        $formatted_jadwal = [];
        
        foreach ($jadwal as $j) {
            $formatted_jadwal[] = [
                'id_jadwal' => $j->id_jadwal,
                'jam_mulai' => date('H:i', strtotime($j->jam_mulai)),
                'jam_selesai' => date('H:i', strtotime($j->jam_selesai)),
                'section' => $hari . ' ' . date('H:i', strtotime($j->jam_mulai)) . 
                            ' - ' . date('H:i', strtotime($j->jam_selesai))
            ];
        }
        
        echo json_encode($formatted_jadwal);
    }
} 