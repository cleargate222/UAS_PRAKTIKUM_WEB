<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center shadow print:hidden">
        <span class="font-bold text-lg">Smart Inventory AI</span>
        <div class="flex items-center space-x-4">
            <a href="{{ route('profile.edit') }}" class="hover:underline flex items-center gap-1 font-medium">
                👤 {{ Auth::user()->name }}
            </a>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-xs px-3 py-1.5 rounded transition font-semibold cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="flex">
        <aside class="w-64 bg-white h-screen p-4 shadow print:hidden">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-100 rounded">Dashboard</a>
                </li>

                @if(Auth::user()->role == 'super_admin')
                    <li><a href="{{ route('users.index') }}" class="block p-2 hover:bg-gray-100 rounded text-indigo-600 font-bold">🛡️ Manage Users</a></li>
                @endif

                @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
                    <li><a href="{{ route('products.index') }}" class="block p-2 hover:bg-gray-100 rounded">Manage Stok</a></li>
                @endif

                @if(in_array(Auth::user()->role, ['super_admin', 'admin', 'staff']))
                    <li><a href="{{ route('transactions.index') }}" class="block p-2 hover:bg-gray-100 rounded">Transaksi</a></li>
                @endif

                @if(in_array(Auth::user()->role, ['super_admin', 'auditor']))
                    <li><a href="/logs" class="block p-2 hover:bg-gray-100 rounded">Audit Logs</a></li>
                    <li><a href="/report" class="block p-2 hover:bg-gray-100 rounded">Laporan Bulanan</a></li>
                @endif

                @if(Auth::user()->role == 'supplier')
                    <li><a href="/my-supply" class="block p-2 hover:bg-gray-100 rounded">Supply Saya</a></li>
                @endif
            </ul>
        </aside>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border-l-4 border-green-500">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border-l-4 border-red-500">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
