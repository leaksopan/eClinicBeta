<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola antrian pasien
 */
class Antrian_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data antrian
     * 
     * @param array $filter Filter data
     * @return array
     */
    public function get_all_antrian($filter = array()) {
        $this->db->select('antrian.*, pasien.nama_lengkap as nama_pasien, poliklinik.nama_poli as nama_poli, pengguna.nama_lengkap as nama_dokter');
        $this->db->from('antrian');
        $this->db->join('pasien', 'pasien.id_pasien = antrian.id_pasien', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = antrian.id_poliklinik', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = antrian.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        
        // Filter berdasarkan tanggal
        if (!empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir'])) {
            $this->db->where('antrian.tanggal >=', $filter['tanggal_awal']);
            $this->db->where('antrian.tanggal <=', $filter['tanggal_akhir']);
        } else {
            // Default tampilkan antrian hari ini
            $this->db->where('antrian.tanggal', date('Y-m-d'));
        }
        
        // Filter berdasarkan poliklinik
        if (!empty($filter['id_poliklinik'])) {
            $this->db->where('antrian.id_poliklinik', $filter['id_poliklinik']);
        }
        
        // Filter berdasarkan dokter
        if (!empty($filter['id_dokter'])) {
            $this->db->where('antrian.id_dokter', $filter['id_dokter']);
        }
        
        // Filter berdasarkan status
        if (!empty($filter['status'])) {
            $this->db->where('antrian.status', $filter['status']);
        }
        
        // Urutkan berdasarkan nomor antrian
        $this->db->order_by('antrian.no_antrian', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mendapatkan detail antrian berdasarkan ID
     * 
     * @param int $id_antrian ID antrian
     * @return object
     */
    public function get_antrian_by_id($id_antrian) {
        $this->db->select('antrian.*, pasien.nama_lengkap as nama_pasien, poliklinik.nama_poli as nama_poli, pengguna.nama_lengkap as nama_dokter');
        $this->db->from('antrian');
        $this->db->join('pasien', 'pasien.id_pasien = antrian.id_pasien', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = antrian.id_poliklinik', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = antrian.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->where('antrian.id_antrian', $id_antrian);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Mendapatkan jumlah antrian hari ini berdasarkan poliklinik
     * 
     * @param int $id_poliklinik ID poliklinik
     * @param string $tanggal Tanggal antrian (default hari ini)
     * @return int
     */
    public function count_antrian_by_poli($id_poliklinik, $tanggal = NULL) {
        $this->db->from('antrian');
        $this->db->where('id_poliklinik', $id_poliklinik);
        
        if ($tanggal) {
            $this->db->where('tanggal', $tanggal);
        } else {
            $this->db->where('tanggal', date('Y-m-d'));
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Mendapatkan antrian yang sedang menunggu hari ini
     * 
     * @param int $id_poliklinik ID poliklinik
     * @param string $tanggal Tanggal antrian (default hari ini)
     * @return array
     */
    public function get_waiting_antrian($id_poliklinik, $tanggal = NULL) {
        $this->db->select('antrian.*, pasien.nama_lengkap as nama_pasien, poliklinik.nama_poli as nama_poli');
        $this->db->from('antrian');
        $this->db->join('pasien', 'pasien.id_pasien = antrian.id_pasien', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = antrian.id_poliklinik', 'left');
        $this->db->where('antrian.id_poliklinik', $id_poliklinik);
        $this->db->where('antrian.status', 'menunggu');
        
        if ($tanggal) {
            $this->db->where('antrian.tanggal', $tanggal);
        } else {
            $this->db->where('antrian.tanggal', date('Y-m-d'));
        }
        
        $this->db->order_by('antrian.no_antrian', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mendapatkan antrian yang sedang diperiksa hari ini
     * 
     * @param int $id_poliklinik ID poliklinik
     * @param string $tanggal Tanggal antrian (default hari ini)
     * @return array
     */
    public function get_current_antrian($id_poliklinik, $tanggal = NULL) {
        $this->db->select('antrian.*, pasien.nama_lengkap as nama_pasien, poliklinik.nama_poli as nama_poli, pengguna.nama_lengkap as nama_dokter');
        $this->db->from('antrian');
        $this->db->join('pasien', 'pasien.id_pasien = antrian.id_pasien', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = antrian.id_poliklinik', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = antrian.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->where('antrian.id_poliklinik', $id_poliklinik);
        $this->db->where('antrian.status', 'diperiksa');
        
        if ($tanggal) {
            $this->db->where('antrian.tanggal', $tanggal);
        } else {
            $this->db->where('antrian.tanggal', date('Y-m-d'));
        }
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Menambahkan data antrian baru
     * 
     * @param array $data Data antrian
     * @return int ID antrian yang baru dibuat
     */
    public function create_antrian($data) {
        // Generate nomor antrian jika belum ada
        if (empty($data['no_antrian'])) {
            $data['no_antrian'] = $this->generate_no_antrian($data['tanggal'], $data['id_poliklinik']);
        }
        
        // Tambahkan waktu daftar
        $data['waktu_daftar'] = date('Y-m-d H:i:s');
        
        // Default status adalah menunggu
        if (empty($data['status'])) {
            $data['status'] = 'menunggu';
        }
        
        // Tambahkan timestamp dan user yang membuat
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $this->db->insert('antrian', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data antrian
     * 
     * @param int $id_antrian ID antrian
     * @param array $data Data antrian yang diupdate
     * @return bool
     */
    public function update_antrian($id_antrian, $data) {
        // Tambahkan timestamp dan user yang mengupdate
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');
        
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->update('antrian', $data);
    }
    
    /**
     * Membatalkan antrian
     * 
     * @param int $id_antrian ID antrian
     * @return bool
     */
    public function cancel_antrian($id_antrian) {
        $data = array(
            'status' => 'batal',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        );
        
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->update('antrian', $data);
    }
    
    /**
     * Mengubah status antrian menjadi "diperiksa"
     * 
     * @param int $id_antrian ID antrian
     * @return bool
     */
    public function start_periksa($id_antrian) {
        $data = array(
            'status' => 'diperiksa',
            'waktu_mulai' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        );
        
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->update('antrian', $data);
    }
    
    /**
     * Mengubah status antrian menjadi "selesai"
     * 
     * @param int $id_antrian ID antrian
     * @return bool
     */
    public function finish_periksa($id_antrian) {
        $data = array(
            'status' => 'selesai',
            'waktu_selesai' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        );
        
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->update('antrian', $data);
    }
    
    /**
     * Generate nomor antrian baru
     * 
     * @param string $tanggal Tanggal antrian
     * @param int $id_poliklinik ID poliklinik
     * @return string Nomor antrian dengan format KODE_POLI-XXX
     */
    private function generate_no_antrian($tanggal, $id_poliklinik) {
        // Dapatkan kode poli
        $this->db->select('kode_poli');
        $this->db->from('poliklinik');
        $this->db->where('id_poli', $id_poliklinik);
        $poli = $this->db->get()->row();
        
        if (!$poli) {
            return '000'; // Return default jika poli tidak ditemukan
        }
        
        $kode_poli = $poli->kode_poli;
        
        // Cari nomor terakhir untuk poli dan tanggal tersebut
        $this->db->select('no_antrian');
        $this->db->from('antrian');
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_poliklinik', $id_poliklinik);
        $this->db->where('status !=', 'batal');
        $this->db->order_by('id_antrian', 'DESC');
        $this->db->limit(1);
        
        $last = $this->db->get()->row();
        
        if ($last) {
            // Jika ada antrian sebelumnya, ambil nomor dan increment
            $parts = explode('-', $last->no_antrian);
            $last_number = isset($parts[1]) ? intval($parts[1]) : 0;
            $next_number = $last_number + 1;
        } else {
            // Jika belum ada antrian, mulai dari 1
            $next_number = 1;
        }
        
        // Format nomor dengan leading zeros (3 digit)
        return $kode_poli . '-' . sprintf('%03d', $next_number);
    }
    
    /**
     * Menghapus data antrian
     * 
     * @param int $id_antrian ID antrian
     * @return bool
     */
    public function delete_antrian($id_antrian) {
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->delete('antrian');
    }
} 