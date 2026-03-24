<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('category_model');
    }

    public function index() {
        $data['products'] = $this->product_model->get_all();
        $data['categories'] = $this->category_model->get_all();
        $data['title'] = 'Produk';
        
        $this->load->view('layout/header', $data);
        $this->load->view('products/index', $data);
        $this->load->view('layout/footer');
    }

    public function store() {
        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'stock' => $this->input->post('stock')
        ];
        
        $this->product_model->insert($data);
        
        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan!');
        redirect('products');
    }

    public function update($id) {
        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'stock' => $this->input->post('stock')
        ];
        
        $this->product_model->update($id, $data);
        
        $this->session->set_flashdata('success', 'Produk berhasil diperbarui!');
        redirect('products');
    }

    public function delete($id) {
        $this->product_model->delete($id);
        
        $this->session->set_flashdata('success', 'Produk berhasil dihapus!');
        redirect('products');
    }
}
