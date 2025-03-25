<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poliklinik_model extends CI_Model {
    
    private $table = 'poliklinik';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data poliklinik
     */
    public function get_all_poli($limit = NULL, $offset = NULL) {
        $this->db->order_by('nama_poli', 'ASC');
        
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan jumlah total poliklinik
     */
    public function count_all_poli() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan data poliklinik berdasarkan ID
     * 
     * @param int $id_poli ID poliklinik
     * @return object
     */
    public function get_poli_by_id($id_poli) {
        $this->db->where('id_poli', $id_poli);
        $query = $this->db->get('poliklinik');
        return $query->row();
    }
    
    /**
     * Mendapatkan data poliklinik berdasarkan kode
     */
    public function get_poli_by_kode($kode_poli) {
        return $this->db->get_where($this->table, ['kode_poli' => $kode_poli])->row();
    }
    
    /**
     * Menyimpan data poliklinik
     */
    public function save_poli($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data poliklinik
     */
    public function update_poli($id_poli, $data) {
        $this->db->where('id_poli', $id_poli);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Menghapus data poliklinik
     */
    public function delete_poli($id_poli) {
        $this->db->where('id_poli', $id_poli);
        return $this->db->delete($this->table);
    }
    
    /**
     * Mendapatkan data poliklinik untuk dropdown
     */
    public function get_dropdown() {
        $this->db->select('id_poli, nama_poli');
        // Hapus filter status untuk debug
        //$this->db->where('status', 'aktif');
        $this->db->order_by('nama_poli', 'ASC');
        $query = $this->db->get($this->table);
        
        $data = [];
        
        // Debug query and result
        error_log('Poliklinik dropdown query: ' . $this->db->last_query());
        error_log('Poliklinik dropdown result count: ' . $query->num_rows());
        
        foreach ($query->result() as $row) {
            $data[$row->id_poli] = $row->nama_poli;
            error_log('Poliklinik item: ' . $row->id_poli . ' - ' . $row->nama_poli);
        }
        
        return $data;
    }
    
    /**
     * Mendapatkan data poliklinik untuk dropdown
     */
    public function get_dropdown_poli() {
        $data = $this->get_dropdown();
        error_log('Poliklinik dropdown_poli count: ' . count($data));
        return $data;
    }
} 