// Sidebar toggle
const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebar-toggle");
const body = document.body;
const headerEl = document.getElementById("admin-header");

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
    body.classList.toggle("sidebar-open");
    headerEl.style.left = body.classList.contains("sidebar-open")
        ? "256px"
        : "0";
});

// filepath:
function openModal(shipmentId = null) {
    const headerEl = document.getElementById("admin-header");
    if (headerEl) headerEl.classList.add("darken");
    document.getElementById("modalTentukanKurir").classList.remove("hidden");

    // Jika shipmentId diberikan (dari tombol "Kurir"), set value input hidden
    if (shipmentId !== null) {
        const input = document.getElementById("shipmentIdToAssign");
        if (input) input.value = shipmentId;
        // Reset dropdown dan field lain jika perlu
        const areaSelect = document.getElementById("area_id");
        const kurirSelect = document.getElementById("kurir_id");
        if (areaSelect) areaSelect.value = "";
        if (kurirSelect)
            kurirSelect.innerHTML =
                '<option value="">Pilih wilayah dahulu...</option>';
    }
}

function closeModal() {
    document.getElementById("modalTentukanKurir").classList.add("hidden");
    const headerEl = document.getElementById("admin-header");
    if (headerEl) headerEl.classList.remove("darken");
}

// Modal Detail
function showDetailModal(
    resi,
    pengirim,
    alamatJemput,
    penerima,
    alamatTujuan,
    kurir,
    tanggal,
    berat,
    harga,
    status,
    catatan = ""
) {
    document.getElementById("resiDetail").value = resi;
    document.getElementById("pengirimDetail").value = pengirim;
    document.getElementById("alamatJemputDetail").value = alamatJemput;
    document.getElementById("penerimaDetail").value = penerima;
    document.getElementById("alamatTujuanDetail").value = alamatTujuan;
    document.getElementById("beratDetail").value = berat;
    document.getElementById("hargaDetail").value = harga.replace(/\D/g, "");
    document.getElementById("kurirDetail").value = kurir;
    document.getElementById("statusDetail").value = status.toLowerCase();
    document.getElementById("tanggalDetail").value = tanggal;
    document.getElementById("catatanDetail").value = catatan;

    headerEl.classList.add("darken");
    document.getElementById("modalDetail").classList.remove("hidden");
}

function closeDetailModal() {
    document.getElementById("modalDetail").classList.add("hidden");
    headerEl.classList.remove("darken");
}
