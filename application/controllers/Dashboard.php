<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 * 
 * Controller untuk menampilkan halaman dashboard
 * 
 * @property CI_Session $session
 * @property Surat_model $Surat_model
 * @property Pasien_model $Pasien_model
 * @property Kunjungan_model $Kunjungan_model
 * @property Dokter_model $Dokter_model
 */
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Cek apakah pengguna sudah login
        check_auth();
        
        $this->load->model('Surat_model');
        $this->load->model('Pasien_model');
        $this->load->model('Kunjungan_model');
        $this->load->model('Dokter_model');
        $this->load->helper(['date', 'auth']);
    }
    
    /**
     * Halaman Dashboard
     */
    public function index() {
        $data['title'] = 'Dashboard';
        
        // Mengambil data untuk statistik
        $data['total_surat'] = $this->Surat_model->count_all_surat();
        $data['total_pasien'] = $this->Pasien_model->count_all_pasien();
        $data['total_kunjungan'] = $this->Kunjungan_model->count_all_kunjungan();
        $data['total_dokter'] = $this->Dokter_model->count_all_dokter();
        
        // Mendapatkan data user yang sedang login
        $data['user'] = get_current_user();
        
        // Tampilkan view sesuai dengan role pengguna
        $view = 'dashboard/index';
        
        // Jika rolenya spesifik, bisa load view dashboard khusus
        if ($this->session->userdata('role') == 2) { // Role 2 = Dokter
            $view = 'dashboard/dokter';
        } elseif ($this->session->userdata('role') == 4) { // Role 4 = Apoteker
            $view = 'dashboard/apoteker';
        }
        
        $this->load->view($view, $data);
    }
} 