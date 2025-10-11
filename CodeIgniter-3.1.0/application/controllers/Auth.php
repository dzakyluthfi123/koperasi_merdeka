<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library(['session', 'form_validation']); // Load form_validation
        $this->load->helper(['url', 'form']); // Load form helper
    }
    
    public function index() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data = array();
        $this->load->view('login_view', $data);
    }
    
    public function login() {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form login lagi
            $data = array();
            $this->load->view('login_view', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            // Cek login
            $user = $this->Auth_model->login($username, $password);
            
            if ($user) {
                // Set session
                $session_data = array(
                    'username' => $username,
                    'nama' => $user['nama'],
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                
                // Redirect ke halaman dashboard
                redirect('dashboard');
            } else {
                // Jika login gagal
                $data['error'] = 'Username atau password salah!';
                $this->load->view('login_view', $data);
            }
        }
    }
    
    public function logout() {
        // Hapus session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy(); // Hancurkan session sepenuhnya
        
        // Redirect ke halaman login
        redirect('dashboard');
    }
}
?>