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
        
        // Load helper dan library
        $this->load->helper('url');
        $this->load->library('session');
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
        if ($this->input->post()) {
            $data = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'deskripsi' => $this->input->post('deskripsi')
            );
            
            $this->Jenis_model->insert_jenis($data);
            $this->session->set_flashdata('success', 'Jenis barang berhasil ditambahkan');
            redirect('jenis-barang');
        }
        
        $data['title'] = 'Jenis Barang';
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/jenis', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_jenis() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'deskripsi' => $this->input->post('deskripsi')
            );
            
            $this->Jenis_model->update_jenis($id, $data);
            $this->session->set_flashdata('success', 'Jenis barang berhasil diupdate');
            redirect('jenis-barang');
        }
    }
    
    public function hapus_jenis($id) {
        // Cek apakah jenis barang masih digunakan
        $barang_terkait = $this->Barang_model->get_barang_by_jenis($id);
        
        if (!empty($barang_terkait)) {
            // Jika masih digunakan, set id_jenis menjadi NULL untuk barang terkait
            foreach($barang_terkait as $barang) {
                $this->Barang_model->update_barang($barang->id, array('id_jenis' => NULL));
            }
        }
        
        // Hapus jenis barang
        $result = $this->Jenis_model->delete_jenis($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Jenis barang berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jenis barang');
        }
        
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
        if ($this->input->post()) {
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
        }
        
        $data['title'] = 'Tambah Barang';
        $data['jenis'] = $this->Jenis_model->get_all_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/tambah_barang', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit_barang($id) {
        if ($this->input->post()) {
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
    
    // BARANG MASUK - VERSI FIXED
    public function barang_masuk() {
        // Load data yang diperlukan
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['masuk'] = $this->Masuk_model->get_all_masuk();
        $data['title'] = 'Barang Masuk';

        if ($this->input->post()) {
            // Validasi manual tanpa form_validation library
            $id_barang = $this->input->post('id_barang');
            $jumlah = $this->input->post('jumlah');
            $harga_beli = $this->input->post('harga_beli');
            $supplier = $this->input->post('supplier');
            $tanggal_masuk = $this->input->post('tanggal_masuk');
            
            // Validasi input
            $errors = array();
            
            if (empty($id_barang)) {
                $errors[] = 'Barang harus dipilih';
            }
            
            if (empty($jumlah) || $jumlah <= 0) {
                $errors[] = 'Jumlah harus lebih dari 0';
            }
            
            if (empty($harga_beli) || $harga_beli <= 0) {
                $errors[] = 'Harga beli harus lebih dari 0';
            }
            
            if (empty($supplier)) {
                $errors[] = 'Supplier harus diisi';
            }
            
            if (empty($tanggal_masuk)) {
                $errors[] = 'Tanggal masuk harus diisi';
            }
            
            // Jika tidak ada error, proses data
            if (empty($errors)) {
                $data_masuk = array(
                    'id_barang' => $id_barang,
                    'kode_transaksi' => 'BM-' . date('YmdHis'),
                    'jumlah' => $jumlah,
                    'harga_beli' => $harga_beli,
                    'total' => $jumlah * $harga_beli,
                    'tanggal_masuk' => $tanggal_masuk,
                    'hari_masuk' => date('l', strtotime($tanggal_masuk)),
                    'supplier' => $supplier
                );

                // Simpan data barang masuk
                $this->Masuk_model->insert_barang_masuk($data_masuk);
                
                // Update stok barang
                $this->Barang_model->update_stok($data_masuk['id_barang'], $data_masuk['jumlah']);

                $this->session->set_flashdata('success', 'Barang masuk berhasil dicatat');
                redirect('barang-masuk');
            } else {
                // Tampilkan error
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('inventory/masuk', $data);
        $this->load->view('templates/footer');
    }
    
    // BARANG KELUAR - VERSI FIXED
    public function barang_keluar() {
        if ($this->input->post()) {
            // Validasi manual
            $id_barang = $this->input->post('id_barang');
            $jumlah = $this->input->post('jumlah');
            $harga_jual = $this->input->post('harga_jual');
            $keterangan = $this->input->post('keterangan');
            $tanggal_keluar = $this->input->post('tanggal_keluar');
            
            // Validasi input
            $errors = array();
            
            if (empty($id_barang)) {
                $errors[] = 'Barang harus dipilih';
            }
            
            if (empty($jumlah) || $jumlah <= 0) {
                $errors[] = 'Jumlah harus lebih dari 0';
            }
            
            if (empty($harga_jual) || $harga_jual <= 0) {
                $errors[] = 'Harga jual harus lebih dari 0';
            }
            
            if (empty($tanggal_keluar)) {
                $errors[] = 'Tanggal keluar harus diisi';
            }
            
            // Cek stok tersedia
            if (empty($errors)) {
                $barang = $this->Barang_model->get_barang_by_id($id_barang);
                if ($barang->stok < $jumlah) {
                    $errors[] = 'Stok tidak mencukupi! Stok tersedia: ' . $barang->stok;
                }
            }
            
            // Jika tidak ada error, proses data
            if (empty($errors)) {
                $data = array(
                    'id_barang' => $id_barang,
                    'kode_transaksi' => 'BK-' . date('YmdHis'),
                    'jumlah' => $jumlah,
                    'harga_jual' => $harga_jual,
                    'total' => $jumlah * $harga_jual,
                    'tanggal_keluar' => $tanggal_keluar,
                    'hari_keluar' => date('l', strtotime($tanggal_keluar)),
                    'keterangan' => $keterangan
                );
                
                $this->Keluar_model->insert_barang_keluar($data);
                $this->Barang_model->update_stok($data['id_barang'], -$data['jumlah']);
                $this->session->set_flashdata('success', 'Barang keluar berhasil dicatat');
                redirect('barang-keluar');
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
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