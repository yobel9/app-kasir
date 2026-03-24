<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index() {
        $data['categories'] = $this->category_model->get_all();
        $data['title'] = 'Kategori Produk';
        
        $this->load->view('layout/header', $data);
        $this->load->view('categories/index', $data);
        $this->load->view('layout/footer');
    }

    public function store() {
        $data = [
            'name' => $this->input->post('name')
        ];
        
        $this->category_model->insert($data);
        
        $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan!');
        redirect('categories');
    }

    public function update($id) {
        $data = [
            'name' => $this->input->post('name')
        ];
        
        $this->category_model->update($id, $data);
        
        $this->session->set_flashdata('success', 'Kategori berhasil diperbarui!');
        redirect('categories');
    }

    public function delete($id) {
        $this->category_model->delete($id);
        
        $this->session->set_flashdata('success', 'Kategori berhasil dihapus!');
        redirect('categories');
    }
}
