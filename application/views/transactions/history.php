<div class="container-fluid px-4">
    <h2 class="mb-4"><?= $title ?></h2>
    
    <!-- Transactions Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($transactions)): ?>
                <p class="text-muted text-center py-4">Belum ada transaksi</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Invoice</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Kembalian</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $transaction->invoice_number ?></td>
                                    <td>Rp <?= number_format($transaction->subtotal, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($transaction->discount_amount > 0): ?>
                                            <?php if ($transaction->discount_type === 'percentage'): ?>
                                                <?= $transaction->discount_value ?>%
                                            <?php else: ?>
                                                Rp
                                            <?php endif; ?>
                                            (<?= number_format($transaction->discount_amount, 0, ',', '.') ?>)
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><strong>Rp <?= number_format($transaction->total_amount, 0, ',', '.') ?></strong></td>
                                    <td>Rp <?= number_format($transaction->payment_amount, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($transaction->change_amount, 0, ',', '.') ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($transaction->created_at)) ?></td>
                                    <td>
                                        <a href="<?= base_url('transactions/detail/' . $transaction->id) ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('transactions/delete/' . $transaction->id) ?>', 'Hapus Transaksi?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
