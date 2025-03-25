<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk mengelola surat-surat klinik
 * 
 * @property CI_DB_query_builder $db Database
 * @property CI_Input $input Input
 * @property CI_Form_validation $form_validation Form validation
 * @property CI_Session $session Session
 * @property Surat_model $Surat_model Model Surat
 * @property Template_surat_model $template_surat Model Template Surat
 * @property CI_Pdf $pdf Library PDF
 */
class Surat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Surat_model');
        $this->load->model('Template_surat_model', 'template_surat');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    /**
     * Halaman utama modul surat
     */
    public function index() {
        $data['title'] = 'Daftar Surat';
        $data['surat'] = $this->Surat_model->get_all_surat();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Halaman pembuatan surat baru
     */
    public function buat($kode_template = '') {
        $data['title'] = 'Buat Surat Baru';
        
        // Jika tidak ada kode template yang dipilih, tampilkan halaman pilih template
        if (empty($kode_template)) {
            $data['templates'] = $this->template_surat->get_all_templates();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('surat/pilih_template', $data);
            $this->load->view('templates/footer');
            return;
        }
        
        // Cek apakah template tersedia
        $template = $this->template_surat->get_template($kode_template);
        if (!$template) {
            $this->session->set_flashdata('error', 'Template surat tidak ditemukan!');
            redirect('surat');
        }
        
        // Setup form validation
        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('tanggal_surat', 'Tanggal Surat', 'required');
        
        // Load data untuk dropdown
        $data['pasien'] = $this->Surat_model->get_pasien_dropdown();
        $data['dokter'] = $this->Surat_model->get_dokter_dropdown();
        $data['template'] = $template;
        $data['kode_template'] = $kode_template;
        
        // Jika form disubmit
        if ($this->form_validation->run() === TRUE) {
            // Kumpulkan data form
            $parameter_surat = $this->input->post('param');
            
            // Generate nomor surat
            $no_surat = $this->Surat_model->generate_nomor_surat($kode_template);
            
            // Data untuk tabel cetak_surat
            $surat_data = [
                'no_surat' => $no_surat,
                'kode_template' => $kode_template,
                'tanggal_surat' => $this->input->post('tanggal_surat'),
                'id_pasien' => $this->input->post('id_pasien'),
                'id_dokter' => $this->input->post('id_dokter'),
                'id_rekam_medis' => $this->input->post('id_rekam_medis') ?: NULL,
                'parameter_surat' => json_encode($parameter_surat),
                'isi_surat_final' => $this->template_surat->render_template($kode_template, $parameter_surat),
                'tanggal_mulai' => $this->input->post('tanggal_mulai') ?: NULL,
                'tanggal_selesai' => $this->input->post('tanggal_selesai') ?: NULL,
                'lama_waktu' => $this->input->post('lama_waktu') ?: NULL,
                'diagnosa' => $this->input->post('diagnosa') ?: NULL,
                'tujuan' => $this->input->post('tujuan') ?: NULL,
                'keterangan' => $this->input->post('keterangan') ?: NULL,
                'id_pengguna' => 1, // TODO: Ganti dengan ID pengguna yang login
                'dibuat_pada' => date('Y-m-d H:i:s')
            ];
            
            // Simpan ke database
            $id_surat = $this->Surat_model->save_surat($surat_data);
            
            if ($id_surat) {
                $this->session->set_flashdata('success', 'Surat berhasil dibuat!');
                redirect('surat/lihat/' . $id_surat);
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat surat!');
            }
        }
        
        $data['placeholder'] = $this->template_surat->get_placeholder($kode_template);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat/buat', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Mendapatkan field dari template surat (untuk AJAX)
     */
    public function get_template_fields($template_id) {
        $fields = $this->template_surat->get_template_fields($template_id);
        
        // Return JSON
        header('Content-Type: application/json');
        echo json_encode($fields);
    }
    
    /**
     * Lihat detail surat
     */
    public function lihat($id_surat) {
        $data['title'] = 'Detail Surat';
        $data['surat'] = $this->Surat_model->get_surat_by_id($id_surat);
        
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('surat');
        }
        
        $data['template'] = $this->template_surat->get_template($data['surat']->kode_template);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('surat/lihat', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Cetak surat
     */
    public function cetak($id_surat) {
        $surat = $this->Surat_model->get_surat_by_id($id_surat);
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('surat');
        }
        
        // Load mpdf library
        $this->load->library('pdf');
        
        $data['surat'] = $surat;
        $data['template'] = $this->template_surat->get_template($surat->kode_template);
        
        // Setup PDF
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10
        ]);
        
        // Add header
        if ($data['template']['kop_surat']) {
            $mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">
                <h2>KLINIK MEDIKA</h2>
                <p>Jl. Contoh No. 123, Kota, Indonesia</p>
                <p>Telp: 021-12345678 | Email: info@klinikmedika.com</p>
                <hr>
            </div>');
        }
        
        // Render PDF
        $mpdf->WriteHTML($surat->isi_surat_final);
        
        // Output
        $mpdf->Output($surat->no_surat . '.pdf', 'I');
    }
    
    /**
     * Hapus surat
     */
    public function hapus($id_surat) {
        $surat = $this->Surat_model->get_surat_by_id($id_surat);
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan!');
            redirect('surat');
        }
        
        if ($this->Surat_model->delete_surat($id_surat)) {
            $this->session->set_flashdata('success', 'Surat berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus surat!');
        }
        
        redirect('surat');
    }
} 