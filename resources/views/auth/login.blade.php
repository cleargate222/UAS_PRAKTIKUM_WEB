<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AnoInventory</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[400px] space-y-8">

        <!-- Header / Identitas Brand -->
        <div class="space-y-2">
            <!-- Simbol Box Minimalis -->
            <div class="inline-flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-xl text-white font-black text-lg shadow-md shadow-indigo-600/10">
                A
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 mt-4">
                Masuk ke AnoInventory
            </h1>
            <p class="text-sm text-slate-500">
                Kelola inventaris, stok gudang, dan pasokan logistik dalam satu dasbor terpadu.
            </p>
        </div>

        <!-- Card Login -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-6 md:p-8 shadow-xs shadow-slate-100/80">
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Kolom Email -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Alamat Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@perusahaan.com"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all duration-200 @error('email') border-rose-300 focus:ring-rose-500 @enderror"
                        required
                        autofocus
                    >
                    @error('email')
                        <span class="text-rose-600 text-xs font-medium mt-1 block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Kolom Password -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all duration-200"
                        required
                    >
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer group select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-600 accent-indigo-600 cursor-pointer"
                        >
                        <span class="text-xs text-slate-500 group-hover:text-slate-700 transition-colors font-medium">
                            Ingat sesi masuk saya
                        </span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button
                    type="submit"
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-xl text-sm shadow-xs transition-all duration-150 cursor-pointer flex items-center justify-center gap-2 mt-2"
                >
                    Sign In
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Footer Hak Cipta -->
        <p class="text-center text-xs text-slate-400 font-medium">
            &copy; {{ date('Y') }} AnoInventory. Hak Cipta Dilindungi.
        </p>
    </div>

</body>
</html>
