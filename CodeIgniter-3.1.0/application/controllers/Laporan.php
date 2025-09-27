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
        
        // Validasi bulan (pastikan antara 1-12)
        $bulan = max(1, min(12, (int)$bulan));
        
        $data['title'] = 'Laporan Penjualan Bulanan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        $data['bulan_list'] = $this->get_bulan_list();
        
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/penjualan_bulanan', $data);
        $this->load->view('templates/footer');
    }
    
    // METHOD BARU: LAPORAN LABA/RUGI
    public function laba_rugi() {
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        
        // Validasi bulan (pastikan antara 1-12)
        $bulan = max(1, min(12, (int)$bulan));
        
        $data['title'] = 'Laporan Laba Rugi';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['laba_rugi'] = $this->Laporan_model->get_laba_rugi_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_laba_rugi_bulanan($bulan, $tahun);
        $data['bulan_list'] = $this->get_bulan_list();
        
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/laba_rugi', $data);
        $this->load->view('templates/footer');
    }
    
    public function print_penjualan($bulan, $tahun) {
        // Validasi bulan
        $bulan = max(1, min(12, (int)$bulan));
        
        $data['title'] = 'Laporan Penjualan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['penjualan'] = $this->Laporan_model->get_penjualan_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_penjualan_bulanan($bulan, $tahun);
        $data['bulan_list'] = $this->get_bulan_list();
        
        $this->load->view('laporan/print_penjualan', $data);
    }
    
    // METHOD BARU: PRINT LAPORAN LABA/RUGI
    public function print_laba_rugi($bulan, $tahun) {
        // Validasi bulan
        $bulan = max(1, min(12, (int)$bulan));
        
        $data['title'] = 'Laporan Laba Rugi';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['laba_rugi'] = $this->Laporan_model->get_laba_rugi_per_bulan($bulan, $tahun);
        $data['total'] = $this->Laporan_model->get_total_laba_rugi_bulanan($bulan, $tahun);
        $data['bulan_list'] = $this->get_bulan_list();
        
        $this->load->view('laporan/print_laba_rugi', $data);
    }
    
    private function get_bulan_list() {
        return [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
    }
}
?>