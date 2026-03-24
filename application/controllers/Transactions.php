<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('transaction_item_model');
        $this->load->model('product_model');
        $this->load->model('category_model');
    }

    public function pos() {
        $data['products'] = $this->product_model->get_all();
        $data['categories'] = $this->category_model->get_all();
        $data['title'] = 'Kasir';
        
        $this->load->view('layout/header', $data);
        $this->load->view('transactions/pos', $data);
        $this->load->view('layout/footer');
    }

    public function history() {
        $data['transactions'] = $this->transaction_model->get_all();
        $data['title'] = 'Riwayat Transaksi';
        
        $this->load->view('layout/header', $data);
        $this->load->view('transactions/history', $data);
        $this->load->view('layout/footer');
    }

    public function detail($id) {
        $data['transaction'] = $this->transaction_model->get_by_id($id);
        $data['items'] = $this->transaction_item_model->get_by_transaction($id);
        $data['title'] = 'Detail Transaksi';
        
        $this->load->view('layout/header', $data);
        $this->load->view('transactions/detail', $data);
        $this->load->view('layout/footer');
    }

    public function save() {
        $items = json_decode($this->input->post('items'), true);
        
        if (empty($items)) {
            $this->session->set_flashdata('error', 'Keranjang kosong!');
            redirect('transactions/pos');
            return;
        }
        
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $discount_type = $this->input->post('discount_type');
        $discount_value = floatval($this->input->post('discount_value'));
        $discount_amount = 0;
        
        if ($discount_type === 'percentage') {
            $discount_amount = $subtotal * ($discount_value / 100);
        } elseif ($discount_type === 'fixed') {
            $discount_amount = $discount_value;
        }
        
        $total_amount = $subtotal - $discount_amount;
        $payment_amount = floatval($this->input->post('payment_amount'));
        $change_amount = $payment_amount - $total_amount;
        
        if ($change_amount < 0) {
            $this->session->set_flashdata('error', 'Pembayaran kurang!');
            redirect('transactions/pos');
            return;
        }
        
        // Generate invoice number
        $invoice_number = $this->transaction_model->generate_invoice_number();
        
        // Save transaction
        $transaction_data = [
            'invoice_number' => $invoice_number,
            'subtotal' => $subtotal,
            'discount_type' => $discount_type,
            'discount_value' => $discount_value,
            'discount_amount' => $discount_amount,
            'total_amount' => $total_amount,
            'payment_amount' => $payment_amount,
            'change_amount' => $change_amount
        ];
        
        $transaction_id = $this->transaction_model->insert($transaction_data);
        
        // Save transaction items and update stock
        foreach ($items as $item) {
            $item_data = [
                'transaction_id' => $transaction_id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
            
            $this->transaction_item_model->insert($item_data);
            
            // Update product stock
            $this->product_model->update_stock($item['id'], $item['quantity']);
        }
        
        $this->session->set_flashdata('success', 'Transaksi berhasil disimpan! Invoice: ' . $invoice_number);
        redirect('transactions/pos');
    }

    public function delete($id) {
        // Delete transaction items first
        $this->transaction_item_model->delete_by_transaction($id);
        
        // Delete transaction
        $this->transaction_model->delete($id);
        
        $this->session->set_flashdata('success', 'Transaksi berhasil dihapus!');
        redirect('transactions/history');
    }
}
