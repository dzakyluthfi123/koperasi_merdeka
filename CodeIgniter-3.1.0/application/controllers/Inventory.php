<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load models yang diperlukan
        $this->load->model('Barang_model');
        $this->load->model('Jenis_model');
        $this->load->model('Masuk_model');
        $this->load->model('Keluar_model');
        
        // Load helper dan library - PERBAIKAN: TAMBAH FORM_VALIDATION
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation'); // INI YANG DITAMBAHKAN
    }
    
    public function index() {
        $data['title'] = 'Dashboard Inventory';
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['total_barang'] = count($data['barang']);
        
        // Hitung total stok
        $total_stok = 0;
        foreach($data['barang'] as $b) {
            $total_stok += $b->stok;
        }
        $data['total_stok'] = $total_stok;
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/dashboard', $data);
        $this->load->view('templates/footer');
    }
    
    // MANAJEMEN JENIS BARANG
    public function jenis_barang() {
        if ($_POST) {
            // Validasi form - PERBAIKAN: GUNAKAN FORM_VALIDATION
            $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'nama_jenis' => $this->input->post('nama_jenis'),
                    'deskripsi' => $this->input->post('deskripsi')
                );
                
                $this->Jenis_model->insert_jenis($data);
                $this->session->set_flashdata('success', 'Jenis barang berhasil ditambahkan');
                redirect('jenis-barang');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        
        $data['title'] = 'Jenis Barang';
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/jenis', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_jenis() {
        if ($_POST) {
            // Validasi form
            $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('id');
                $data = array(
                    'nama_jenis' => $this->input->post('nama_jenis'),
                    'deskripsi' => $this->input->post('deskripsi')
                );
                
                $this->Jenis_model->update_jenis($id, $data);
                $this->session->set_flashdata('success', 'Jenis barang berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
            redirect('jenis-barang');
        }
    }
    
    public function hapus_jenis($id) {
        $this->Jenis_model->delete_jenis($id);
        $this->session->set_flashdata('success', 'Jenis barang berhasil dihapus');
        redirect('jenis-barang');
    }
    
    // MANAJEMEN BARANG
    public function barang() {
        $data['title'] = 'Data Barang';
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/barang', $data);
        $this->load->view('templates/footer');
    }
    
    public function tambah_barang() {
        if ($_POST) {
            // Validasi form
            $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
            $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
            $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'kode_barang' => $this->input->post('kode_barang'),
                    'nama_barang' => $this->input->post('nama_barang'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'stok' => $this->input->post('stok'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'harga_jual' => $this->input->post('harga_jual'),
                    'satuan' => $this->input->post('satuan'),
                    'min_stok' => $this->input->post('min_stok')
                );
                
                $this->Barang_model->insert_barang($data);
                $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
                redirect('barang');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        
        $data['title'] = 'Tambah Barang';
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/tambah_barang', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit_barang($id) {
        if ($_POST) {
            // Validasi form
            $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
            $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
            $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'kode_barang' => $this->input->post('kode_barang'),
                    'nama_barang' => $this->input->post('nama_barang'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'stok' => $this->input->post('stok'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'harga_jual' => $this->input->post('harga_jual'),
                    'satuan' => $this->input->post('satuan'),
                    'min_stok' => $this->input->post('min_stok')
                );
                
                $this->Barang_model->update_barang($id, $data);
                $this->session->set_flashdata('success', 'Barang berhasil diupdate');
                redirect('barang');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        
        $data['title'] = 'Edit Barang';
        $data['barang'] = $this->Barang_model->get_barang_by_id($id);
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/edit_barang', $data);
        $this->load->view('templates/footer');
    }
    
    public function hapus_barang($id) {
        $this->Barang_model->delete_barang($id);
        $this->session->set_flashdata('success', 'Barang berhasil dihapus');
        redirect('barang');
    }
    
    // BARANG MASUK
    public function barang_masuk() {
        // Load data yang diperlukan
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['masuk'] = $this->Masuk_model->get_all_masuk();
        $data['title'] = 'Barang Masuk';

        if ($this->input->post()) {
            // Validasi form - PERBAIKAN: INI YANG MENYEBABKAN ERROR
            $this->form_validation->set_rules('id_barang', 'Barang', 'required');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
            $this->form_validation->set_rules('supplier', 'Supplier', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data_masuk = array(
                    'id_barang' => $this->input->post('id_barang'),
                    'kode_transaksi' => 'BM-' . date('YmdHis'),
                    'jumlah' => $this->input->post('jumlah'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'total' => $this->input->post('jumlah') * $this->input->post('harga_beli'),
                    'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                    'hari_masuk' => date('l', strtotime($this->input->post('tanggal_masuk'))),
                    'supplier' => $this->input->post('supplier')
                );

                // Simpan data barang masuk
                $this->Masuk_model->insert_barang_masuk($data_masuk);
                
                // Update stok barang
                $this->Barang_model->update_stok($data_masuk['id_barang'], $data_masuk['jumlah']);

                $this->session->set_flashdata('success', 'Barang masuk berhasil dicatat');
                redirect('barang-masuk');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('inventory/masuk', $data);
        $this->load->view('templates/footer');
    }
    // HAPUS BARANG MASUK
public function hapus_masuk($id) {
    // Ambil data barang masuk sebelum dihapus
    $barang_masuk = $this->Masuk_model->get_masuk_by_id($id);
    
    if (!$barang_masuk) {
        $this->session->set_flashdata('error', 'Data barang masuk tidak ditemukan');
        redirect('barang-masuk');
    }
    
    // Kurangi stok barang (karena barang masuk dihapus, stok harus dikurangi)
    $this->Barang_model->update_stok($barang_masuk->id_barang, -$barang_masuk->jumlah);
    
    // Hapus data barang masuk
    $this->Masuk_model->delete_barang_masuk($id);
    
    $this->session->set_flashdata('success', 'Data barang masuk berhasil dihapus');
    redirect('barang-masuk');
}
    
    // BARANG KELUAR
    public function barang_keluar() {
        if ($_POST) {
            // Validasi form
            $this->form_validation->set_rules('id_barang', 'Barang', 'required');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                // Cek stok tersedia
                $barang = $this->Barang_model->get_barang_by_id($this->input->post('id_barang'));
                if ($barang->stok < $this->input->post('jumlah')) {
                    $this->session->set_flashdata('error', 'Stok tidak mencukupi! Stok tersedia: ' . $barang->stok);
                    redirect('barang-keluar');
                }
                
                $data = array(
                    'id_barang' => $this->input->post('id_barang'),
                    'kode_transaksi' => 'BK-' . date('YmdHis'),
                    'jumlah' => $this->input->post('jumlah'),
                    'harga_jual' => $this->input->post('harga_jual'),
                    'total' => $this->input->post('jumlah') * $this->input->post('harga_jual'),
                    'tanggal_keluar' => $this->input->post('tanggal_keluar'),
                    'hari_keluar' => date('l', strtotime($this->input->post('tanggal_keluar'))),
                    'keterangan' => $this->input->post('keterangan')
                );
                
                $this->Keluar_model->insert_barang_keluar($data);
                $this->Barang_model->update_stok($data['id_barang'], -$data['jumlah']);
                $this->session->set_flashdata('success', 'Barang keluar berhasil dicatat');
                redirect('barang-keluar');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        
        $data['title'] = 'Barang Keluar';
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['keluar'] = $this->Keluar_model->get_all_keluar();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/keluar', $data);
        $this->load->view('templates/footer');
    }
}
?>