<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between">
        <span class="font-bold">Smart Inventory AI</span>
        <span>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
    </nav>
    <div class="flex">
        <aside class="w-64 bg-white h-screen p-4 shadow">
            <ul class="space-y-2">
                <li><a href="/dashboard">Dashboard</a></li>
                @if(Auth::user()->role == 'super_admin') <li><a href="/users">Manage Users</a></li> @endif
                @if(Auth::user()->role == 'admin') <li><a href="/products">Manage Stok</a></li> @endif
                @if(in_array(Auth::user()->role, ['admin', 'staff'])) <li><a href="/transactions">Transaksi</a></li> @endif
                @if(Auth::user()->role == 'auditor') <li><a href="/logs">Audit Logs</a></li> @endif
                @if(Auth::user()->role == 'supplier') <li><a href="/my-supply">Supply Saya</a></li> @endif
            </ul>
        </aside>
        <main class="flex-1 p-6">{{ $slot }}</main>
    </div>
</body>
