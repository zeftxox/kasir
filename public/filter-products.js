document.addEventListener("DOMContentLoaded", function () {
    const filters = {
        nama: document.getElementById("filterNama"),
        kategori: document.getElementById("filterKategori"),
        hargaMin: document.getElementById("filterHargaMin"),
        hargaMax: document.getElementById("filterHargaMax"),
        stokOpsi: document.getElementById("filterStokOpsi"),
        stok: document.getElementById("filterStok"),
        barcode: document.getElementById("filterBarcode"),
    };

    function applyFilters() {
        let params = {
            nama: filters.nama.value,
            kategori: filters.kategori.value,
            hargaMin: filters.hargaMin.value,
            hargaMax: filters.hargaMax.value,
            stokOpsi: filters.stokOpsi.value,
            stok: filters.stok.value,
            barcode: filters.barcode.value,
        };

        fetch(`/admin/manage-products/filter?${new URLSearchParams(params)}`)
            .then((response) => response.json())
            .then((data) => {
                let tableBody = document.getElementById("productTableBody");
                tableBody.innerHTML = "";

                data.forEach((product) => {
                    let row = `
                        <tr>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">${
                                product.nama_produk
                            }</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">${
                                product.category.kategori
                            }</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp ${parseFloat(
                                product.harga_beli
                            ).toLocaleString("id-ID", {
                                minimumFractionDigits: 2,
                            })}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp ${parseFloat(
                                product.harga_jual
                            ).toLocaleString("id-ID", {
                                minimumFractionDigits: 2,
                            })}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">${
                                product.stok
                            }</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">${
                                product.barcode
                            }</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="/admin/manage-products/${
                                    product.id
                                }/edit" 
                                   class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form method="POST" action="/admin/manage-products/${
                                    product.id
                                }" class="inline">
                                    <input type="hidden" name="_token" value="${document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute("content")}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" 
                                            class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            })
            .catch((error) => console.error("Error:", error));
    }

    Object.values(filters).forEach((input) => {
        input.addEventListener("input", applyFilters);
    });

    filters.stokOpsi.addEventListener("change", applyFilters);
});
