<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_item_model extends CI_Model {

    public function get_by_transaction($transaction_id) {
        $this->db->select('transaction_items.*, products.name as product_name, products.price as product_price');
        $this->db->from('transaction_items');
        $this->db->join('products', 'products.id = transaction_items.product_id');
        $this->db->where('transaction_items.transaction_id', $transaction_id);
        return $this->db->get()->result();
    }

    public function insert($data) {
        $this->db->insert('transaction_items', $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data) {
        return $this->db->insert_batch('transaction_items', $data);
    }

    public function delete_by_transaction($transaction_id) {
        $this->db->where('transaction_id', $transaction_id);
        return $this->db->delete('transaction_items');
    }
}
