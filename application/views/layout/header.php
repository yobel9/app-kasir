<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'App Kasir' ?> - App Kasir</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container">
        <?php if ($this->session->flashdata('success')): ?>
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill"></i> <?= $this->session->flashdata('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?= $this->session->flashdata('error') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="text-center py-3">
                    <h5 class="text-white">App Kasir</h5>
                </div>
                <nav>
                    <a href="<?= base_url() ?>" class="<?= $this->uri->segment(1) == '' ? 'active' : '' ?>">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                    <a href="<?= base_url('transactions/pos') ?>" class="<?= $this->uri->segment(2) == 'pos' ? 'active' : '' ?>">
                        <i class="bi bi-cart"></i> Kasir
                    </a>
                    <a href="<?= base_url('products') ?>" class="<?= $this->uri->segment(1) == 'products' ? 'active' : '' ?>">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                    <a href="<?= base_url('categories') ?>" class="<?= $this->uri->segment(1) == 'categories' ? 'active' : '' ?>">
                        <i class="bi bi-tags"></i> Kategori
                    </a>
                    <a href="<?= base_url('transactions/history') ?>" class="<?= $this->uri->segment(2) == 'history' ? 'active' : '' ?>">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4">
