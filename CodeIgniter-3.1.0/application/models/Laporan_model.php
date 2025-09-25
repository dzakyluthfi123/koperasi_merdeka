<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_penjualan_per_bulan($bulan, $tahun) {
        $this->db->select('
            bk.tanggal_keluar,
            DAY(bk.tanggal_keluar) as hari,
            b.nama_barang,
            j.nama_jenis,
            SUM(bk.jumlah) as total_terjual,
            SUM(bk.total) as total_pendapatan,
            AVG(bk.harga_jual) as rata_harga_jual
        ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->join('jenis_barang j', 'b.id_jenis = j.id');
        $this->db->where('MONTH(bk.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(bk.tanggal_keluar)', $tahun);
        $this->db->group_by('bk.id_barang, bk.tanggal_keluar');
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        
        return $this->db->get()->result();
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
        
        return $this->db->get()->row();
    }
    
    public function get_barang_masuk_per_bulan($bulan, $tahun) {
        $this->db->select('
            bm.tanggal_masuk,
            b.nama_barang,
            SUM(bm.jumlah) as total_masuk,
            SUM(bm.total) as total_pengeluaran
        ');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b', 'bm.id_barang = b.id');
        $this->db->where('MONTH(bm.tanggal_masuk)', $bulan);
        $this->db->where('YEAR(bm.tanggal_masuk)', $tahun);
        $this->db->group_by('bm.id_barang, bm.tanggal_masuk');
        
        return $this->db->get()->result();
    }
}
?>