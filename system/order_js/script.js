let cart = {};
let diskon = 0;
let ppn = 0;
let guestCounter = 1; // Counter untuk costumer non-member
let currentCustomer = null; // Simpan info pembeli saat cek member

// Klik produk -> tambah ke keranjang
document.querySelectorAll(".product").forEach((p) => {
  p.addEventListener("click", () => {
    let id = p.dataset.id;
    let nama = p.dataset.nama;
    let harga = parseFloat(p.dataset.harga);
    let stok = parseInt(p.dataset.stok);

    if (!cart[id]) cart[id] = { nama, harga, qty: 1, stok };
    else if (cart[id].qty < stok) cart[id].qty++;
    renderCart();
  });
});

// Render tabel keranjang
function renderCart() {
  let tbody = document.querySelector("#cart-table tbody");
  tbody.innerHTML = "";
  let total = 0;

  for (let id in cart) {
    let c = cart[id];
    let sub = c.harga * c.qty;
    total += sub;

    tbody.innerHTML += `
      <tr class="border-b hover:bg-gray-50">
        <td class="p-2 text-left">${c.nama}</td>
        <td class="p-2 text-right">${c.harga.toLocaleString()}</td>
        <td class="p-2 text-center">
          <div class="flex justify-center gap-2">
            <button onclick="changeQty('${id}', -1)" class="px-2 py-1 bg-red-500 text-white rounded">-</button>
            <span>${c.qty}</span>
            <button onclick="changeQty('${id}', 1)" class="px-2 py-1 bg-green-500 text-white rounded">+</button>
          </div>
        </td>
        <td class="p-2 text-right">${sub.toLocaleString()}</td>
        <td class="p-2 text-center">
          <button onclick="hapusItem('${id}')" class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
        </td>
      </tr>`;
  }

  ppn = total * 0.11;

  document.getElementById("total").innerText = total.toLocaleString();
  document.getElementById("ppn").innerText = ppn.toLocaleString();
  document.getElementById("diskon").innerText = diskon.toLocaleString();
  document.getElementById("grand_total").innerText = (
    total +
    ppn -
    diskon
  ).toLocaleString();
}

// Ubah jumlah item
function changeQty(id, delta) {
  let item = cart[id];
  let newQty = item.qty + delta;

  if (newQty <= 0) delete cart[id];
  else if (newQty <= item.stok) item.qty = newQty;

  renderCart();
}

// Hapus item
function hapusItem(id) {
  delete cart[id];
  renderCart();
}

// Cek member dan hitung diskon
function cekMember() {
  let kode = document.getElementById("kode_member").value.trim();
  let total = Object.values(cart).reduce((sum, p) => sum + p.harga * p.qty, 0);

  if (!kode) {
    diskon = 0;
    currentCustomer = { nama: `Costumer ${guestCounter}` };
    guestCounter++;
    renderCart();
    return;
  }

  fetch("process/costumer/cek_member.php?nomor=" + encodeURIComponent(kode))
    .then((res) => res.json())
    .then((cust) => {
      if (cust && cust.status_member === 1) {
        diskon = total * 0.1;
        currentCustomer = { nama: cust.nama }; // Simpan nama member
        alert(`Member valid: ${cust.nama} (Diskon 10%)`);
      } else {
        diskon = 0;
        currentCustomer = { nama: `Costumer ${guestCounter}` }; // Non-member
        guestCounter++;
        alert("Kode ini bukan membership");
      }
      renderCart();
    })
    .catch((err) => {
      console.error(err);
      alert("Terjadi kesalahan saat cek member");
    });
}

// Checkout & generate PDF
function checkout() {
  if (Object.keys(cart).length === 0) {
    alert("Keranjang kosong");
    return;
  }

  const namaCustomer = currentCustomer?.nama || `Costumer ${guestCounter}`;
  if (!currentCustomer) guestCounter++;

  let fd = new FormData();
  fd.append("admin_id", LOGIN_ID);
  fd.append("kode_member", document.getElementById("kode_member").value.trim());
  fd.append("cart", JSON.stringify(cart));
  fd.append("diskon", diskon);
  fd.append("ppn", ppn);

  fetch("process/order/save_order.php", { method: "POST", body: fd })
    .then((res) => res.text())
    .then((txt) => {
      alert(txt);
      downloadReceiptThermal(cart, diskon, ppn, namaCustomer);
      cart = {};
      diskon = 0;
      ppn = 0;
      currentCustomer = null; // Reset
      renderCart();
    })
    .catch((err) => {
      console.error(err);
      alert("Terjadi kesalahan saat checkout");
    });
}

// Download PDF struk thermal
function downloadReceiptThermal(cart, diskon, ppn, namaCustomer) {
  const { jsPDF } = window.jspdf;
  let doc = new jsPDF({ unit: "mm", format: [80, 200] });

  let total = Object.values(cart).reduce((sum, p) => sum + p.harga * p.qty, 0);
  let grandTotal = total + ppn - diskon;

  let y = 5;
  doc.setFontSize(10);
  doc.text("TOKO BOOKS POST", 40, y, { align: "center" });
  y += 5;
  doc.text("STRUK PEMBELIAN", 40, y, { align: "center" });
  y += 5;

  // Nama pembeli
  doc.text(`Pembeli: ${namaCustomer}`, 0, y);
  y += 5;

  doc.text("================================", 0, y);
  y += 5;

  // Header tabel
  doc.text("Buku          Qty  Harga", 0, y);
  y += 5;
  doc.text("--------------------------------", 0, y);
  y += 5;

  // Isi keranjang
  for (let p of Object.values(cart)) {
    let nama = p.nama.length > 12 ? p.nama.substring(0, 12) + "." : p.nama;
    let line = `${nama.padEnd(12, " ")} ${p.qty
      .toString()
      .padStart(3, " ")}  ${p.harga.toLocaleString()}`;
    doc.text(line, 0, y);
    y += 5;
  }

  y += 2;
  doc.text("--------------------------------", 0, y);
  y += 5;
  doc.text(`Total       : Rp ${total.toLocaleString()}`, 0, y);
  y += 5;
  doc.text(`PPN (11%)  : Rp ${ppn.toLocaleString()}`, 0, y);
  y += 5;
  doc.text(`Diskon     : Rp ${diskon.toLocaleString()}`, 0, y);
  y += 5;
  doc.text(`Grand Total: Rp ${grandTotal.toLocaleString()}`, 0, y);
  y += 5;
  doc.text("--------------------------------", 0, y);
  y += 5;
  doc.text("Terima kasih atas kunjungannya!", 40, y, { align: "center" });

  doc.save("struk.pdf");
}
