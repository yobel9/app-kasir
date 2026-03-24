<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('name', 'ASC')->get('categories')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('categories', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
}
