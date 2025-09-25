<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluar_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_keluar() {
        $this->db->select('bk.*, b.nama_barang, b.kode_barang');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->order_by('bk.tanggal_keluar', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_keluar_by_id($id) {
        $this->db->select('bk.*, b.nama_barang, b.kode_barang');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.id_barang = b.id');
        $this->db->where('bk.id', $id);
        return $this->db->get()->row();
    }
    
    public function insert_barang_keluar($data) {
        $this->db->insert('barang_keluar', $data);
        return $this->db->insert_id();
    }
    
    public function update_barang_keluar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('barang_keluar', $data);
    }
    
    public function delete_barang_keluar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('barang_keluar');
    }
}
?>