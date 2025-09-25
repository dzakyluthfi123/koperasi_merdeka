<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_jenis() {
        return $this->db->get('jenis_barang')->result();
    }
    
    public function get_jenis_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('jenis_barang')->row();
    }
    
    public function insert_jenis($data) {
        $this->db->insert('jenis_barang', $data);
        return $this->db->insert_id();
    }
    
    public function update_jenis($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('jenis_barang', $data);
    }
    
    public function delete_jenis($id) {
        $this->db->where('id', $id);
        return $this->db->delete('jenis_barang');
    }
}
?>