<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('transactions')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('transactions', ['id' => $id])->row();
    }

    public function get_today() {
        $today = date('Y-m-d');
        return $this->db->where("date(created_at) = '$today'")->order_by('created_at', 'DESC')->get('transactions')->result();
    }

    public function get_today_total() {
        $today = date('Y-m-d');
        $this->db->select_sum('total_amount');
        $this->db->where("date(created_at) = '$today'");
        $result = $this->db->get('transactions')->row();
        return $result->total_amount ? $result->total_amount : 0;
    }

    public function generate_invoice_number() {
        $date = date('Ymd');
        $this->db->like('invoice_number', 'INV-' . $date);
        $this->db->order_by('invoice_number', 'DESC');
        $last = $this->db->get('transactions', 1)->row();
        
        if ($last) {
            $last_number = intval(substr($last->invoice_number, -4));
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return 'INV-' . $date . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }

    public function insert($data) {
        $this->db->insert('transactions', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('transactions', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('transactions');
    }
}
