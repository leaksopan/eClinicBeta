<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * 
 * Controller untuk menangani autentikasi pengguna
 * 
 * @property Pengguna_model $Pengguna_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['form', 'url']);
    }
    
    /**
     * Halaman login
     */
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Login - eClinic';
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $pengguna = $this->Pengguna_model->check_login($username, $password);
            
            if ($pengguna) {
                // Set session data
                $session_data = [
                    'user_id' => $pengguna->id_pengguna,
                    'username' => $pengguna->username,
                    'nama_lengkap' => $pengguna->nama_lengkap,
                    'email' => $pengguna->email,
                    'role' => $pengguna->id_role,
                    'nama_role' => $pengguna->nama_role,
                    'is_logged_in' => TRUE
                ];
                
                $this->session->set_userdata($session_data);
                
                // Update waktu terakhir login
                $this->Pengguna_model->update_last_login($pengguna->id_pengguna);
                
                // Log aktivitas login
                $this->Pengguna_model->log_aktivitas($pengguna->id_pengguna, 'Login', 'Berhasil login ke sistem');
                
                // Cek jika ada redirect URL tersimpan
                if ($this->session->userdata('redirect_url')) {
                    $redirect_url = $this->session->userdata('redirect_url');
                    $this->session->unset_userdata('redirect_url');
                    redirect($redirect_url);
                } else {
                    redirect('dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah atau akun tidak aktif');
                redirect('auth/login');
            }
        }
    }
    
    /**
     * Lupa password
     */
    public function forgot_password() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Lupa Password - eClinic';
            $this->load->view('auth/forgot_password', $data);
        } else {
            $email = $this->input->post('email');
            $pengguna = $this->Pengguna_model->get_pengguna_by_email($email);
            
            if ($pengguna) {
                // Generate random token
                $token = bin2hex(random_bytes(32));
                $expired_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Simpan token
                $this->Pengguna_model->save_reset_token($pengguna->id_pengguna, $token, $expired_at);
                
                // Kirim email (implementasi sebenarnya akan menggunakan library email)
                // Untuk sementara hanya tampilkan pesan
                $this->session->set_flashdata('success', 'Tautan reset password telah dikirim ke email Anda. Silakan cek inbox.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar');
                redirect('auth/forgot_password');
            }
        }
    }
    
    /**
     * Logout
     */
    public function logout() {
        // Log aktivitas logout jika user_id ada di session
        if ($this->session->userdata('user_id')) {
            $this->Pengguna_model->log_aktivitas($this->session->userdata('user_id'), 'Logout', 'Berhasil logout dari sistem');
        }
        
        // Hapus session
        $this->session->unset_userdata([
            'user_id', 'username', 'nama_lengkap', 'email', 
            'role', 'nama_role', 'is_logged_in'
        ]);
        $this->session->sess_destroy();
        
        // Redirect ke halaman login
        redirect('auth/login');
    }
} 