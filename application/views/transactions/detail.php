<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><?= $title ?></h2>
        <a href="<?= base_url('transactions/history') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    
    <!-- Transaction Info -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">No. Invoice</td>
                            <td><strong><?= $transaction->invoice_number ?></strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($transaction->created_at)) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Subtotal</td>
                            <td>Rp <?= number_format($transaction->subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td>
                                <?php if ($transaction->discount_amount > 0): ?>
                                    <?php if ($transaction->discount_type === 'percentage'): ?>
                                        <?= $transaction->discount_value ?>%
                                    <?php endif; ?>
                                    (Rp <?= number_format($transaction->discount_amount, 0, ',', '.') ?>)
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong class="text-primary">Rp <?= number_format($transaction->total_amount, 0, ',', '.') ?></strong></td>
                        </tr>
                        <tr>
                            <td>Pembayaran</td>
                            <td>Rp <?= number_format($transaction->payment_amount, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>Kembalian</td>
                            <td class="text-success">Rp <?= number_format($transaction->change_amount, 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transaction Items -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Item Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($items as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->product_name ?></td>
                                <td>Rp <?= number_format($item->price, 0, ',', '.') ?></td>
                                <td><?= $item->quantity ?></td>
                                <td>Rp <?= number_format($item->subtotal, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
