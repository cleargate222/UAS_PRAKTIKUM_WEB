@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>📊 Riwayat Transaksi</h2>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-lg">
                    ➕ Tambah Transaksi Baru
                </a>
            </div>

            <!-- Alert Sukses -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>✅ Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tabel Transaksi -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📋 Daftar Semua Transaksi</h5>
                </div>
                <div class="table-responsive">
                    @if ($transactions->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 8%">No</th>
                                    <th style="width: 20%">Produk</th>
                                    <th style="width: 12%">Tipe</th>
                                    <th style="width: 12%">Jumlah</th>
                                    <th style="width: 18%">Staff</th>
                                    <th style="width: 20%">Tanggal</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $index => $transaction)
                                    <tr>
                                        <td>
                                            <strong>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $transaction->product->name }}</strong><br>
                                            <small class="text-muted">Supplier: {{ $transaction->product->supplier->name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if ($transaction->type === 'in')
                                                <span class="badge bg-success">✅ Masuk</span>
                                            @else
                                                <span class="badge bg-danger">❌ Keluar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $transaction->quantity }}</strong> unit
                                        </td>
                                        <td>
                                            <small>{{ $transaction->user->name ?? 'N/A' }}</small><br>
                                            <small class="text-muted">({{ $transaction->user->email ?? '' }})</small>
                                        </td>
                                        <td>
                                            <small>{{ $transaction->created_at->format('d M Y H:i') }}</small><br>
                                            <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                                👁️ Lihat
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Baris Catatan (jika ada) -->
                                    @if (!empty($transaction->note))
                                        <tr class="table-light">
                                            <td colspan="7">
                                                <small>
                                                    <strong>Catatan:</strong> <em>{{ $transaction->note }}</em>
                                                </small>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <h5 class="text-muted">📭 Belum ada transaksi</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info m-4">
                            <h5>📭 Belum ada data transaksi</h5>
                            <p>Mulai dengan membuat transaksi baru dengan mengklik tombol "Tambah Transaksi Baru"</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($transactions->count() > 0)
                    <div class="card-footer bg-light">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

            <!-- Statistik Transaksi -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Transaksi</h5>
                            <h2 class="text-primary">{{ $transactions->total() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Barang Masuk (Hari ini)</h5>
                            <h2 class="text-success">
                                @php
                                    $today_in = \App\Models\Transaction::where('type', 'in')
                                        ->whereDate('created_at', today())
                                        ->sum('quantity');
                                @endphp
                                {{ $today_in }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Barang Keluar (Hari ini)</h5>
                            <h2 class="text-danger">
                                @php
                                    $today_out = \App\Models\Transaction::where('type', 'out')
                                        ->whereDate('created_at', today())
                                        ->sum('quantity');
                                @endphp
                                {{ $today_out }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Net (Hari ini)</h5>
                            <h2 class="text-info">
                                @php
                                    $net = $today_in - $today_out;
                                @endphp
                                {{ $net > 0 ? '+' : '' }}{{ $net }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
