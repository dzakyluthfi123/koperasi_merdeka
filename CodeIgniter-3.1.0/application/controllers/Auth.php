<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }
    
    // Halaman Login
    public function login() {
        // Jika user sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Login';
        
        $this->load->view('templates/header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/footer');
    }
    
    // Proses Login
    public function proses_login() {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username/Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username dan password harus diisi!');
            redirect('auth/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->User_model->login($username, $password);
            
            if ($user) {
                // Set session data
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'nama_lengkap' => $user->nama_lengkap,
                    'role' => $user->role,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                
                // Redirect berdasarkan role
                if ($user->role == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('dashboard');
                }
                
            } else {
                $this->session->set_flashdata('error', 'Username/Email atau password salah!');
                redirect('auth/login');
            }
        }
    }
    
    // Halaman Register
    public function register() {
        // Jika user sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Register';
        
        $this->load->view('templates/header', $data);
        $this->load->view('auth/register');
        $this->load->view('templates/footer');
    }
    
    // Proses Register
    public function proses_register() {
        // Validasi form
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[3]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        } else {
            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'user' // Default role
            );
            
            if ($this->User_model->register($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal! Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }
    
    // Logout
    public function logout() {
        // Hapus session data
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('logged_in');
        
        $this->session->set_flashdata('success', 'Anda berhasil logout!');
        redirect('auth/login');
    }
}
?>