<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AnoInventory</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Custom gradient warna dari gambar banner Anda */
        .bg-gradient-banner {
            background: linear-gradient(135deg, #312ecb 0%, #3b28b5 40%, #612199 100%);
        }
        /* Warna background gelap luar sesuai gambar kedua */
        .bg-dark-page {
            background-color: #1e1e26;
        }
    </style>
</head>
<body class="bg-dark-page text-slate-100 antialiased min-h-screen flex flex-col md:flex-row">

    <div class="hidden md:flex md:w-[45%] bg-gradient-banner p-12 flex-col justify-between text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-white/5 opacity-20 pointer-events-none"></div>

        <div class="flex items-center gap-2 text-xl font-black tracking-tight relative z-10">
            <div class="w-8 h-8 bg-white text-[#312ecb] flex items-center justify-center rounded-lg font-black shadow-lg">A</div>
            AnoInventory
        </div>
        <div class="relative z-10">
            <h2 class="text-5xl font-extrabold leading-tight mb-6 tracking-tight">Kelola Logistik<br>Lebih Cerdas.</h2>
            <p class="text-white/80 max-w-sm text-sm leading-relaxed">Pantau stok, arus barang, dan data operasional gudang Anda dalam satu dasbor yang intuitif.</p>
        </div>
        <p class="text-xs text-white/40 relative z-10">&copy; {{ date('Y') }} AnoInventory</p>
    </div>

    <div class="flex-1 flex items-center justify-center p-8 bg-dark-page">
        <div class="w-full max-w-[380px]">

            <div class="mb-10 text-left">
                <div class="md:hidden w-12 h-12 bg-gradient-banner rounded-xl flex items-center justify-center text-white text-xl font-black mb-8 shadow-xl shadow-indigo-900/50">A</div>
                <h1 class="text-3xl font-black tracking-tight text-white mb-3">Selamat Datang</h1>
                <p class="text-slate-400 text-sm font-medium">Masukkan kredensial Anda untuk masuk ke sistem.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Alamat Email</label>
                        <input
                            type="email"
                            name="email"
                            placeholder="nama@perusahaan.com"
                            class="w-full bg-transparent border-b-2 border-slate-700 focus:border-[#312ecb] outline-hidden py-3 text-sm font-semibold text-white transition-colors placeholder:text-slate-600"
                            required
                        >
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                            <a href="#" class="text-xs font-bold text-[#4c49f5] hover:text-[#612199] transition-colors">Lupa?</a>
                        </div>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full bg-transparent border-b-2 border-slate-700 focus:border-[#312ecb] outline-hidden py-3 text-sm font-semibold text-white transition-colors placeholder:text-slate-600"
                            required
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-banner hover:opacity-95 text-white font-bold py-4 rounded-xl text-sm transition-all active:scale-[0.98] mt-4 shadow-xl shadow-indigo-950/50 cursor-pointer"
                >
                    Masuk
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-slate-500 md:hidden font-medium">
                &copy; {{ date('Y') }} AnoInventory. All Rights Reserved.
            </p>
        </div>
    </div>

</body>
</html>
