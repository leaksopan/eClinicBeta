<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk mengelola pasien
 * 
 * @property CI_DB_query_builder $db Database
 * @property CI_Input $input Input
 * @property CI_Form_validation $form_validation Form validation
 * @property CI_Session $session Session
 * @property CI_Upload $upload Upload
 * @property Pasien_model $Pasien_model Model Pasien
 * @property Rekam_medis_model $Rekam_medis_model Model Rekam Medis
 * @property Kunjungan_model $Kunjungan_model Model Kunjungan
 */
class Pasien extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pasien_model');
        $this->load->helper(['form', 'url', 'date']);
        $this->load->library(['form_validation', 'session', 'upload']);
    }
    
    /**
     * Halaman daftar pasien
     */
    public function index() {
        $data['title'] = 'Daftar Pasien';
        $data['pasien'] = $this->Pasien_model->get_all_pasien();
        
        $this->load->view('pasien/index', $data);
    }
    
    /**
     * Halaman tambah pasien baru
     */
    public function tambah() {
        $data['title'] = 'Tambah Pasien Baru';
        $data['provinsi'] = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 
            'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
        ];
        
        // Set rules validasi
        $this->form_validation->set_rules('nama_lengkap', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('pasien/tambah', $data);
        } else {
            // Upload foto jika ada
            $foto = NULL;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'foto_' . time();

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    $foto_data = $this->upload->data();
                    $foto = $config['upload_path'] . $foto_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/tambah');
                }
            }
            
            // Generate nomor RM
            $no_rm = $this->Pasien_model->generate_no_rm();
            
            // Data pasien
            $data_pasien = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_telp' => $this->input->post('no_telp'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_identitas' => $this->input->post('no_identitas'),
                'jenis_identitas' => $this->input->post('jenis_identitas'),
                'agama' => $this->input->post('agama'),
                'suku' => $this->input->post('suku'),
                'status_pernikahan' => $this->input->post('status_pernikahan'),
                'pendidikan' => $this->input->post('pendidikan'),
                'nama_keluarga' => $this->input->post('nama_keluarga'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'telp_keluarga' => $this->input->post('telp_keluarga'),
                'golongan_darah' => $this->input->post('golongan_darah'),
                'rhesus' => $this->input->post('rhesus'),
                'alergi' => $this->input->post('alergi'),
                'catatan_khusus' => $this->input->post('catatan_khusus'),
                'status' => $this->input->post('status'),
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'foto' => $foto,
                'no_rm' => $no_rm
            ];
            
            $id_pasien = $this->Pasien_model->save_pasien($data_pasien);
            
            if ($id_pasien) {
                $this->session->set_flashdata('success', 'Data pasien berhasil disimpan!');
                redirect('pasien/lihat/' . $id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data pasien!');
                redirect('pasien/tambah');
            }
        }
    }
    
    /**
     * Halaman edit data pasien
     */
    public function edit($id_pasien) {
        $data['title'] = 'Edit Data Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $data['provinsi'] = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 
            'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
        ];
        
        // Set rules validasi
        $this->form_validation->set_rules('nama_lengkap', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('pasien/edit', $data);
        } else {
            // Upload foto jika ada
            $foto = $data['pasien']->foto;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'foto_' . time();

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    // Hapus foto lama jika ada
                    if ($foto && file_exists($foto)) {
                        unlink($foto);
                    }
                    
                    $foto_data = $this->upload->data();
                    $foto = $config['upload_path'] . $foto_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/edit/' . $id_pasien);
                }
            }
            
            // Data pasien
            $data_pasien = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_telp' => $this->input->post('no_telp'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_identitas' => $this->input->post('no_identitas'),
                'jenis_identitas' => $this->input->post('jenis_identitas'),
                'agama' => $this->input->post('agama'),
                'suku' => $this->input->post('suku'),
                'status_pernikahan' => $this->input->post('status_pernikahan'),
                'pendidikan' => $this->input->post('pendidikan'),
                'nama_keluarga' => $this->input->post('nama_keluarga'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'telp_keluarga' => $this->input->post('telp_keluarga'),
                'golongan_darah' => $this->input->post('golongan_darah'),
                'rhesus' => $this->input->post('rhesus'),
                'alergi' => $this->input->post('alergi'),
                'catatan_khusus' => $this->input->post('catatan_khusus'),
                'status' => $this->input->post('status'),
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'foto' => $foto
            ];
            
            if ($this->Pasien_model->update_pasien($id_pasien, $data_pasien)) {
                $this->session->set_flashdata('success', 'Data pasien berhasil diperbarui!');
                redirect('pasien/lihat/' . $id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pasien!');
                redirect('pasien/edit/' . $id_pasien);
            }
        }
    }
    
    /**
     * Halaman detail pasien
     */
    public function lihat($id_pasien) {
        $data['title'] = 'Detail Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $this->load->view('pasien/lihat', $data);
    }
    
    /**
     * Halaman kartu pasien
     */
    public function kartu($id_pasien = NULL) {
        if ($id_pasien === NULL) {
            $this->session->set_flashdata('error', 'ID Pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $data['title'] = 'Kartu Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $this->load->view('pasien/kartu', $data);
    }
    
    /**
     * Hapus data pasien
     */
    public function hapus($id_pasien) {
        $pasien = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$pasien) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        // Hapus foto jika ada
        if ($pasien->foto && file_exists($pasien->foto)) {
            unlink($pasien->foto);
        }
        
        if ($this->Pasien_model->delete_pasien($id_pasien)) {
            $this->session->set_flashdata('success', 'Data pasien berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pasien!');
        }
        
        redirect('pasien');
    }
    
    /**
     * Pencarian pasien
     */
    public function cari() {
        $keyword = $this->input->get('keyword');
        
        if (empty($keyword)) {
            redirect('pasien');
        }
        
        $data['title'] = 'Hasil Pencarian: ' . $keyword;
        $data['pasien'] = $this->Pasien_model->search_pasien($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('pasien/index', $data);
    }
    
    /**
     * Halaman statistik pasien
     */
    public function statistik() {
        $data['title'] = 'Statistik Pasien';
        $data['jenis_kelamin'] = $this->Pasien_model->get_statistik_jenis_kelamin();
        $data['usia'] = $this->Pasien_model->get_statistik_usia();
        $data['total_pasien'] = $this->Pasien_model->count_all_pasien();
        
        $this->load->view('pasien/statistik', $data);
    }
    
    /**
     * Cetak data pasien
     */
    public function cetak($id_pasien = NULL) {
        if ($id_pasien) {
            // Cetak data individual
            $data['title'] = 'Cetak Data Pasien';
            $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
            
            if (!$data['pasien']) {
                $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
                redirect('pasien');
            }
            
            $this->load->view('pasien/cetak_individual', $data);
        } else {
            // Cetak semua data
            $data['title'] = 'Cetak Daftar Pasien';
            $data['pasien'] = $this->Pasien_model->get_all_pasien();
            
            $this->load->view('pasien/cetak_all', $data);
        }
    }
    
    /**
     * API JSON untuk lookup pasien (untuk AJAX)
     */
    public function get_pasien_json() {
        // Default values
        $search = $this->input->post('search');
        $page = $this->input->post('page') ? (int)$this->input->post('page') : 1;
        $limit = 8; // Jumlah data per halaman
        $offset = ($page - 1) * $limit;
        
        // Load model untuk pencarian
        $this->load->model('Pasien_model');
        
        // Jika ada keyword pencarian
        if (!empty($search)) {
            $data = $this->Pasien_model->search_pasien_paginated($search, $limit, $offset);
            $total_data = $this->Pasien_model->count_search_results($search);
        } else {
            // Jika tidak ada keyword, tampilkan semua
            $data = $this->Pasien_model->get_all_pasien($limit, $offset);
            $total_data = $this->Pasien_model->count_all_pasien();
        }
        
        // Format data untuk JSON
        $result = [];
        foreach ($data as $p) {
            // Format jenis kelamin
            $jenis_kelamin = ($p->jenis_kelamin == 'L') ? 'LAKI-LAKI' : 'PEREMPUAN';
            
            // Format tanggal lahir
            $tgl_lahir = date('Y-m-d', strtotime($p->tanggal_lahir));
            
            $result[] = [
                'id_pasien' => $p->id_pasien,
                'no_rm' => $p->no_rm,
                'nama_lengkap' => $p->nama_lengkap,
                'tgl_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jenis_kelamin,
                'tipe_pasien' => 'UMUM', // Ganti dengan field actual jika ada
                'telepon' => $p->no_telp,
                'alamat' => $p->alamat
            ];
        }
        
        // Hitung total halaman
        $total_page = ceil($total_data / $limit);
        
        // Siapkan response
        $response = [
            'status' => true,
            'data' => $result,
            'total_data' => $total_data,
            'total_page' => $total_page,
            'current_page' => $page
        ];
        
        // Return sebagai JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    /**
     * API JSON untuk detail pasien (untuk AJAX)
     */
    public function get_detail_json() {
        $id_pasien = $this->input->post('id_pasien');
        
        if (!$id_pasien) {
            $response = ['status' => false, 'message' => 'ID Pasien tidak valid'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
        
        // Load model
        $this->load->model('Pasien_model');
        $this->load->model('Rekam_medis_model');
        $this->load->model('Kunjungan_model');
        
        // Get data pasien
        $pasien = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$pasien) {
            $response = ['status' => false, 'message' => 'Data pasien tidak ditemukan'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
        
        // Format jenis kelamin
        $jenis_kelamin = ($pasien->jenis_kelamin == 'L') ? 'LAKI-LAKI' : 'PEREMPUAN';
        
        // Format tanggal lahir
        $tgl_lahir = date('d-m-Y', strtotime($pasien->tanggal_lahir));
        
        // Get riwayat kunjungan terakhir
        $riwayat = $this->Kunjungan_model->get_riwayat_kunjungan_pasien($id_pasien, 1);
        $terakhir_berobat = '';
        
        if (!empty($riwayat)) {
            $terakhir_berobat = date('d-m-Y', strtotime($riwayat[0]->tanggal));
        }
        
        // Siapkan data pasien
        $data_pasien = [
            'id_pasien' => $pasien->id_pasien,
            'no_rm' => $pasien->no_rm,
            'nama_lengkap' => $pasien->nama_lengkap,
            'tgl_lahir' => $tgl_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'telepon' => $pasien->no_telp,
            'alamat' => $pasien->alamat
        ];
        
        // Siapkan response
        $response = [
            'status' => true,
            'data' => $data_pasien,
            'terakhir_berobat' => $terakhir_berobat
        ];
        
        // Return sebagai JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    /**
     * Mendapatkan detail lengkap pasien untuk AJAX request
     */
    public function get_detail_lengkap_json() {
        // Pastikan ini adalah request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id_pasien = $this->input->post('id_pasien');
        
        if (empty($id_pasien)) {
            echo json_encode(['status' => false, 'message' => 'ID pasien tidak valid']);
            return;
        }
        
        // Ambil data pasien
        $pasien = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$pasien) {
            echo json_encode(['status' => false, 'message' => 'Data pasien tidak ditemukan']);
            return;
        }
        
        // Ambil data terakhir berobat
        $this->load->model('Kunjungan_model');
        $terakhir_berobat = $this->Kunjungan_model->get_last_visit_by_pasien($id_pasien);
        
        $response = [
            'status' => true,
            'data' => $pasien,
            'terakhir_berobat' => $terakhir_berobat ? date('d-m-Y', strtotime($terakhir_berobat->tanggal)) : '-'
        ];
        
        echo json_encode($response);
    }
} 