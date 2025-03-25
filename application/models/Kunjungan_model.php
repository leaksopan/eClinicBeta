<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola kunjungan pasien
 */
class Kunjungan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data kunjungan
     * 
     * @param int $limit Batas jumlah data
     * @param int $offset Offset data
     * @param array $filter Filter data
     * @return array
     */
    public function get_all_kunjungan($limit = NULL, $offset = NULL, $filter = array()) {
        // Join dengan tabel pasien, dokter, dan poliklinik
        $this->db->select('
            kunjungan.*,
            pasien.nama_lengkap as nama_pasien, 
            pasien.no_rm,
            pengguna.nama_lengkap as nama_dokter,
            poliklinik.nama_poli
        ');
        $this->db->from('kunjungan');
        $this->db->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = kunjungan.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = kunjungan.id_poliklinik', 'left');
        
        // Filter berdasarkan parameter
        if (!empty($filter['id_pasien'])) {
            $this->db->where('kunjungan.id_pasien', $filter['id_pasien']);
        }
        
        if (!empty($filter['id_dokter'])) {
            $this->db->where('kunjungan.id_dokter', $filter['id_dokter']);
        }
        
        if (!empty($filter['id_poliklinik'])) {
            $this->db->where('kunjungan.id_poliklinik', $filter['id_poliklinik']);
        }
        
        if (!empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir'])) {
            $this->db->where('kunjungan.tanggal >=', $filter['tanggal_awal']);
            $this->db->where('kunjungan.tanggal <=', $filter['tanggal_akhir']);
        } elseif (!empty($filter['tanggal'])) {
            $this->db->where('kunjungan.tanggal', $filter['tanggal']);
        }
        
        if (!empty($filter['status'])) {
            $this->db->where('kunjungan.status', $filter['status']);
        }
        
        // Urutkan berdasarkan tanggal terbaru
        $this->db->order_by('kunjungan.tanggal', 'DESC');
        $this->db->order_by('kunjungan.created_at', 'DESC');
        
        // Batasi jumlah data jika diperlukan
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mendapatkan jumlah kunjungan dengan filter
     * 
     * @param array $filter Filter data
     * @return int
     */
    public function count_all_kunjungan($filter = array()) {
        $this->db->from('kunjungan');
        
        // Filter berdasarkan parameter
        if (!empty($filter['id_pasien'])) {
            $this->db->where('id_pasien', $filter['id_pasien']);
        }
        
        if (!empty($filter['id_dokter'])) {
            $this->db->where('id_dokter', $filter['id_dokter']);
        }
        
        if (!empty($filter['id_poliklinik'])) {
            $this->db->where('id_poliklinik', $filter['id_poliklinik']);
        }
        
        if (!empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir'])) {
            $this->db->where('tanggal >=', $filter['tanggal_awal']);
            $this->db->where('tanggal <=', $filter['tanggal_akhir']);
        } elseif (!empty($filter['tanggal'])) {
            $this->db->where('tanggal', $filter['tanggal']);
        }
        
        if (!empty($filter['status'])) {
            $this->db->where('status', $filter['status']);
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Mendapatkan detail kunjungan berdasarkan ID
     * 
     * @param int $id_kunjungan ID kunjungan
     * @return object
     */
    public function get_kunjungan_by_id($id_kunjungan) {
        $this->db->select('
            kunjungan.*,
            pasien.nama_lengkap as nama_pasien, 
            pasien.no_rm,
            pengguna.nama_lengkap as nama_dokter,
            poliklinik.nama_poli
        ');
        $this->db->from('kunjungan');
        $this->db->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = kunjungan.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = kunjungan.id_poliklinik', 'left');
        $this->db->where('kunjungan.id_kunjungan', $id_kunjungan);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Mendapatkan detail kunjungan berdasarkan nomor kunjungan
     * 
     * @param string $no_kunjungan Nomor kunjungan
     * @return object
     */
    public function get_kunjungan_by_no($no_kunjungan) {
        $this->db->select('
            kunjungan.*,
            pasien.nama_lengkap as nama_pasien, 
            pasien.no_rm,
            pengguna.nama_lengkap as nama_dokter,
            poliklinik.nama_poli
        ');
        $this->db->from('kunjungan');
        $this->db->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien', 'left');
        $this->db->join('dokter', 'dokter.id_dokter = kunjungan.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poli = kunjungan.id_poliklinik', 'left');
        $this->db->where('kunjungan.no_kunjungan', $no_kunjungan);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Menambahkan data kunjungan baru
     * 
     * @param array $data Data kunjungan
     * @return int ID kunjungan yang baru dibuat
     */
    public function create_kunjungan($data) {
        // Generate nomor kunjungan jika belum ada
        if (empty($data['no_kunjungan'])) {
            $data['no_kunjungan'] = $this->generate_no_kunjungan($data['tanggal']);
        }
        
        // Tambahkan timestamp dan user yang membuat
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $this->db->insert('kunjungan', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data kunjungan
     * 
     * @param int $id_kunjungan ID kunjungan
     * @param array $data Data kunjungan yang diupdate
     * @return bool
     */
    public function update_kunjungan($id_kunjungan, $data) {
        // Tambahkan timestamp dan user yang mengupdate
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');
        
        $this->db->where('id_kunjungan', $id_kunjungan);
        return $this->db->update('kunjungan', $data);
    }
    
    /**
     * Menghapus data kunjungan
     * 
     * @param int $id_kunjungan ID kunjungan
     * @return bool
     */
    public function delete_kunjungan($id_kunjungan) {
        // Soft delete dengan mengubah status
        $data = array(
            'status' => 'batal',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        );
        
        $this->db->where('id_kunjungan', $id_kunjungan);
        return $this->db->update('kunjungan', $data);
    }
    
    /**
     * Generate nomor kunjungan baru
     * 
     * @param string $tanggal Tanggal kunjungan (format Y-m-d)
     * @return string
     */
    private function generate_no_kunjungan($tanggal) {
        // Format: KJ-YYYYMMDD-XXX (XXX adalah nomor urut dalam hari)
        $date_code = date('Ymd', strtotime($tanggal));
        
        // Gunakan metode alternatif dengan native SQL
        $sql = "SELECT RIGHT(no_kunjungan, 3) as last_num 
                FROM kunjungan 
                WHERE SUBSTRING(no_kunjungan, 4, 8) = ? 
                ORDER BY CONVERT(RIGHT(no_kunjungan, 3), UNSIGNED INTEGER) DESC 
                LIMIT 1";
        
        $query = $this->db->query($sql, array($date_code));
        $row = $query->row();
        
        if ($row) {
            // Jika sudah ada nomor sebelumnya, tambahkan 1
            $next_num = intval($row->last_num) + 1;
        } else {
            // Jika belum ada, mulai dari 1
            $next_num = 1;
        }
        
        // Format dengan padding 3 digit
        $formatted_num = sprintf('%03d', $next_num);
        
        return 'KJ-' . $date_code . '-' . $formatted_num;
    }
    
    /**
     * Mendapatkan riwayat kunjungan pasien
     * 
     * @param int $id_pasien ID pasien
     * @param int $limit Batas jumlah data
     * @return array
     */
    public function get_riwayat_kunjungan_pasien($id_pasien, $limit = NULL) {
        $this->db->select('kunjungan.*, pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli');
        $this->db->from('kunjungan');
        $this->db->join('dokter', 'dokter.id_dokter = kunjungan.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poliklinik = kunjungan.id_poliklinik', 'left');
        $this->db->where('kunjungan.id_pasien', $id_pasien);
        $this->db->order_by('kunjungan.tanggal', 'DESC');
        $this->db->order_by('kunjungan.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
} 