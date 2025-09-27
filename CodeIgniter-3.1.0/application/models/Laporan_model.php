<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Method lama untuk laporan penjualan
    public function get_penjualan_per_bulan($bulan, $tahun) {
        $this->db->select('
            bk.tanggal_keluar,
            b.nama_barang,
            j.nama_jenis,
            bk.jumlah as total_terjual,
            bk.harga_jual as rata_harga_jual,
            bk.total as total_pendapatan
        ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->join('jenis_barang j', 'b.id_jenis = j.id', 'left');
        $this->db->where('MONTH(bk.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(bk.tanggal_keluar)', $tahun);
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_total_penjualan_bulanan($bulan, $tahun) {
        $this->db->select('
            SUM(bk.total) as total_penjualan,
            SUM(bk.jumlah) as total_barang_terjual,
            COUNT(DISTINCT bk.id_barang) as jumlah_jenis_barang
        ');
        $this->db->from('barang_keluar bk');
        $this->db->where('MONTH(bk.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(bk.tanggal_keluar)', $tahun);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    // METHOD BARU: LAPORAN LABA/RUGI
    public function get_laba_rugi_per_bulan($bulan, $tahun) {
        $this->db->select('
            bk.tanggal_keluar,
            b.nama_barang,
            j.nama_jenis,
            bk.jumlah,
            b.harga_beli,
            bk.harga_jual,
            (bk.harga_jual - b.harga_beli) as laba_per_unit,
            bk.total as total_penjualan,
            (b.harga_beli * bk.jumlah) as total_harga_beli,
            (bk.total - (b.harga_beli * bk.jumlah)) as laba_rugi
        ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->join('jenis_barang j', 'b.id_jenis = j.id', 'left');
        $this->db->where('MONTH(bk.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(bk.tanggal_keluar)', $tahun);
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_total_laba_rugi_bulanan($bulan, $tahun) {
        $this->db->select('
            SUM(bk.total) as total_penjualan,
            SUM(b.harga_beli * bk.jumlah) as total_harga_beli,
            SUM(bk.total - (b.harga_beli * bk.jumlah)) as total_laba_rugi,
            SUM(bk.jumlah) as total_barang_terjual,
            COUNT(DISTINCT bk.id_barang) as jumlah_jenis_barang,
            AVG(bk.harga_jual - b.harga_beli) as rata_rata_laba_per_unit
        ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->where('MONTH(bk.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(bk.tanggal_keluar)', $tahun);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_barang_masuk_per_bulan($bulan, $tahun) {
        $this->db->select('
            bm.tanggal_masuk,
            b.nama_barang,
            bm.jumlah as total_masuk,
            bm.total as total_pengeluaran
        ');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b', 'bm.id_barang = b.id');
        $this->db->where('MONTH(bm.tanggal_masuk)', $bulan);
        $this->db->where('YEAR(bm.tanggal_masuk)', $tahun);
        $this->db->order_by('bm.tanggal_masuk', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}
?>