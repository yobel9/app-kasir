<div class="container-fluid px-4">
    <h2 class="mb-4"><?= $title ?></h2>
    
    <!-- Add Product Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </button>
    
    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($products)): ?>
                <p class="text-muted text-center py-4">Belum ada produk. Tambahkan produk pertama Anda!</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $product->name ?></td>
                                    <td><?= $product->category_name ?: '-' ?></td>
                                    <td>Rp <?= number_format($product->price, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($product->stock > 0): ?>
                                            <span class="badge bg-success"><?= $product->stock ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $product->id ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('products/delete/' . $product->id) ?>', 'Hapus Produk?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $product->id ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= base_url('products/update/' . $product->id) ?>" method="post">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" name="name" value="<?= $product->name ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kategori</label>
                                                        <select class="form-select" name="category_id">
                                                            <option value="">Pilih Kategori</option>
                                                            <?php foreach ($categories as $category): ?>
                                                                <option value="<?= $category->id ?>" <?= $product->category_id == $category->id ? 'selected' : '' ?>><?= $category->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Harga</label>
                                                        <input type="number" class="form-control" name="price" value="<?= $product->price ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Stok</label>
                                                        <input type="number" class="form-control" name="stock" value="<?= $product->stock ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('products/store') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category_id">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stock" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
