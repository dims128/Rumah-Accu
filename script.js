document.addEventListener('DOMContentLoaded', loadProducts);

function loadProducts() {
    fetch('api/products.php')
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(prod => {
            html += `<div>
                <b>${prod.name}</b> - Rp${prod.price} <br>
                Stok: ${prod.stock} <br>
                <button onclick="orderProduct(${prod.id})">Pesan</button>
            </div><hr>`;
        });
        document.getElementById('products').innerHTML = html;
    });
}

function login() {
    const fd = new FormData();
    fd.append('username', document.getElementById('username').value);
    fd.append('password', document.getElementById('password').value);

    fetch('api/login.php', { method: 'POST', body: fd })
    .then(res => res.json())
    .then(data => {
        document.getElementById('login-status').innerText = data.success ? 'Login sukses!' : 'Login gagal!';
    });
}

function orderProduct(productId) {
    const qty = prompt('Qty:', 1);
    if(!qty) return;
    const fd = new FormData();
    fd.append('product_id', productId);
    fd.append('qty', qty);

    fetch('api/order.php', { method: 'POST', body: fd })
    .then(res => res.json())
    .then(data => {
        alert(data.success ? 'Pesanan berhasil!' : data.error);
        loadProducts();
    });
}