<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AnoInventory</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Smart Inventory AI</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold p-2 rounded transition cursor-pointer">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
