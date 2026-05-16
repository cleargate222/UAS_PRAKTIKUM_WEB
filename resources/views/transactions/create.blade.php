@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📦 Form Transaksi Barang</h4>
                </div>
                <div class="card-body">
                    <!-- Tampilkan error jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>⚠️ Terjadi Kesalahan!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form Transaksi -->
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Produk -->
                        <div class="mb-3">
                            <label for="product_id" class="form-label">
                                <strong>📋 Pilih Produk</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select form-select-lg @error('product_id') is-invalid @enderror"
                                id="product_id"
                                name="product_id"
                                required
                                onchange="updateProductInfo()">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option
                                        value="{{ $product->id }}"
                                        data-stock="{{ $product->stock }}"
                                        data-min-stock="{{ $product->min_stock }}"
                                        data-supplier="{{ $product->supplier->name ?? 'N/A' }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stok: {{ $product->stock }}) - Supplier: {{ $product->supplier->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Produk (Dinamis) -->
                        <div id="productInfo" class="alert alert-info mb-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <small><strong>Stok Saat Ini:</strong> <span id="currentStock">-</span> unit</small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Min Stok:</strong> <span id="minStock">-</span> unit</small>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small><strong>Supplier:</strong> <span id="supplierName">-</span></small>
                                </div>
                            </div>
                        </div>

                        <!-- Tipe Transaksi -->
                        <div class="mb-3">
                            <label class="form-label">
                                <strong>📥 Tipe Transaksi</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="type"
                                        id="typeIn"
                                        value="in"
                                        {{ old('type') == 'in' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="typeIn">
                                        ✅ <strong>Barang Masuk</strong> (Tambah Stok)
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="type"
                                        id="typeOut"
                                        value="out"
                                        {{ old('type') == 'out' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="typeOut">
                                        ❌ <strong>Barang Keluar</strong> (Kurangi Stok)
                                    </label>
                                </div>
                            </div>
                            @error('type')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Barang -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">
                                <strong>🔢 Jumlah Barang</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                                id="quantity"
                                name="quantity"
                                placeholder="Masukkan jumlah barang"
                                min="1"
                                value="{{ old('quantity') }}"
                                required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan (Opsional) -->
                        <div class="mb-3">
                            <label for="note" class="form-label">
                                <strong>📝 Catatan</strong> (Opsional)
                            </label>
                            <textarea
                                class="form-control @error('note') is-invalid @enderror"
                                id="note"
                                name="note"
                                rows="3"
                                placeholder="Contoh: Pembelian dari supplier ABC / Persiapan untuk acara... (maksimal 500 karakter)"
                                maxlength="500">{{ old('note') }}</textarea>
                            <small class="form-text text-muted">
                                <span id="charCount">0</span>/500 karakter
                            </small>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Button Submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-lg">
                                🔙 Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                💾 Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi Panduan -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">ℹ️ Panduan Penggunaan</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Pilih produk dari dropdown yang tersedia</li>
                        <li>Pilih tipe transaksi: <strong>Barang Masuk</strong> untuk menambah stok atau <strong>Barang Keluar</strong> untuk mengurangi stok</li>
                        <li>Masukkan jumlah barang yang akan ditransaksikan</li>
                        <li>Isi catatan untuk informasi tambahan (opsional)</li>
                        <li>Klik "Simpan Transaksi" untuk menyimpan data</li>
                        <li>Semua transaksi akan tercatat otomatis di audit log</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update informasi produk saat dropdown berubah
    function updateProductInfo() {
        const select = document.getElementById('product_id');
        const selectedOption = select.options[select.selectedIndex];
        const productInfo = document.getElementById('productInfo');

        if (selectedOption.value) {
            document.getElementById('currentStock').textContent = selectedOption.getAttribute('data-stock');
            document.getElementById('minStock').textContent = selectedOption.getAttribute('data-min-stock');
            document.getElementById('supplierName').textContent = selectedOption.getAttribute('data-supplier');
            productInfo.style.display = 'block';
        } else {
            productInfo.style.display = 'none';
        }
    }

    // Hitung jumlah karakter di textarea catatan
    document.getElementById('note').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // Panggil updateProductInfo saat halaman dimuat
    window.addEventListener('load', updateProductInfo);
</script>
@endsection
