<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
   // application/models/Barang_model.php
public function get_all_barang() {
    $this->db->select('b.*, j.nama_jenis');
    $this->db->from('barang b');
    $this->db->join('jenis_barang j', 'b.id_jenis = j.id', 'left');
    $this->db->order_by('b.nama_barang', 'ASC');
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return array(); // Return array kosong jika tidak ada data
    }
}
    
    public function get_barang_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('barang')->row();
    }
    
    public function insert_barang($data) {
        $this->db->insert('barang', $data);
        return $this->db->insert_id();
    }
    
    public function update_barang($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('barang', $data);
    }
    
    public function delete_barang($id) {
        $this->db->where('id', $id);
        return $this->db->delete('barang');
    }
    
    public function update_stok($id_barang, $jumlah) {
        $this->db->set('stok', 'stok + ' . $jumlah, FALSE);
        $this->db->where('id', $id_barang);
        return $this->db->update('barang');
    }
}
?>