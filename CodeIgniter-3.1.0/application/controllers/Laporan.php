<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    public function penjualan_bulanan() {
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        
        $data['title'] = 'Laporan Penjualan Bulanan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/penjualan_bulanan', $data);
        $this->load->view('templates/footer');
    }
    
    public function print_penjualan($bulan, $tahun) {
        $data['title'] = 'Laporan Penjualan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        
        $this->load->view('laporan/print_penjualan', $data);
    }
}
?>