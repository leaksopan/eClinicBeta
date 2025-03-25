<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_model extends CI_Model {
    
    private $table = 'tindakan_master';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data tindakan
     */
    public function get_all_tindakan($limit = NULL, $offset = NULL) {
        $this->db->order_by('nama_tindakan', 'ASC');
        
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan jumlah total tindakan
     */
    public function count_all_tindakan() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan data tindakan berdasarkan ID
     */
    public function get_tindakan_by_id($id_tindakan) {
        return $this->db->get_where($this->table, ['id_tindakan_master' => $id_tindakan])->row();
    }
    
    /**
     * Mendapatkan data tindakan untuk dropdown
     */
    public function get_dropdown() {
        $this->db->select('id_tindakan_master, nama_tindakan, tarif');
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_tindakan', 'ASC');
        return $this->db->get($this->table)->result();
    }
}