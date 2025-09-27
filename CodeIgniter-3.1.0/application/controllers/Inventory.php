<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Barang_model');
        $this->load->model('Jenis_model');
        $this->load->model('Masuk_model');
        $this->load->model('Keluar_model');
        
        
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Dashboard Inventory';
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['total_barang'] = count($data['barang']);

        $total_stok = 0;
        foreach($data['barang'] as $b) {
            $total_stok += $b->stok;
        }
        $data['total_stok'] = $total_stok;
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/dashboard', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function jenis_barang() {
        if ($_POST) {
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
        if ($_POST) {
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
        $this->Jenis_model->delete_jenis($id);
        $this->session->set_flashdata('success', 'Jenis barang berhasil dihapus');
        redirect('jenis-barang');
    }
    
   
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
        if ($_POST) {
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
    
    // BARANG MASUK
    
public function barang_masuk() {
    
    $data['barang'] = $this->Barang_model->get_all_barang();
    $data['masuk'] = $this->Masuk_model->get_all_masuk();
    $data['title'] = 'Barang Masuk';

    if ($this->input->post()) {
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

            
            $this->Masuk_model->insert_barang_masuk($data_masuk);
            
            
            $this->Barang_model->update_stok($data_masuk['id_barang'], $data_masuk['jumlah']);

            $this->session->set_flashdata('success', 'Barang masuk berhasil dicatat');
            redirect('barang-masuk');
        }
    }

    $this->load->view('templates/header', $data);
    $this->load->view('inventory/masuk', $data);
    $this->load->view('templates/footer');
}
    
    // BARANG KELUAR
    public function barang_keluar() {
        if ($_POST) {
            
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
        }
        
        $data['title'] = 'Barang Keluar';
        $data['barang'] = $this->Barang_model->get_all_barang();
        $data['keluar'] = $this->Keluar_model->get_all_keluar();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/keluar', $data);
        $this->load->view('templates/footer');
    }
    // BARANG MASUK - HAPUS
public function hapus_masuk($id) {
    
    $barang_masuk = $this->Masuk_model->get_masuk_by_id($id);
    
    if (!$barang_masuk) {
        $this->session->set_flashdata('error', 'Data barang masuk tidak ditemukan');
        redirect('barang-masuk');
    }
    
    
    $this->Barang_model->update_stok($barang_masuk->id_barang, -$barang_masuk->jumlah);
    
    
    $this->Masuk_model->delete_masuk($id);
    
    $this->session->set_flashdata('success', 'Data barang masuk berhasil dihapus');
    redirect('barang-masuk');
}
}
?>