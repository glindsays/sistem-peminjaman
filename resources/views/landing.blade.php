<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>SIFAS | Portal Fasilitas Kampus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-slate-900 font-['Inter'] flex flex-col min-h-screen overflow-x-hidden">

    <nav class="bg-slate-900 text-white py-4 px-6 md:px-12 flex justify-between items-center shadow-md sticky top-0 z-50">
        <a href="{{ route('landing') }}" class="flex items-center gap-3">
            <span class="material-symbols-outlined text-2xl md:text-3xl">domain</span>
            <span class="font-bold text-lg md:text-xl tracking-wide">SIFAS PETRA</span>
        </a>
        @auth
            <a href="{{ route(auth()->user()->role->nama_role . '.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 md:px-6 rounded-lg font-semibold hover:bg-blue-700 text-sm">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="bg-white text-slate-900 px-4 py-2 md:px-6 rounded-lg font-semibold hover:bg-gray-200 text-sm">Login</a>
        @endauth
    </nav>

    <section id="hero-section" class="relative text-white py-20 md:py-24 px-6 text-center bg-cover bg-center bg-no-repeat w-full" data-bg="{{ asset('images/pcu3.png') }}">
        <div class="absolute inset-0 bg-slate-900/75 z-0"></div>
        <div class="relative z-10 w-full max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 md:mb-6 leading-tight">Sistem Peminjaman <br class="hidden md:block"> <span class="text-blue-400">Ruang & Barang</span></h1>
            <p class="text-gray-200 text-base md:text-lg">Cek ketersediaan dan pinjam fasilitas UK Petra untuk kebutuhan perkuliahan dan kegiatan kampus.</p>
        </div>
    </section>

    <main class="py-8 md:py-12 px-6 md:px-12 max-w-7xl mx-auto w-full flex-1">
        <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-6">Cek Ketersediaan Fasilitas</h2>

        <div class="mb-8 border-b border-gray-200 pb-4">
            <div class="flex gap-6 mb-6">
                <button onclick="switchTab('ruang')" id="btnRuang" class="cursor-pointer pb-2 font-bold text-slate-900 border-b-2 border-slate-900">Ruangan</button>
                <button onclick="switchTab('barang')" id="btnBarang" class="cursor-pointer pb-2 font-bold text-gray-500 hover:text-gray-800 border-b-2 border-transparent">Barang</button>
            </div>
            <div class="flex flex-col md:flex-row gap-3 w-full">
                <input type="text" id="searchInput" placeholder="Cari nama..." class="px-4 py-2 border rounded-lg w-full md:flex-1">
                <select id="filterGedung" class="px-4 py-2 border rounded-lg w-full md:w-auto">
                    <option value="">Semua Gedung</option>
                    @foreach($fasilitas->where('kategori', 'ruang')->pluck('lokasi')->filter()->unique() as $gedung)
                        <option value="{{ strtolower($gedung) }}">{{ $gedung }}</option>
                    @endforeach
                </select>
                <select id="filterUPPK" class="px-4 py-2 border rounded-lg hidden w-full md:w-auto">
                    <option value="">Semua UPPK</option>
                    @foreach($fasilitas->where('kategori', 'barang')->pluck('uppk')->filter()->unique() as $uppk)
                        <option value="{{ strtolower($uppk) }}">{{ $uppk }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="fasilitasContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 min-h-[400px] items-stretch w-full">
            @foreach($fasilitas as $item)
            <div class="fasilitas-card bg-white border border-gray-200 rounded-2xl p-4 md:p-5 shadow-sm hover:shadow-md transition-all flex-col hidden w-full overflow-hidden" 
                 data-nama="{{ strtolower($item->nama) }}" 
                 data-kategori="{{ strtolower($item->kategori) }}"
                 data-filter="{{ strtolower($item->kategori == 'ruang' ? ($item->lokasi ?? '') : ($item->uppk ?? '')) }}">
                
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                        <span class="material-symbols-outlined">{{ $item->kategori == 'ruang' ? 'meeting_room' : 'inventory_2' }}</span>
                    </div>
                    <span class="{{ strtolower($item->status) == 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-[10px] md:text-xs px-2 py-1 md:px-3 rounded-full font-bold capitalize whitespace-nowrap">{{ $item->status }}</span>
                </div>
                
                <h3 class="font-bold text-base md:text-lg mb-1 text-slate-900 line-clamp-2">{{ $item->nama }}</h3>
                <p class="text-xs md:text-sm text-gray-500 mb-4 md:mb-6 font-medium truncate">{{ $item->kategori == 'ruang' ? ($item->lokasi ?? 'Lokasi tidak tersedia') : ($item->uppk ?? 'UPPK Umum') }}</p>
                
                <div class="border-t border-gray-100 pt-3 mt-auto">
                    <span class="text-xs md:text-sm font-semibold text-slate-700">Stok: <span class="font-bold">{{ $item->jumlah_kapasitas }}</span></span>
                </div>
            </div>
            @endforeach

            <div id="emptyState" class="hidden col-span-full py-16 text-center text-gray-500">
                <span class="material-symbols-outlined text-[48px] text-gray-300 block mb-2">search_off</span>
                <span class="font-bold text-lg block text-slate-700">Fasilitas Tidak Ditemukan</span>
                <span class="text-sm mt-1 block">Coba ubah kata kunci pencarian atau filter yang aktif.</span>
            </div>
        </div>

        <div id="paginationContainer" class="mt-8 md:mt-12 flex flex-wrap justify-center items-center gap-2 w-full"></div>
    </main>

    <footer class="bg-slate-900 text-gray-400 py-6 md:py-8 text-center text-xs md:text-sm border-t mt-auto">
        <p>&copy; {{ date('Y') }} SIFAS - Universitas Kristen Petra. Kelompok 4.</p>
    </footer>

    <script>
        let currentPage = 1;
        const itemsPerPage = 16;
        let filteredCards = [];

        function switchTab(kategori) {
            document.getElementById('btnRuang').className = kategori === 'ruang' ? 'cursor-pointer pb-2 font-bold text-slate-900 border-b-2 border-slate-900' : 'cursor-pointer pb-2 font-bold text-gray-500 hover:text-gray-800 border-b-2 border-transparent';
            document.getElementById('btnBarang').className = kategori === 'barang' ? 'cursor-pointer pb-2 font-bold text-slate-900 border-b-2 border-slate-900' : 'cursor-pointer pb-2 font-bold text-gray-500 hover:text-gray-800 border-b-2 border-transparent';
            
            document.getElementById('filterGedung').classList.toggle('hidden', kategori !== 'ruang');
            document.getElementById('filterUPPK').classList.toggle('hidden', kategori !== 'barang');
            
            document.getElementById('searchInput').value = '';
            document.getElementById('filterGedung').value = '';
            document.getElementById('filterUPPK').value = '';
            
            filterItems();
        }

        function filterItems() {
            const val = document.getElementById('searchInput').value.toLowerCase();
            const activeTab = document.getElementById('btnRuang').className.includes('text-slate-900') ? 'ruang' : 'barang';
            const filterVal = (activeTab === 'ruang' ? document.getElementById('filterGedung').value : document.getElementById('filterUPPK').value).toLowerCase();

            filteredCards = [];
            document.querySelectorAll('.fasilitas-card').forEach(card => {
                const matchTab = card.getAttribute('data-kategori') === activeTab;
                const matchSearch = card.getAttribute('data-nama').includes(val);
                const matchFilter = filterVal === '' || card.getAttribute('data-filter').includes(filterVal);
                
                if (matchTab && matchSearch && matchFilter) {
                    filteredCards.push(card);
                } else {
                    card.style.display = 'none'; 
                }
            });

            currentPage = 1; 
            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            filteredCards.forEach((card, index) => {
                if (index >= startIndex && index < endIndex) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyState = document.getElementById('emptyState');
            emptyState.classList.toggle('hidden', filteredCards.length > 0);

            const pagContainer = document.getElementById('paginationContainer');
            pagContainer.innerHTML = '';

            if (totalPages > 0) {
                const btnPrev = document.createElement('button');
                btnPrev.innerHTML = '&laquo;';
                btnPrev.disabled = currentPage === 1;
                btnPrev.className = `px-3 py-1.5 border rounded-lg transition-colors text-sm ${currentPage === 1 ? 'bg-gray-100 text-gray-300 cursor-not-allowed border-gray-200' : 'bg-white hover:bg-gray-50 border-gray-200'}`;
                if (currentPage !== 1) btnPrev.style.color = '#004482';
                btnPrev.onclick = () => { if(currentPage > 1) { currentPage--; renderPagination(); window.scrollTo(0, document.getElementById('fasilitasContainer').offsetTop - 100); } };
                pagContainer.appendChild(btnPrev);

                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement('button');
                    btn.innerText = i;
                    btn.className = `px-3 py-1.5 border rounded-lg transition-colors text-sm font-bold ${currentPage === i ? 'text-white' : 'bg-white hover:bg-gray-50 border-gray-200'}`;
                    if (currentPage === i) { btn.style.backgroundColor = '#004482'; btn.style.borderColor = '#004482'; }
                    else { btn.style.color = '#004482'; }
                    btn.onclick = () => { currentPage = i; renderPagination(); window.scrollTo(0, document.getElementById('fasilitasContainer').offsetTop - 100); };
                    pagContainer.appendChild(btn);
                }

                const btnNext = document.createElement('button');
                btnNext.innerHTML = '&raquo;';
                btnNext.disabled = currentPage === totalPages;
                btnNext.className = `px-3 py-1.5 border rounded-lg transition-colors text-sm ${currentPage === totalPages ? 'bg-gray-100 text-gray-300 cursor-not-allowed border-gray-200' : 'bg-white hover:bg-gray-50 border-gray-200'}`;
                if (currentPage !== totalPages) btnNext.style.color = '#004482';
                btnNext.onclick = () => { if(currentPage < totalPages) { currentPage++; renderPagination(); window.scrollTo(0, document.getElementById('fasilitasContainer').offsetTop - 100); } };
                pagContainer.appendChild(btnNext);
            }
        }

        document.getElementById('searchInput').addEventListener('input', filterItems);
        document.getElementById('filterGedung').addEventListener('change', filterItems);
        document.getElementById('filterUPPK').addEventListener('change', filterItems);

        const hero = document.getElementById('hero-section');
        hero.style.backgroundImage = `url('${hero.dataset.bg}')`;
        
        switchTab('ruang'); 
    </script>
</body>
</html>