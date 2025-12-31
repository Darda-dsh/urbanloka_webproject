// Data produk
const produk = [
  {
    nama: "Urban Hoodie",
    harga: 199000,
    kategori: "Hoodie"
  },
  {
    nama: "Oversize Tee",
    harga: 129000,
    kategori: "T-Shirt"
  },
  {
    nama: "Urban Jacket",
    harga: 259000,
    kategori: "Jaket"
  }
];

let keranjang = [];

// Tampilkan produk
function tampilkanProduk(data) {
  const container = document.getElementById("produk-list");
  container.innerHTML = "";

  data.forEach((item, index) => {
    container.innerHTML += `
      <div class="produk">
        <h4>${item.nama}</h4>
        <p>Rp ${item.harga.toLocaleString("id-ID")}</p>
        <button onclick="beliProduk(${index})">BELI</button>
      </div>
    `;
  });
}

// Filter produk berdasarkan kategori
function filterProduk(kategori) {
  const hasil = produk.filter(p => p.kategori === kategori);
  tampilkanProduk(hasil);
}

// Tombol beli
function beliProduk(index) {
  keranjang.push(produk[index]);
  alert(`${produk[index].nama} berhasil ditambahkan ke keranjang!`);
  console.log("Isi keranjang:", keranjang);
}

// Tombol Belanja Sekarang
document.getElementById("btnBelanja").addEventListener("click", () => {
  window.scrollTo({
    top: document.body.scrollHeight,
    behavior: "smooth"
  });
});

// Tampilkan semua produk saat halaman dibuka
tampilkanProduk(produk);
