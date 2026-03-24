<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function get_all() {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->order_by('products.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row();
    }

    public function get_by_category($category_id) {
        return $this->db->get_where('products', ['category_id' => $category_id])->result();
    }

    public function insert($data) {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    public function update_stock($id, $quantity) {
        $this->db->set('stock', 'stock - ' . $quantity, FALSE);
        $this->db->where('id', $id);
        return $this->db->update('products');
    }
}
