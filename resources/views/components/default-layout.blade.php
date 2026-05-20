<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Tambahan Google Fonts untuk tampilan font yang lebih modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200/80 px-6 py-4 flex justify-between items-center sticky top-0 z-40 print:hidden shadow-xs">
        <div class="flex items-center gap-3">
            <!-- Logo Icon / Accent -->
            <div class="w-9 h-9 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-sm shadow-indigo-200">
                S
            </div>
            <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                AnoInventory <span class="text-indigo-600 font-black">AI</span>
            </span>
        </div>

        <div class="flex items-center space-x-6">
            <!-- User Profile Link -->
            <a href="{{ route('profile.edit') }}" class="group flex items-center gap-2.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
                <div class="w-8 h-8 bg-slate-100 group-hover:bg-indigo-50 text-slate-600 group-hover:text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm transition-colors border border-slate-200/60">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
            </a>

            <!-- Separation Line -->
            <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 text-xs font-bold px-4 py-2 rounded-xl transition-all duration-200 cursor-pointer border border-slate-200/40 hover:border-rose-200">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Layout Container -->
    <div class="flex flex-1 relative">

        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white border-r border-slate-200/60 p-5 sticky top-[73px] h-[calc(100vh-73px)] print:hidden flex flex-col justify-between overflow-y-auto">
            <div class="space-y-6">
                <!-- Menu Group Label -->
                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 tracking-widest uppercase">Menu Utama</span>
                    <ul class="space-y-1 mt-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                <span class="text-base opacity-75 group-hover:scale-110 transition-transform">📊</span> Dashboard
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Role Access Section (Admin/Super Admin) -->
                @if(Auth::user()->role == 'super_admin' || in_array(Auth::user()->role, ['super_admin', 'admin', 'staff', 'auditor']))
                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 tracking-widest uppercase">Manajemen & Mutasi</span>
                    <ul class="space-y-1 mt-2">
                        @if(Auth::user()->role == 'super_admin')
                            <li>
                                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-indigo-600 bg-indigo-50/50 hover:bg-indigo-50 transition-all group">
                                    <span class="text-base group-hover:scale-110 transition-transform">🛡️</span> Kelola Pengguna
                                </a>
                            </li>
                        @endif

                        @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
                            <li>
                                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                    <span class="text-base opacity-75 group-hover:scale-110 transition-transform">📦</span> Kelola Stok
                                </a>
                            </li>
                        @endif

                        @if(in_array(Auth::user()->role, ['super_admin', 'admin', 'staff']))
                            <li>
                                <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                    <span class="text-base opacity-75 group-hover:scale-110 transition-transform">🔄</span> Transaksi Stok
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                @endif

                <!-- Audit and Report Section -->
                @if(in_array(Auth::user()->role, ['super_admin', 'auditor']))
                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 tracking-widest uppercase">Audit & Laporan</span>
                    <ul class="space-y-1 mt-2">
                        <li>
                            <a href="/logs" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                <span class="text-base opacity-75 group-hover:scale-110 transition-transform">📑</span> Audit Logs
                            </a>
                        </li>
                        <li>
                            <a href="/report" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                <span class="text-base opacity-75 group-hover:scale-110 transition-transform">📈</span> Laporan Bulanan
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                <!-- Supplier Section -->
                @if(Auth::user()->role == 'supplier')
                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 tracking-widest uppercase">Kemitraan</span>
                    <ul class="space-y-1 mt-2">
                        <li>
                            <a href="/mySupply" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                                <span class="text-base opacity-75 group-hover:scale-110 transition-transform">🤝</span> Supply Saya
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>

            <!-- Sidebar Footnote -->
            <div class="pt-4 border-t border-slate-100 text-center">
                <span class="text-[10px] text-slate-400 font-medium tracking-wide">v2.0 • Production Mode</span>
            </div>
        </aside>

        <!-- Main Content View Area -->
        <main class="flex-1 p-6 md:p-8 overflow-x-hidden">

            <!-- Modernized Success Flash Alert -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200/80 flex items-center gap-3 shadow-xs animate-fade-in">
                    <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center text-white text-xs font-bold">✓</div>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Modernized Error Flash Alert -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 text-rose-800 rounded-2xl border border-rose-200/80 flex items-center gap-3 shadow-xs animate-fade-in">
                    <div class="w-6 h-6 bg-rose-500 rounded-full flex items-center justify-center text-white text-xs font-bold">✕</div>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Slot untuk Konten Halaman -->
            {{ $slot }}
        </main>
    </div>

</body>
</html>
