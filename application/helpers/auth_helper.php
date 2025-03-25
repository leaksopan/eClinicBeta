<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fungsi untuk memeriksa apakah pengguna sudah login
 * Akan redirect ke halaman login jika belum login
 * 
 * @return bool
 */
if (!function_exists('check_auth')) {
    function check_auth() {
        $CI =& get_instance();
        
        // Cek apakah session user_id ada
        if (!$CI->session->userdata('user_id')) {
            // Simpan URL yang dicoba diakses agar bisa diredirect kembali setelah login
            $CI->session->set_userdata('redirect_url', current_url());
            
            // Set pesan error
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
            
            // Redirect ke halaman login
            redirect('auth/login');
            return FALSE;
        }
        
        return TRUE;
    }
}

/**
 * Fungsi untuk memeriksa apakah pengguna memiliki role tertentu
 * 
 * @param string|array $roles Role yang diizinkan
 * @return bool
 */
if (!function_exists('check_role')) {
    function check_role($roles) {
        $CI =& get_instance();
        
        // Pastikan sudah login
        if (!$CI->session->userdata('user_id')) {
            return FALSE;
        }
        
        // Ambil role user saat ini
        $user_role = $CI->session->userdata('role');
        
        // Jika parameter roles adalah string, konversi ke array
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        // Periksa apakah role user ada dalam daftar role yang diizinkan
        if (in_array($user_role, $roles)) {
            return TRUE;
        }
        
        // Jika role tidak cocok, tampilkan pesan error dan redirect
        $CI->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        redirect('dashboard');
        return FALSE;
    }
}

/**
 * Fungsi untuk mendapatkan data user yang sedang login
 * 
 * @return object|null
 */
if (!function_exists('get_current_user')) {
    function get_current_user() {
        $CI =& get_instance();
        
        // Cek apakah session user_id ada
        if (!$CI->session->userdata('user_id')) {
            return NULL;
        }
        
        // Load model user
        $CI->load->model('User_model');
        
        // Ambil data user dari database
        return $CI->User_model->get_user_by_id($CI->session->userdata('user_id'));
    }
}

/**
 * Fungsi untuk mengecek apakah pengguna sudah login
 * 
 * @return bool
 */
if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        $CI =& get_instance();
        return (bool) $CI->session->userdata('user_id');
    }
} 