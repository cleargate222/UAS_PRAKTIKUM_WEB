<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventory AI' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css">
</head>
<body class="bg-zinc-50 text-zinc-900">
    <nav class="bg-zinc-900 text-white p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-2">
            <i class="ph ph-package text-xl"></i>
            <span class="font-bold tracking-tight">Smart Inventory</span>
        </div>
        <div class="flex gap-4 text-sm">
            <a href="/dashboard" class="hover:text-blue-400">Dashboard</a>
            <a href="/products" class="hover:text-blue-400">Products</a>
            <a href="/profile" class="hover:text-blue-400">Profile</a>
            <form action="/logout" method="POST">@csrf <button type="submit">Logout</button></form>
        </div>
    </nav>
    <main class="p-8">
        <h1 class="text-3xl font-bold mb-8">{{ $sectionTitle }}</h1>
        {{ $slot }} </main>
</body>
</html>
