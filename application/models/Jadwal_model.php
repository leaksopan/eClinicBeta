<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {
    
    private $table = 'jadwal_dokter';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data jadwal dokter
     */
    public function get_all_jadwal($limit = NULL, $offset = NULL) {
        $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                          pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli, poliklinik.lokasi');
        $this->db->from($this->table);
        $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->order_by('jadwal_dokter.hari', 'ASC');
        $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan jumlah total jadwal dokter
     */
    public function count_all_jadwal() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan jadwal dokter berdasarkan ID
     */
    public function get_jadwal_by_id($id_jadwal) {
        $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                          pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli, poliklinik.lokasi');
        $this->db->from($this->table);
        $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->where('jadwal_dokter.id_jadwal', $id_jadwal);
        return $this->db->get()->row();
    }
    
    /**
     * Mendapatkan jadwal dokter berdasarkan ID dokter
     */
    public function get_jadwal_by_dokter($id_dokter) {
        $this->db->select('jadwal_dokter.id_jadwal, jadwal_dokter.id_dokter, jadwal_dokter.id_poli, jadwal_dokter.hari, 
                         jadwal_dokter.jam_mulai, jadwal_dokter.jam_selesai, jadwal_dokter.kuota_pasien, 
                         jadwal_dokter.status, jadwal_dokter.keterangan, poliklinik.nama_poli, poliklinik.lokasi');
        $this->db->from($this->table);
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->where('jadwal_dokter.id_dokter', $id_dokter);
        $this->db->order_by('jadwal_dokter.hari', 'ASC');
        $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan jadwal dokter berdasarkan ID poli
     */
    public function get_jadwal_by_poli($id_poli) {
        $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                          pengguna.nama_lengkap as nama_dokter');
        $this->db->from($this->table);
        $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->where('jadwal_dokter.id_poli', $id_poli);
        $this->db->where('jadwal_dokter.status', 'aktif');
        $this->db->order_by('jadwal_dokter.hari', 'ASC');
        $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan jadwal dokter berdasarkan hari
     */
    public function get_jadwal_by_hari($hari) {
        $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                          pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli, poliklinik.lokasi');
        $this->db->from($this->table);
        $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->where('jadwal_dokter.hari', $hari);
        $this->db->where('jadwal_dokter.status', 'aktif');
        $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
        $this->db->order_by('poliklinik.nama_poli', 'ASC');
        return $this->db->get()->result();
    }
    
    /**
     * Menyimpan data jadwal dokter
     */
    public function save_jadwal($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data jadwal dokter
     */
    public function update_jadwal($id_jadwal, $data) {
        $this->db->where('id_jadwal', $id_jadwal);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Menghapus data jadwal dokter
     */
    public function delete_jadwal($id_jadwal) {
        $this->db->where('id_jadwal', $id_jadwal);
        return $this->db->delete($this->table);
    }
    
    /**
     * Cek apakah jadwal dokter tersedia
     */
    public function is_jadwal_available($id_dokter, $hari, $jam_mulai, $jam_selesai, $id_jadwal = NULL) {
        $this->db->from($this->table);
        $this->db->where('id_dokter', $id_dokter);
        $this->db->where('hari', $hari);
        $this->db->group_start();
        
        // Cek apakah ada jadwal yang overlap dengan jadwal baru
        $this->db->group_start();
        $this->db->where('jam_mulai <=', $jam_mulai);
        $this->db->where('jam_selesai >', $jam_mulai);
        $this->db->group_end();
        
        $this->db->or_group_start();
        $this->db->where('jam_mulai <', $jam_selesai);
        $this->db->where('jam_selesai >=', $jam_selesai);
        $this->db->group_end();
        
        $this->db->or_group_start();
        $this->db->where('jam_mulai >', $jam_mulai);
        $this->db->where('jam_selesai <', $jam_selesai);
        $this->db->group_end();
        
        $this->db->group_end();
        
        // Exclude current jadwal if updating
        if ($id_jadwal !== NULL) {
            $this->db->where('id_jadwal !=', $id_jadwal);
        }
        
        $query = $this->db->get();
        
        return $query->num_rows() == 0;
    }
    
    /**
     * Memeriksa apakah ada konflik jadwal dokter
     */
    public function check_jadwal_conflict($id_dokter, $hari, $jam_mulai, $jam_selesai, $current_id = null) {
        $this->db->from($this->table);
        $this->db->where('id_dokter', $id_dokter);
        $this->db->where('hari', $hari);
        $this->db->group_start();
        
        // Cek apakah ada jadwal yang overlap dengan jadwal baru
        $this->db->group_start();
        $this->db->where('jam_mulai <=', $jam_mulai);
        $this->db->where('jam_selesai >', $jam_mulai);
        $this->db->group_end();
        
        $this->db->or_group_start();
        $this->db->where('jam_mulai <', $jam_selesai);
        $this->db->where('jam_selesai >=', $jam_selesai);
        $this->db->group_end();
        
        $this->db->or_group_start();
        $this->db->where('jam_mulai >=', $jam_mulai);
        $this->db->where('jam_selesai <=', $jam_selesai);
        $this->db->group_end();
        
        $this->db->group_end();
        
        // Exclude current jadwal if updating
        if ($current_id !== NULL) {
            $this->db->where('id_jadwal !=', $current_id);
        }
        
        $query = $this->db->get();
        
        return $query->num_rows() > 0;
    }
    
    /**
     * Mendapatkan daftar hari
     */
    public function get_hari() {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }
    
    /**
     * Mendapatkan jadwal dokter hari ini
     */
    public function get_jadwal_hari_ini() {
        // Mendapatkan indeks hari ini (0: Minggu, 1: Senin, dst)
        $hari_index = date('w');
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari_ini = $days[$hari_index];
        
        // Query untuk mendapatkan jadwal hari ini
        $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                          pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli, poliklinik.lokasi');
        $this->db->from($this->table);
        $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
        $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->where('jadwal_dokter.hari', $hari_ini);
        $this->db->where('jadwal_dokter.status', 'aktif');
        $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
        
        $result = $this->db->get()->result();
        
        // Jika tidak ada jadwal untuk hari ini, ambil jadwal beberapa hari ke depan
        if (empty($result)) {
            // Urutkan hari mulai dari hari ini + 1 dan seterusnya
            $next_days = [];
            for ($i = 1; $i <= 7; $i++) {
                $next_index = ($hari_index + $i) % 7;
                $next_days[] = $days[$next_index];
            }
            
            $day_priority = "FIELD(jadwal_dokter.hari, '" . implode("', '", $next_days) . "')";
            
            $this->db->select('jadwal_dokter.*, dokter.id_pengguna, dokter.spesialis, dokter.tarif_konsultasi, 
                              pengguna.nama_lengkap as nama_dokter, poliklinik.nama_poli, poliklinik.lokasi');
            $this->db->from($this->table);
            $this->db->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter');
            $this->db->join('pengguna', 'pengguna.id_pengguna = dokter.id_pengguna');
            $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
            $this->db->where('jadwal_dokter.status', 'aktif');
            $this->db->order_by($day_priority, FALSE);
            $this->db->order_by('jadwal_dokter.jam_mulai', 'ASC');
            $this->db->limit(5);
            $result = $this->db->get()->result();
        }
        
        return $result;
    }
    
    /**
     * Menghitung jumlah jadwal dokter dengan status aktif
     */
    public function count_jadwal_aktif() {
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Mendapatkan jadwal dokter berdasarkan ID dokter dan hari
     * 
     * @param int $id_dokter ID dokter
     * @param int $hari Hari dalam bentuk angka (0: Minggu, 1: Senin, dst)
     * @return object
     */
    public function get_jadwal_by_dokter_hari($id_dokter, $hari) {
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari_text = $days[$hari];
        
        $this->db->select('jadwal_dokter.*, poliklinik.nama_poli');
        $this->db->from($this->table);
        $this->db->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli');
        $this->db->where('jadwal_dokter.id_dokter', $id_dokter);
        $this->db->where('jadwal_dokter.hari', $hari_text);
        $this->db->where('jadwal_dokter.status', 'aktif');
        
        return $this->db->get()->row();
    }
    
    /**
     * Memeriksa apakah ada overlap waktu jadwal pada hari yang sama
     * 
     * @param int $id_dokter ID dokter
     * @param string $hari Hari praktek
     * @param string $jam_mulai Jam mulai
     * @param string $jam_selesai Jam selesai
     * @param int|null $current_id ID jadwal saat ini (untuk edit)
     * @return bool TRUE jika ada overlap, FALSE jika tidak
     */
    public function check_time_overlap($id_dokter, $hari, $jam_mulai, $jam_selesai, $current_id = null) {
        $this->db->from($this->table);
        $this->db->where('id_dokter', $id_dokter);
        $this->db->where('hari', $hari);
        
        // Cek overlap waktu:
        // 1. Jika jadwal baru mulai di tengah-tengah jadwal yang sudah ada
        // 2. Jika jadwal baru selesai di tengah-tengah jadwal yang sudah ada
        // 3. Jika jadwal baru mencakup jadwal yang sudah ada
        $this->db->group_start();
            $this->db->group_start();
                $this->db->where('jam_mulai <=', $jam_mulai);
                $this->db->where('jam_selesai >', $jam_mulai);
            $this->db->group_end();
            
            $this->db->or_group_start();
                $this->db->where('jam_mulai <', $jam_selesai);
                $this->db->where('jam_selesai >=', $jam_selesai);
            $this->db->group_end();
            
            $this->db->or_group_start();
                $this->db->where('jam_mulai >=', $jam_mulai);
                $this->db->where('jam_selesai <=', $jam_selesai);
            $this->db->group_end();
        $this->db->group_end();
        
        // Exclude jadwal saat ini jika sedang edit
        if ($current_id !== null) {
            $this->db->where('id_jadwal !=', $current_id);
        }
        
        return $this->db->count_all_results() > 0;
    }
} 