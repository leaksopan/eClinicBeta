<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {
    
    private $table = 'pasien';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data pasien
     */
    public function get_all_pasien($limit = NULL, $offset = NULL) {
        $this->db->order_by('nama_lengkap', 'ASC');
        
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan jumlah total pasien
     */
    public function count_all_pasien() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan data pasien berdasarkan ID
     */
    public function get_pasien_by_id($id_pasien) {
        return $this->db->get_where($this->table, ['id_pasien' => $id_pasien])->row();
    }
    
    /**
     * Mendapatkan data pasien berdasarkan nomor RM
     */
    public function get_pasien_by_no_rm($no_rm) {
        return $this->db->get_where($this->table, ['no_rm' => $no_rm])->row();
    }
    
    /**
     * Mencari data pasien
     */
    public function search_pasien($keyword) {
        $this->db->like('nama_lengkap', $keyword);
        $this->db->or_like('no_rm', $keyword);
        $this->db->or_like('no_identitas', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telp', $keyword);
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mencari data pasien dengan pagination
     */
    public function search_pasien_paginated($keyword, $limit = NULL, $offset = NULL) {
        $this->db->like('nama_lengkap', $keyword);
        $this->db->or_like('no_rm', $keyword);
        $this->db->or_like('no_identitas', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telp', $keyword);
        
        $this->db->order_by('nama_lengkap', 'ASC');
        
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Menghitung jumlah hasil pencarian
     */
    public function count_search_results($keyword) {
        $this->db->like('nama_lengkap', $keyword);
        $this->db->or_like('no_rm', $keyword);
        $this->db->or_like('no_identitas', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telp', $keyword);
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Menyimpan data pasien baru
     */
    public function save_pasien($data) {
        // Generate nomor RM jika belum ada
        if (empty($data['no_rm'])) {
            $data['no_rm'] = $this->generate_no_rm();
        }
        
        // Pastikan jenis kelamin sesuai format database L/P
        if (isset($data['jenis_kelamin'])) {
            if ($data['jenis_kelamin'] == 'Laki-laki') {
                $data['jenis_kelamin'] = 'L';
            } else if ($data['jenis_kelamin'] == 'Perempuan') {
                $data['jenis_kelamin'] = 'P';
            }
        }
        
        // Hapus field yang tidak ada di database
        if (isset($data['created_at'])) {
            unset($data['created_at']);
        }
        
        if (isset($data['created_by'])) {
            unset($data['created_by']);
        }
        
        if (isset($data['updated_at'])) {
            unset($data['updated_at']);
        }
        
        if (isset($data['updated_by'])) {
            unset($data['updated_by']);
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data pasien
     */
    public function update_pasien($id_pasien, $data) {
        // Pastikan jenis kelamin sesuai format database L/P
        if (isset($data['jenis_kelamin'])) {
            if ($data['jenis_kelamin'] == 'Laki-laki') {
                $data['jenis_kelamin'] = 'L';
            } else if ($data['jenis_kelamin'] == 'Perempuan') {
                $data['jenis_kelamin'] = 'P';
            }
        }
        
        // Hapus field yang tidak ada di database
        if (isset($data['created_at'])) {
            unset($data['created_at']);
        }
        
        if (isset($data['created_by'])) {
            unset($data['created_by']);
        }
        
        if (isset($data['updated_at'])) {
            unset($data['updated_at']);
        }
        
        if (isset($data['updated_by'])) {
            unset($data['updated_by']);
        }
        
        $this->db->where('id_pasien', $id_pasien);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Menghapus data pasien
     */
    public function delete_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        return $this->db->delete($this->table);
    }
    
    /**
     * Generate nomor RM baru
     */
    public function generate_no_rm() {
        // Mendapatkan nomor RM terakhir
        $this->db->select_max('no_rm');
        $query = $this->db->get($this->table);
        $last_rm = $query->row()->no_rm;
        
        if (!$last_rm) {
            // Jika belum ada pasien, mulai dari 000001
            return date('y') . '00001';
        }
        
        // Ambil tahun dari nomor RM terakhir (2 digit pertama)
        $tahun_terakhir = substr($last_rm, 0, 2);
        $tahun_sekarang = date('y');
        
        if ($tahun_sekarang != $tahun_terakhir) {
            // Jika tahun berbeda, mulai dari 000001 untuk tahun baru
            return $tahun_sekarang . '00001';
        }
        
        // Jika tahun sama, increment nomor urut
        $nomor_urut = (int)substr($last_rm, 2);
        $nomor_urut++;
        
        return $tahun_sekarang . sprintf('%05d', $nomor_urut);
    }
    
    /**
     * Mendapatkan statistik pasien berdasarkan jenis kelamin
     */
    public function get_statistik_jenis_kelamin() {
        $this->db->select('jenis_kelamin, COUNT(*) as jumlah');
        $this->db->group_by('jenis_kelamin');
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan statistik pasien berdasarkan usia
     */
    public function get_statistik_usia() {
        $hasil = [
            'balita' => 0,      // 0-5 tahun
            'anak' => 0,        // 6-12 tahun
            'remaja' => 0,      // 13-17 tahun
            'dewasa' => 0,      // 18-55 tahun
            'lansia' => 0       // >55 tahun
        ];
        
        $pasien = $this->db->get($this->table)->result();
        
        foreach ($pasien as $p) {
            $tgl_lahir = new DateTime($p->tanggal_lahir);
            $today = new DateTime('today');
            $usia = $tgl_lahir->diff($today)->y;
            
            if ($usia <= 5) {
                $hasil['balita']++;
            } elseif ($usia <= 12) {
                $hasil['anak']++;
            } elseif ($usia <= 17) {
                $hasil['remaja']++;
            } elseif ($usia <= 55) {
                $hasil['dewasa']++;
            } else {
                $hasil['lansia']++;
            }
        }
        
        return $hasil;
    }
    
    /**
     * Mendapatkan pasien yang berulang tahun bulan ini
     */
    public function get_pasien_ulang_tahun() {
        $bulan_ini = date('m');
        
        $this->db->where('MONTH(tanggal_lahir)', $bulan_ini);
        $this->db->order_by('DAY(tanggal_lahir)', 'ASC');
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan data untuk dropdown
     */
    public function get_dropdown() {
        $this->db->select('id_pasien, nama_lengkap, no_rm');
        $this->db->order_by('nama_lengkap', 'ASC');
        $query = $this->db->get($this->table);
        
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->id_pasien] = $row->nama_lengkap . ' (' . $row->no_rm . ')';
        }
        
        return $data;
    }
} 