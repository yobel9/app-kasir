<div class="container-fluid px-4">
    <h2 class="mb-4"><?= $title ?></h2>
    
    <div class="row">
        <!-- Products List -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pilih Produk</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($products)): ?>
                        <p class="text-muted text-center py-4">Belum ada produk. Tambahkan produk terlebih dahulu!</p>
                    <?php else: ?>
                        <div class="row" id="productsGrid">
                            <?php foreach ($products as $product): ?>
                                <?php if ($product->stock > 0): ?>
                                    <div class="col-6 col-md-4 mb-3">
                                        <div class="card h-100 product-card" style="cursor: pointer;" onclick="addToCart(<?= $product->id ?>, '<?= addslashes($product->name) ?>', <?= $product->price ?>, <?= $product->stock ?>)">
                                            <div class="card-body text-center p-2">
                                                <h6 class="mb-1"><?= $product->name ?></h6>
                                                <p class="text-muted mb-1 small"><?= $product->category_name ?: '-' ?></p>
                                                <h5 class="text-primary mb-0">Rp <?= number_format($product->price, 0, ',', '.') ?></h5>
                                                <small class="text-success">Stok: <?= $product->stock ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Cart -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Keranjang</h5>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCart()">
                        <i class="bi bi-trash"></i> Bersihkan
                    </button>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="cartItems">
                        <p class="text-muted text-center py-4">Keranjang kosong</p>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <!-- Discount -->
                    <div class="mb-3">
                        <label class="form-label">Diskon</label>
                        <div class="input-group">
                            <select class="form-select" id="discountType" style="max-width: 120px;" onchange="calculateTotal()">
                                <option value="">Tidak Ada</option>
                                <option value="percentage">% Persen</option>
                                <option value="fixed">Rp Fixed</option>
                            </select>
                            <input type="number" class="form-control" id="discountValue" placeholder="Nilai" min="0" onchange="calculateTotal()" oninput="calculateTotal()">
                        </div>
                    </div>
                    
                    <!-- Totals -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotalDisplay">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Diskon:</span>
                        <span id="discountDisplay">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="totalDisplay" class="text-primary">Rp 0</strong>
                    </div>
                    
                    <!-- Payment -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pembayaran (Cash)</label>
                        <input type="number" class="form-control form-control-lg" id="paymentAmount" placeholder="Masukkan jumlah cash" min="0" onchange="calculateChange()" oninput="calculateChange()">
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Kembalian:</strong>
                        <strong id="changeDisplay" class="text-success">Rp 0</strong>
                    </div>
                    
                    <form id="transactionForm" action="<?= base_url('transactions/save') ?>" method="post">
                        <input type="hidden" name="items" id="cartItemsInput">
                        <input type="hidden" name="discount_type" id="discountTypeInput">
                        <input type="hidden" name="discount_value" id="discountValueInput">
                        <input type="hidden" name="payment_amount" id="paymentAmountInput">
                        <button type="submit" class="btn btn-success btn-lg w-100" id="saveBtn" disabled>
                            <i class="bi bi-check-circle"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];

function addToCart(id, name, price, maxStock) {
    // Check if product already in cart
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        if (existingItem.quantity < maxStock) {
            existingItem.quantity++;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Tidak Cukup',
                text: 'Stok produk ini hanya ' + maxStock
            });
            return;
        }
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            quantity: 1,
            maxStock: maxStock
        });
    }
    
    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
        const newQty = item.quantity + change;
        if (newQty > 0 && newQty <= item.maxStock) {
            item.quantity = newQty;
            renderCart();
        }
    }
}

function clearCart() {
    if (cart.length > 0) {
        Swal.fire({
            title: 'Bersihkan Keranjang?',
            text: 'Semua item akan dihapus dari keranjang',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, bersihkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                cart = [];
                renderCart();
            }
        });
    }
}

function renderCart() {
    const cartEl = document.getElementById('cartItems');
    
    if (cart.length === 0) {
        cartEl.innerHTML = '<p class="text-muted text-center py-4">Keranjang kosong</p>';
        calculateTotal();
        return;
    }
    
    let html = '<table class="table table-sm">';
    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        html += `
            <tr>
                <td>
                    <strong>${item.name}</strong><br>
                    <small class="text-muted">Rp ${formatNumber(item.price)} x ${item.quantity}</small>
                </td>
                <td class="text-end">
                    <strong>Rp ${formatNumber(subtotal)}</strong>
                </td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, -1)">-</button>
                    <span class="mx-2">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, 1)">+</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.id})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;
    });
    html += '</table>';
    cartEl.innerHTML = html;
    
    calculateTotal();
}

function calculateTotal() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    const discountType = document.getElementById('discountType').value;
    const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
    
    let discountAmount = 0;
    if (discountType === 'percentage') {
        discountAmount = subtotal * (discountValue / 100);
    } else if (discountType === 'fixed') {
        discountAmount = discountValue;
    }
    
    const total = subtotal - discountAmount;
    
    document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('discountDisplay').textContent = 'Rp ' + formatNumber(discountAmount);
    document.getElementById('totalDisplay').textContent = 'Rp ' + formatNumber(total);
    
    calculateChange();
}

function calculateChange() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    const discountType = document.getElementById('discountType').value;
    const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
    
    let discountAmount = 0;
    if (discountType === 'percentage') {
        discountAmount = subtotal * (discountValue / 100);
    } else if (discountType === 'fixed') {
        discountAmount = discountValue;
    }
    
    const total = subtotal - discountAmount;
    const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
    const change = payment - total;
    
    document.getElementById('changeDisplay').textContent = 'Rp ' + formatNumber(change);
    
    // Enable/disable save button
    const saveBtn = document.getElementById('saveBtn');
    if (cart.length > 0 && change >= 0) {
        saveBtn.disabled = false;
        
        // Update hidden inputs
        document.getElementById('cartItemsInput').value = JSON.stringify(cart);
        document.getElementById('discountTypeInput').value = discountType;
        document.getElementById('discountValueInput').value = discountValue;
        document.getElementById('paymentAmountInput').value = payment;
    } else {
        saveBtn.disabled = true;
    }
}

function formatNumber(num) {
    return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Prevent form submission if cart is empty
document.getElementById('transactionForm').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Keranjang Kosong',
            text: 'Tambahkan produk ke keranjang terlebih dahulu'
        });
    }
});
</script>
