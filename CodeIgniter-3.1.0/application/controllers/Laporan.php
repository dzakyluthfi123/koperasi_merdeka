<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    // Fungsi untuk mendapatkan nama bulan
    private function get_nama_bulan($bulan_angka) {
        $bulan_list = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return isset($bulan_list[$bulan_angka]) ? $bulan_list[$bulan_angka] : 'Bulan ' . $bulan_angka;
    }
    
    public function penjualan_bulanan() {
        $bulan = $this->input->post('bulan') ?: date('n'); // Menggunakan 'n' untuk bulan tanpa leading zero
        $tahun = $this->input->post('tahun') ?: date('Y');
        
        $data['title'] = 'Laporan Penjualan Bulanan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['nama_bulan'] = $this->get_nama_bulan($bulan); // Tambahkan nama bulan
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        
        // Tambahkan bulan_list untuk view
        $data['bulan_list'] = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/penjualan_bulanan', $data);
        $this->load->view('templates/footer');
    }
    
    public function print_penjualan($bulan, $tahun) {
        $data['title'] = 'Laporan Penjualan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['nama_bulan'] = $this->get_nama_bulan($bulan); // Tambahkan nama bulan
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        
        // Tambahkan bulan_list untuk view print
        $data['bulan_list'] = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $this->load->view('laporan/print_penjualan', $data);
    }
}
?>