<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_masuk() {
        $this->db->select('bm.*, b.nama_barang, b.kode_barang');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b', 'bm.id_barang = b.id');
        $this->db->order_by('bm.tanggal_masuk', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_masuk_by_id($id) {
        $this->db->select('bm.*, b.nama_barang, b.kode_barang');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b', 'bm.id_barang = b.id');
        $this->db->where('bm.id', $id);
        return $this->db->get()->row();
        return $this->db->get_where('barang_masuk', array('id' => $id))->row();
    }
    
    
    public function insert_barang_masuk($data) {
        $this->db->insert('barang_masuk', $data);
        return $this->db->insert_id();
    }
    
    public function update_barang_masuk($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('barang_masuk', $data);
    }
    
    public function delete_barang_masuk($id) {
        $this->db->where('id', $id);
        return $this->db->delete('barang_masuk');
    }

    
    public function delete_masuk($id) {
        return $this->db->delete('barang_masuk', ['id' => $id]);
    }
    
}
?>