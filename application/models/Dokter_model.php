<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter_model extends CI_Model {
    
    private $table = 'dokter';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data dokter
     */
    public function get_all_dokter($limit = NULL, $offset = NULL) {
        $this->db->select('dokter.*, pengguna.nama_lengkap, pengguna.email, pengguna.no_telp');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan jumlah total dokter
     */
    public function count_all_dokter() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan data dokter berdasarkan ID
     */
    public function get_dokter_by_id($id_dokter) {
        $this->db->select('dokter.*, pengguna.nama_lengkap, pengguna.email, pengguna.no_telp');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('dokter.id_dokter', $id_dokter);
        return $this->db->get()->row();
    }
    
    /**
     * Mendapatkan data dokter berdasarkan ID pengguna
     */
    public function get_dokter_by_user_id($id_pengguna) {
        $this->db->select('dokter.*, pengguna.nama_lengkap, pengguna.email, pengguna.no_telp');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('dokter.id_pengguna', $id_pengguna);
        return $this->db->get()->row();
    }
    
    /**
     * Menyimpan data dokter
     */
    public function save_dokter($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data dokter
     */
    public function update_dokter($id_dokter, $data) {
        $this->db->where('id_dokter', $id_dokter);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Menghapus data dokter
     */
    public function delete_dokter($id_dokter) {
        $this->db->where('id_dokter', $id_dokter);
        return $this->db->delete($this->table);
    }
    
    /**
     * Mendapatkan data dokter untuk dropdown
     */
    public function get_dropdown() {
        $this->db->select('dokter.id_dokter, pengguna.nama_lengkap, dokter.gelar_depan, dokter.gelar_belakang, dokter.spesialis');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('dokter.status_praktek', 'Aktif');
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        $query = $this->db->get();
        
        $data = [];
        foreach ($query->result() as $row) {
            $nama_dokter = '';
            
            if (!empty($row->gelar_depan)) {
                $nama_dokter .= $row->gelar_depan . ' ';
            }
            
            $nama_dokter .= $row->nama_lengkap;
            
            if (!empty($row->gelar_belakang)) {
                $nama_dokter .= ', ' . $row->gelar_belakang;
            }
            
            if (!empty($row->spesialis)) {
                $nama_dokter .= ' - ' . $row->spesialis;
            }
            
            $data[$row->id_dokter] = $nama_dokter;
        }
        
        return $data;
    }
    
    /**
     * Mencari dokter berdasarkan keyword
     */
    public function search_dokter($keyword) {
        $this->db->select('dokter.*, pengguna.nama_lengkap, pengguna.email, pengguna.no_telp');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->like('pengguna.nama_lengkap', $keyword);
        $this->db->or_like('dokter.spesialis', $keyword);
        $this->db->or_like('dokter.sip', $keyword);
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan data pengguna untuk dropdown dokter
     */
    public function get_pengguna_dropdown() {
        $this->db->select('pengguna.id_pengguna, pengguna.nama_lengkap');
        $this->db->from('pengguna');
        $this->db->join('dokter', 'pengguna.id_pengguna = dokter.id_pengguna', 'left');
        $this->db->where('pengguna.id_role', 2); // ID role untuk dokter, sesuaikan dengan data di tabel role
        $this->db->where('pengguna.status', 'aktif');
        $this->db->where('dokter.id_dokter IS NULL'); // Hanya yang belum terdaftar sebagai dokter
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        $query = $this->db->get();
        
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->id_pengguna] = $row->nama_lengkap;
        }
        
        return $data;
    }

    /**
     * Menghitung jumlah dokter berdasarkan status
     */
    public function count_dokter_by_status($status) {
        $this->db->where('status_praktek', $status);
        return $this->db->count_all_results($this->table);
    }

    /**
     * Mendapatkan data dokter untuk dropdown
     */
    public function get_dropdown_dokter() {
        $this->db->select('dokter.id_dokter, pengguna.nama_lengkap');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('dokter.status_praktek', 'Aktif');
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        $query = $this->db->get();
        
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->id_dokter] = $row->nama_lengkap;
        }
        
        return $data;
    }

    /**
     * Mendapatkan dokter berdasarkan ID poliklinik
     * 
     * @param int $id_poliklinik ID poliklinik
     * @return array
     */
    public function get_dokter_by_poliklinik($id_poliklinik) {
        $this->db->select('DISTINCT(dokter.id_dokter), pengguna.nama_lengkap, dokter.spesialis, dokter.gelar_depan, dokter.gelar_belakang');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->join('jadwal_dokter', 'jadwal_dokter.id_dokter = dokter.id_dokter');
        $this->db->where('jadwal_dokter.id_poli', $id_poliklinik);
        $this->db->where('dokter.status_praktek', 'aktif');
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan semua data dokter dengan format sederhana
     * 
     * @return array
     */
    public function get_all_dokter_simple() {
        $this->db->select('dokter.id_dokter, pengguna.nama_lengkap, dokter.spesialis');
        $this->db->from('dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('dokter.status_praktek', 'aktif');
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        
        return $this->db->get()->result();
    }
} 