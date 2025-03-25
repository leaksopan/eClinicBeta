<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Mendapatkan data user berdasarkan ID
     * 
     * @param int $id_pengguna
     * @return object|null
     */
    public function get_user_by_id($id_pengguna) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from('pengguna');
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->where('pengguna.id_pengguna', $id_pengguna);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Mendapatkan data user berdasarkan username
     * 
     * @param string $username
     * @return object|null
     */
    public function get_user_by_username($username) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from('pengguna');
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->where('LOWER(pengguna.username)', strtolower($username));
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Mendapatkan data user berdasarkan email
     * 
     * @param string $email
     * @return object|null
     */
    public function get_user_by_email($email) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from('pengguna');
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->where('LOWER(pengguna.email)', strtolower($email));
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Mendapatkan semua data user
     * 
     * @param array $filter
     * @return array
     */
    public function get_all_users($filter = array()) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from('pengguna');
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        
        // Filter berdasarkan status
        if (isset($filter['status']) && $filter['status'] != '') {
            $this->db->where('pengguna.status', $filter['status']);
        }
        
        // Filter berdasarkan role
        if (isset($filter['id_role']) && $filter['id_role'] != '') {
            $this->db->where('pengguna.id_role', $filter['id_role']);
        }
        
        // Filter berdasarkan pencarian
        if (isset($filter['search']) && $filter['search'] != '') {
            $this->db->group_start();
            $this->db->like('pengguna.nama_lengkap', $filter['search']);
            $this->db->or_like('pengguna.username', $filter['search']);
            $this->db->or_like('pengguna.email', $filter['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Membuat user baru
     * 
     * @param array $data
     * @return int|bool
     */
    public function create_user($data) {
        $this->db->insert('pengguna', $data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        
        return false;
    }
    
    /**
     * Mengupdate data user
     * 
     * @param int $id_pengguna
     * @param array $data
     * @return bool
     */
    public function update_user($id_pengguna, $data) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->update('pengguna', $data);
        
        return ($this->db->affected_rows() > 0);
    }
    
    /**
     * Menghapus user
     * 
     * @param int $id_pengguna
     * @return bool
     */
    public function delete_user($id_pengguna) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->delete('pengguna');
        
        return ($this->db->affected_rows() > 0);
    }
    
    /**
     * Memeriksa apakah username sudah digunakan
     * 
     * @param string $username
     * @param int $id_exclude ID pengguna yang dikecualikan (opsional)
     * @return bool
     */
    public function is_username_exist($username, $id_exclude = null) {
        $this->db->where('LOWER(username)', strtolower($username));
        
        if ($id_exclude !== null) {
            $this->db->where('id_pengguna !=', $id_exclude);
        }
        
        $query = $this->db->get('pengguna');
        
        return ($query->num_rows() > 0);
    }
    
    /**
     * Memeriksa apakah email sudah digunakan
     * 
     * @param string $email
     * @param int $id_exclude ID pengguna yang dikecualikan (opsional)
     * @return bool
     */
    public function is_email_exist($email, $id_exclude = null) {
        $this->db->where('LOWER(email)', strtolower($email));
        
        if ($id_exclude !== null) {
            $this->db->where('id_pengguna !=', $id_exclude);
        }
        
        $query = $this->db->get('pengguna');
        
        return ($query->num_rows() > 0);
    }
} 