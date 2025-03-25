<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk mengelola rekam medis pasien
 */
class Rekam_medis_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan data rekam medis pasien
     * 
     * @param int $id_pasien ID pasien
     * @return object
     */
    public function get_rekam_medis_by_pasien($id_pasien) {
        $this->db->select('rekam_medis.*, pasien.nama_lengkap as nama_pasien');
        $this->db->from('rekam_medis');
        $this->db->join('pasien', 'pasien.id_pasien = rekam_medis.id_pasien', 'left');
        $this->db->where('rekam_medis.id_pasien', $id_pasien);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Mendapatkan data rekam medis berdasarkan ID
     * 
     * @param int $id_rekam_medis ID rekam medis
     * @return object
     */
    public function get_rekam_medis_by_id($id_rekam_medis) {
        $this->db->select('rekam_medis.*, pasien.nama_lengkap as nama_pasien');
        $this->db->from('rekam_medis');
        $this->db->join('pasien', 'pasien.id_pasien = rekam_medis.id_pasien', 'left');
        $this->db->where('rekam_medis.id_rekam_medis', $id_rekam_medis);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Mendapatkan data rekam medis berdasarkan nomor rekam medis
     * 
     * @param string $no_rekam_medis Nomor rekam medis
     * @return object
     */
    public function get_rekam_medis_by_no($no_rekam_medis) {
        $this->db->select('rekam_medis.*, pasien.nama_lengkap as nama_pasien');
        $this->db->from('rekam_medis');
        $this->db->join('pasien', 'pasien.id_pasien = rekam_medis.id_pasien', 'left');
        $this->db->where('rekam_medis.no_rekam_medis', $no_rekam_medis);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Menambahkan data rekam medis baru
     * 
     * @param array $data Data rekam medis
     * @return int ID rekam medis yang baru dibuat
     */
    public function create_rekam_medis($data) {
        // Generate nomor rekam medis jika belum ada
        if (empty($data['no_rekam_medis'])) {
            $data['no_rekam_medis'] = $this->generate_no_rekam_medis();
        }
        
        // Tambahkan timestamp dan user yang membuat
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $this->db->insert('rekam_medis', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data rekam medis
     * 
     * @param int $id_rekam_medis ID rekam medis
     * @param array $data Data rekam medis yang diupdate
     * @return bool
     */
    public function update_rekam_medis($id_rekam_medis, $data) {
        // Tambahkan timestamp dan user yang mengupdate
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');
        
        $this->db->where('id_rekam_medis', $id_rekam_medis);
        return $this->db->update('rekam_medis', $data);
    }
    
    /**
     * Generate nomor rekam medis baru
     * 
     * @return string
     */
    private function generate_no_rekam_medis() {
        // Format: RM-YYMM-XXXX (XXXX adalah nomor urut)
        $date_code = date('ym');
        
        // Cari nomor urut terakhir untuk bulan ini
        $this->db->select('RIGHT(no_rekam_medis, 4) as last_num');
        $this->db->from('rekam_medis');
        $this->db->where('SUBSTRING(no_rekam_medis, 4, 4)', $date_code);
        $this->db->order_by('RIGHT(no_rekam_medis, 4)*1', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get();
        $row = $query->row();
        
        if ($row) {
            // Jika sudah ada nomor sebelumnya, tambahkan 1
            $next_num = intval($row->last_num) + 1;
        } else {
            // Jika belum ada, mulai dari 1
            $next_num = 1;
        }
        
        // Format dengan padding 4 digit
        $formatted_num = sprintf('%04d', $next_num);
        
        return 'RM-' . $date_code . '-' . $formatted_num;
    }
    
    /**
     * Mendapatkan riwayat kunjungan pasien
     * 
     * @param int $id_pasien ID pasien
     * @param int $limit Batas jumlah data
     * @param int $offset Offset data
     * @return array
     */
    public function get_riwayat_kunjungan($id_pasien, $limit = NULL, $offset = NULL) {
        $this->db->select('kunjungan.*, pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli');
        $this->db->from('kunjungan');
        $this->db->join('dokter', 'dokter.id_dokter = kunjungan.id_dokter', 'left');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->join('poliklinik', 'poliklinik.id_poliklinik = kunjungan.id_poliklinik', 'left');
        $this->db->where('kunjungan.id_pasien', $id_pasien);
        $this->db->order_by('kunjungan.tanggal', 'DESC');
        $this->db->order_by('kunjungan.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mendapatkan detail tindakan yang dilakukan pada kunjungan
     * 
     * @param int $id_kunjungan ID kunjungan
     * @return array
     */
    public function get_tindakan_kunjungan($id_kunjungan) {
        $this->db->select('tindakan_kunjungan.*, tindakan.nama_tindakan');
        $this->db->from('tindakan_kunjungan');
        $this->db->join('tindakan', 'tindakan.id_tindakan = tindakan_kunjungan.id_tindakan', 'left');
        $this->db->where('tindakan_kunjungan.id_kunjungan', $id_kunjungan);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mendapatkan detail obat yang diberikan pada kunjungan
     * 
     * @param int $id_kunjungan ID kunjungan
     * @return array
     */
    public function get_obat_kunjungan($id_kunjungan) {
        $this->db->select('obat_kunjungan.*, obat.nama_obat, obat.satuan');
        $this->db->from('obat_kunjungan');
        $this->db->join('obat', 'obat.id_obat = obat_kunjungan.id_obat', 'left');
        $this->db->where('obat_kunjungan.id_kunjungan', $id_kunjungan);
        
        $query = $this->db->get();
        return $query->result();
    }
} 