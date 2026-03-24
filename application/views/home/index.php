<div class="container-fluid px-4">
    <h2 class="mb-4"><?= $title ?></h2>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Penjualan Hari Ini</h6>
                            <h3 class="mb-0">Rp <?= number_format($today_total, 0, ',', '.') ?></h3>
                        </div>
                        <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Transaksi Hari Ini</h6>
                            <h3 class="mb-0"><?= $today_transactions ?></h3>
                        </div>
                        <i class="bi bi-receipt" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Produk</h6>
                            <h3 class="mb-0"><?= $total_products ?></h3>
                        </div>
                        <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Kategori</h6>
                            <h3 class="mb-0"><?= $total_categories ?></h3>
                        </div>
                        <i class="bi bi-tags" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('transactions/pos') ?>" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-cart-plus"></i> Mulai Transaksi
                    </a>
                    <a href="<?= base_url('products') ?>" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </a>
                    <a href="<?= base_url('categories') ?>" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recent_transactions)): ?>
                        <p class="text-muted text-center py-4">Belum ada transaksi hari ini</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Invoice</th>
                                        <th>Total</th>
                                        <th>Pembayaran</th>
                                        <th>Kembalian</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_transactions as $transaction): ?>
                                        <tr>
                                            <td><?= $transaction->invoice_number ?></td>
                                            <td>Rp <?= number_format($transaction->total_amount, 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($transaction->payment_amount, 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($transaction->change_amount, 0, ',', '.') ?></td>
                                            <td><?= date('H:i:s', strtotime($transaction->created_at)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
