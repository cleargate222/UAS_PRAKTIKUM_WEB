@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Tombol Kembali -->
            <div class="mb-3">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    🔙 Kembali ke Daftar Transaksi
                </a>
            </div>

            <!-- Detail Transaksi -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        @if ($transaction->type === 'in')
                            ✅ Detail Transaksi Barang Masuk
                        @else
                            ❌ Detail Transaksi Barang Keluar
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <!-- ID Transaksi -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>ID Transaksi</strong></small>
                            <h5>{{ $transaction->id }}</h5>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Tanggal & Waktu</strong></small>
                            <h5>{{ $transaction->created_at->format('d M Y H:i:s') }}</h5>
                        </div>
                    </div>

                    <hr>

                    <!-- Informasi Produk -->
                    <h5 class="mb-3">📦 Informasi Produk</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Nama Produk</strong></small>
                            <p class="mb-0">
                                <strong class="text-dark">{{ $transaction->product->name }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Supplier</strong></small>
                            <p class="mb-0">
                                <strong>{{ $transaction->product->supplier->name ?? 'N/A' }}</strong><br>
                                <small>({{ $transaction->product->supplier->email ?? '' }})</small>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <small class="text-muted"><strong>Stok Saat Ini</strong></small>
                            <h6 class="text-primary">{{ $transaction->product->stock }} unit</h6>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted"><strong>Minimum Stok</strong></small>
                            <h6>{{ $transaction->product->min_stock }} unit</h6>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted"><strong>Deskripsi</strong></small>
                            <p class="mb-0">
                                <small>{{ $transaction->product->description ?? '-' }}</small>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Informasi Transaksi -->
                    <h5 class="mb-3">🔄 Informasi Transaksi</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Tipe Transaksi</strong></small>
                            <p class="mb-0">
                                @if ($transaction->type === 'in')
                                    <span class="badge bg-success fs-6">✅ BARANG MASUK</span>
                                @else
                                    <span class="badge bg-danger fs-6">❌ BARANG KELUAR</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Jumlah</strong></small>
                            <h5 class="text-info">{{ $transaction->quantity }} unit</h5>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if (!empty($transaction->note))
                        <div class="mb-3">
                            <small class="text-muted"><strong>Catatan</strong></small>
                            <div class="alert alert-light border">
                                <p class="mb-0"><em>{{ $transaction->note }}</em></p>
                            </div>
                        </div>
                    @endif

                    <hr>

                    <!-- Informasi Staff -->
                    <h5 class="mb-3">👤 Informasi Staff</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Nama Staff</strong></small>
                            <p class="mb-0">
                                <strong>{{ $transaction->user->name ?? 'N/A' }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Email</strong></small>
                            <p class="mb-0">
                                <small>{{ $transaction->user->email ?? 'N/A' }}</small>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Role</strong></small>
                            <p class="mb-0">
                                <span class="badge bg-secondary">{{ $transaction->user->role ?? 'N/A' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Dicatat Pada</strong></small>
                            <p class="mb-0">
                                <small>{{ $transaction->created_at->format('d M Y H:i') }}</small><br>
                                <small class="text-muted">({{ $transaction->created_at->diffForHumans() }})</small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        💡 Catatan: Transaksi ini telah dicatat di sistem audit log otomatis untuk keperluan audit dan compliance.
                    </small>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-lg">
                    🔙 Kembali
                </a>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-lg">
                    ➕ Tambah Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
