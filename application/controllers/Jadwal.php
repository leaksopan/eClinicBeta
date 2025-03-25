<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk mengelola jadwal praktek dokter
 * 
 * @property Jadwal_model $Jadwal_model
 * @property Dokter_model $Dokter_model
 * @property Poliklinik_model $Poliklinik_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Jadwal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jadwal_model');
        $this->load->model('Dokter_model');
        $this->load->model('Poliklinik_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Manajemen Jadwal Praktek Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_all_jadwal();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Jadwal Praktek Dokter';
        $data['dokter'] = $this->Dokter_model->get_dropdown_dokter();
        $data['poli'] = $this->Poliklinik_model->get_dropdown_poli();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        // Jadwal dokter yang dipilih
        $id_dokter = $this->input->post('id_dokter');
        $data['jadwal_dokter'] = [];
        
        if ($id_dokter) {
            $data['jadwal_dokter'] = $this->Jadwal_model->get_jadwal_by_dokter($id_dokter);
        }
        
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('kuota_pasien', 'Kuota Pasien', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('jadwal/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwal_data = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            // Periksa apakah jadwal bentrok dengan jadwal yang sudah ada
            $is_conflict = $this->_check_jadwal_conflict(
                $jadwal_data['id_dokter'],
                $jadwal_data['hari'],
                $jadwal_data['jam_mulai'],
                $jadwal_data['jam_selesai']
            );
            
            if ($is_conflict) {
                $this->session->set_flashdata('error', 'Jadwal bentrok dengan jadwal dokter yang sudah ada.');
                redirect('jadwal/tambah');
            } else {
                $this->Jadwal_model->save_jadwal($jadwal_data);
                $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil ditambahkan.');
                redirect('jadwal');
            }
        }
    }
    
    public function edit($id) {
        if (!$id) {
            redirect('jadwal');
        }
        
        $data['title'] = 'Edit Jadwal Praktek Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (!$data['jadwal']) {
            $this->session->set_flashdata('error', 'Jadwal tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['dokter'] = $this->Dokter_model->get_dropdown_dokter();
        $data['poli'] = $this->Poliklinik_model->get_dropdown_poli();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('kuota_pasien', 'Kuota Pasien', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('jadwal/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwal_data = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            // Periksa apakah jadwal bentrok dengan jadwal yang sudah ada (kecuali jadwal ini sendiri)
            $is_conflict = $this->_check_jadwal_conflict(
                $jadwal_data['id_dokter'],
                $jadwal_data['hari'],
                $jadwal_data['jam_mulai'],
                $jadwal_data['jam_selesai'],
                $id
            );
            
            if ($is_conflict) {
                $this->session->set_flashdata('error', 'Jadwal bentrok dengan jadwal dokter yang sudah ada.');
                redirect('jadwal/edit/' . $id);
            } else {
                $this->Jadwal_model->update_jadwal($id, $jadwal_data);
                $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil diperbarui.');
                redirect('jadwal');
            }
        }
    }
    
    public function hapus($id) {
        if (!$id) {
            redirect('jadwal');
        }
        
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (!$jadwal) {
            $this->session->set_flashdata('error', 'Jadwal tidak ditemukan.');
            redirect('jadwal');
        }
        
        $this->Jadwal_model->delete_jadwal($id);
        $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil dihapus.');
        redirect('jadwal');
    }
    
    public function dokter($id_dokter) {
        if (!$id_dokter) {
            redirect('jadwal');
        }
        
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        
        if (!$data['dokter']) {
            $this->session->set_flashdata('error', 'Dokter tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Dokter: ' . $data['dokter']->nama_lengkap;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_dokter($id_dokter);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/dokter', $data);
        $this->load->view('templates/footer');
    }
    
    public function poli($id_poli) {
        if (!$id_poli) {
            redirect('jadwal');
        }
        
        $data['poli'] = $this->Poliklinik_model->get_poli_by_id($id_poli);
        
        if (!$data['poli']) {
            $this->session->set_flashdata('error', 'Poliklinik tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Poliklinik: ' . $data['poli']->nama_poli;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_poli($id_poli);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/poli', $data);
        $this->load->view('templates/footer');
    }
    
    public function hari($hari = null) {
        if (!$hari || !in_array($hari, $this->Jadwal_model->get_hari())) {
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Hari ' . ucfirst($hari);
        $data['hari'] = $hari;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_hari($hari);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/hari', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Periksa apakah jadwal bentrok dengan jadwal yang sudah ada
     * 
     * @param int $id_dokter ID dokter
     * @param string $hari Hari praktek
     * @param string $jam_mulai Jam mulai
     * @param string $jam_selesai Jam selesai
     * @param int|null $current_id ID jadwal saat ini (untuk edit)
     * @return bool TRUE jika bentrok, FALSE jika tidak
     */
    private function _check_jadwal_conflict($id_dokter, $hari, $jam_mulai, $jam_selesai, $current_id = null) {
        // Periksa hanya untuk bentrok jam pada hari yang sama
        // Dokter diperbolehkan memiliki jadwal di hari yang sama dengan jam berbeda
        // selama tidak overlap dengan jadwal yang sudah ada
        return $this->Jadwal_model->check_time_overlap(
            $id_dokter, 
            $hari, 
            $jam_mulai, 
            $jam_selesai, 
            $current_id
        );
    }

    /**
     * Mendapatkan jadwal dokter untuk AJAX
     */
    public function get_jadwal_dokter()
    {
        // Validasi input
        $id_dokter = $this->input->post('id_dokter');
        if (!$id_dokter) {
            echo json_encode([]);
            return;
        }

        // Ambil jadwal dokter
        $this->load->model('Jadwal_model');
        $jadwal = $this->Jadwal_model->get_jadwal_by_dokter($id_dokter);
        
        echo json_encode($jadwal);
    }

    public function tambah_multiple()
    {
        // Cek apakah user sudah login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
            return; // Pastikan fungsi berhenti setelah redirect
        }

        // Ambil data input
        $id_dokter = $this->input->post('id_dokter');
        $id_poli = $this->input->post('id_poli');
        $jadwal_list = $this->input->post('jadwal');

        // Validasi dasar
        if (empty($id_dokter) || empty($id_poli)) {
            $this->session->set_flashdata('error', 'Dokter dan Poliklinik harus dipilih.');
            redirect('jadwal/tambah');
            return;
        }

        if (empty($jadwal_list) || !is_array($jadwal_list)) {
            $this->session->set_flashdata('error', 'Tidak ada jadwal yang ditambahkan.');
            redirect('jadwal/tambah');
            return;
        }

        // Load model
        $this->load->model('Jadwal_model');
        
        // Variable untuk tracking status insert
        $success_count = 0;
        $error_count = 0;
        $error_messages = [];

        // Loop untuk setiap jadwal yang ditambahkan
        foreach ($jadwal_list as $idx => $jadwal_data) {
            // Validasi data jadwal
            if (empty($jadwal_data['hari']) || empty($jadwal_data['jam_mulai']) || empty($jadwal_data['jam_selesai'])) {
                $error_count++;
                $error_messages[] = "Jadwal #" . ($idx + 1) . " tidak lengkap.";
                continue;
            }

            // Cek apakah jam selesai > jam mulai
            if ($jadwal_data['jam_mulai'] >= $jadwal_data['jam_selesai']) {
                $error_count++;
                $error_messages[] = "Jadwal #" . ($idx + 1) . ": Jam mulai harus lebih awal dari jam selesai.";
                continue;
            }

            // Cek apakah jadwal bentrok
            $is_conflict = $this->Jadwal_model->check_time_overlap(
                $id_dokter,
                $jadwal_data['hari'],
                $jadwal_data['jam_mulai'],
                $jadwal_data['jam_selesai']
            );

            if ($is_conflict) {
                $error_count++;
                $error_messages[] = "Jadwal #" . ($idx + 1) . ": Bentrok dengan jadwal dokter yang sudah ada.";
                continue;
            }

            // Data untuk insert
            $data = [
                'id_dokter' => $id_dokter,
                'id_poli' => $id_poli,
                'hari' => $jadwal_data['hari'],
                'jam_mulai' => $jadwal_data['jam_mulai'],
                'jam_selesai' => $jadwal_data['jam_selesai'],
                'kuota_pasien' => isset($jadwal_data['kuota_pasien']) ? $jadwal_data['kuota_pasien'] : 10,
                'keterangan' => isset($jadwal_data['keterangan']) ? $jadwal_data['keterangan'] : '',
                'status' => 'aktif'
            ];

            // Insert jadwal
            $result = $this->Jadwal_model->save_jadwal($data);
            if ($result) {
                $success_count++;
            } else {
                $error_count++;
                $error_messages[] = "Jadwal #" . ($idx + 1) . ": Gagal menyimpan ke database.";
            }
        }

        // Set flashdata berdasarkan hasil
        if ($success_count > 0) {
            $message = "Berhasil menambahkan " . $success_count . " jadwal.";
            if ($error_count > 0) {
                $message .= " Terdapat " . $error_count . " jadwal yang gagal ditambahkan.";
            }
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', "Gagal menambahkan jadwal. " . implode(" ", $error_messages));
        }

        redirect('jadwal');
    }

    /**
     * Check konflik jadwal via AJAX
     */
    public function check_conflict_ajax()
    {
        // Ambil data input
        $id_dokter = $this->input->post('id_dokter');
        $hari = $this->input->post('hari');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $current_id = $this->input->post('current_id');
        
        // Validasi input
        if (!$id_dokter || !$hari || !$jam_mulai || !$jam_selesai) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }
        
        // Cek apakah jam selesai > jam mulai
        if ($jam_mulai >= $jam_selesai) {
            echo json_encode([
                'status' => false, 
                'message' => 'Jam mulai harus lebih awal dari jam selesai'
            ]);
            return;
        }
        
        // Cek konflik
        $is_conflict = $this->_check_jadwal_conflict(
            $id_dokter,
            $hari,
            $jam_mulai,
            $jam_selesai,
            $current_id
        );
        
        if ($is_conflict) {
            echo json_encode([
                'status' => false, 
                'message' => 'Jadwal bentrok dengan jadwal dokter yang sudah ada'
            ]);
        } else {
            echo json_encode([
                'status' => true, 
                'message' => 'Jadwal tersedia'
            ]);
        }
    }
} 