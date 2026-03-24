<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('product_model');
        $this->load->model('category_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['today_total'] = $this->transaction_model->get_today_total();
        $data['today_transactions'] = count($this->transaction_model->get_today());
        $data['total_products'] = count($this->product_model->get_all());
        $data['total_categories'] = count($this->category_model->get_all());
        $data['recent_transactions'] = $this->transaction_model->get_today();
        
        $this->load->view('layout/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layout/footer');
    }
}
