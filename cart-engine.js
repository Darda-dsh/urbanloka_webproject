let cart = [];
let discount = 0;
let promoType = null;

// Sinkronisasi dengan klik produk di POS Terminal
document.addEventListener('click', function(e) {
    const target = e.target.closest('.btn-add-cart');
    if (target) {
        const id = target.dataset.id;
        const name = target.dataset.name;
        const price = parseInt(target.dataset.price);
        addToCart(id, name, price);
    }
});

function addToCart(id, name, price) {
    cart.push({ id, name, price });
    updateDiscount(); // Hitung ulang diskon tiap tambah barang
    renderCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateDiscount();
    renderCart();
}

function applyPromo(type) {
    promoType = type;
    updateDiscount();
    renderCart();
}

function updateDiscount() {
    let subtotal = cart.reduce((sum, item) => sum + item.price, 0);
    if (promoType === 'member') {
        discount = subtotal * 0.1; // Diskon 10%
    } else if (promoType === 'bundle' && cart.length >= 2) {
        discount = 50000; // Potongan 50rb
    } else {
        discount = 0;
    }
}

function renderCart() {
    const list = document.getElementById('cartItems'); // Target ID baru di POS
    const emptyMsg = document.getElementById('emptyCart');
    let subtotal = cart.reduce((sum, item) => sum + item.price, 0);
    let final = subtotal - discount;

    if (cart.length === 0) {
        list.innerHTML = '';
        if (emptyMsg) emptyMsg.style.display = 'block';
    } else {
        if (emptyMsg) emptyMsg.style.display = 'none';
        list.innerHTML = cart.map((item, index) => `
            <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: rgba(0,0,0,0.03);">
                <div style="max-width: 70%;">
                    <div class="fw-bold small text-truncate">${item.name}</div>
                    <small class="text-primary fw-bold">RP ${item.price.toLocaleString()}</small>
                </div>
                <button onclick="removeFromCart(${index})" class="btn btn-sm text-danger p-0 border-0">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
        `).join('');
    }

    // Update Label di UI
    const subtotalLabel = document.getElementById('subtotalLabel');
    const totalLabel = document.getElementById('totalLabel');
    
    if (subtotalLabel) subtotalLabel.innerText = `RP ${subtotal.toLocaleString()}`;
    if (totalLabel) totalLabel.innerText = `RP ${final.toLocaleString()}`;

    // Update Hidden Input untuk kirim ke Database via PHP
    const cartInput = document.getElementById('cartDataInput');
    const totalInput = document.getElementById('final_total_input'); // Pastikan ID ini ada di form
    const promoInput = document.getElementById('promo_type_input');

    if (cartInput) cartInput.value = JSON.stringify(cart);
    if (totalInput) totalInput.value = final;
    if (promoInput) promoInput.value = promoType || '';
}