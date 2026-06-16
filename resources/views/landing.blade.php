<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SIFAS | Sistem Peminjaman Kampus</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-['Inter'] flex flex-col min-h-screen">

    <nav class="bg-slate-900 text-white py-4 px-6 md:px-12 flex justify-between items-center shadow-md sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-3xl">domain</span>
            <span class="font-bold text-xl tracking-wide">SIFAS PETRA</span>
        </div>
        @auth
            <a href="{{ route(auth()->user()->role->nama_role . '.dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-white text-slate-900 px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 transition-all">
                Login
            </a>
        @endauth
    </nav>

    <section class="bg-slate-800 text-white py-20 px-6 md:px-12 text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto relative z-10">
            <span class="inline-block bg-slate-700 text-gray-200 px-4 py-1.5 rounded-full text-sm font-semibold mb-6">
                OFFICIAL CAMPUS RESOURCE PORTAL
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Sistem Peminjaman <span class="text-blue-400">Ruang & Barang</span>
            </h1>
            <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto">
                Kelola dan cek ketersediaan fasilitas Universitas Kristen Petra secara real-time untuk kebutuhan akademik dan kegiatan kampus.
            </p>

            <form action="{{ route('landing') }}" method="GET" class="bg-white p-2 rounded-xl flex flex-col md:flex-row gap-2 shadow-lg max-w-3xl mx-auto">
                <div class="flex-1 flex items-center bg-gray-50 rounded-lg px-4 border border-gray-200">
                    <span class="material-symbols-outlined text-gray-400">search</span>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari nama ruang atau barang..." class="w-full bg-transparent border-none px-3 py-3 text-gray-800 focus:outline-none focus:ring-0">
                </div>
                <select name="kategori" class="px-4 py-3 bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:outline-none">
                    <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="ruang" {{ request('kategori') == 'ruang' ? 'selected' : '' }}>Ruangan</option>
                    <option value="barang" {{ request('kategori') == 'barang' ? 'selected' : '' }}>Barang</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <section class="py-16 px-6 md:px-12 max-w-7xl mx-auto flex-1 w-full">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Katalog Fasilitas</h2>
                <p class="text-gray-500 mt-1">Status ketersediaan real-time</p>
            </div>
            <div class="hidden md:flex gap-4">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-500"></span><span class="text-sm font-medium">Tersedia</span></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span><span class="text-sm font-medium">Tidak Tersedia</span></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($fasilitas as $item)
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-400 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                        <span class="material-symbols-outlined">{{ $item->kategori == 'ruang' ? 'meeting_room' : 'inventory_2' }}</span>
                    </div>
                    @if($item->status == 'Tersedia' || $item->status == 'Tersedia (Sebagian)')
                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold">Tersedia</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-bold">{{ $item->status }}</span>
                    @endif
                </div>
                <h3 class="font-bold text-lg mb-1 text-slate-900">{{ $item->nama }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $item->lokasi }}</p>
                
                <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $item->kategori }}</span>
                    <span class="text-sm font-bold text-slate-700">Kapasitas/Stok: {{ $item->jumlah_kapasitas }}</span>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                <span class="material-symbols-outlined text-5xl text-gray-400 mb-3">search_off</span>
                <h3 class="text-lg font-bold text-gray-600">Tidak Ditemukan</h3>
                <p class="text-gray-500">Fasilitas yang Anda cari tidak tersedia di sistem.</p>
            </div>
            @endforelse
        </div>
    </section>

    <footer class="bg-slate-900 text-gray-400 py-8 text-center text-sm border-t border-slate-800">
        <p>&copy; {{ date('Y') }} SIFAS - Universitas Kristen Petra. Kelompok 4.</p>
    </footer>

</body>
</html>