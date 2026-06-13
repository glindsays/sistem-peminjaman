<header class="sticky top-0 z-50 bg-surface-container-lowest border-b border-border-subtle h-16 w-full flex justify-between items-center px-margin-desktop shadow-sm">
    <div class="flex items-center gap-12">
        <div class="flex flex-col">
            <h1 class="text-title-md font-black text-primary leading-tight">Petra Borrow</h1>
            <p class="text-[10px] font-label-md text-on-surface-variant uppercase tracking-tighter">Facility Management</p>
        </div>
        
        <nav class="flex items-center gap-8 h-16">
            <a class="flex items-center gap-2 {{ Request::is('dashboard*') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary transition-colors' }} h-full px-1" href="/dashboard-mhs">
                <span class="material-symbols-outlined text-[20px]" data-icon="dashboard">dashboard</span>
                <span class="text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-2 {{ Request::is('/') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary transition-colors' }} h-full px-1" href="/">
                <span class="material-symbols-outlined text-[20px]" data-icon="meeting_room">meeting_room</span>
                <span class="text-body-md">Room Catalog</span>
            </a>
            <a class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors h-full px-1" href="#">
                <span class="material-symbols-outlined text-[20px]" data-icon="inventory_2">inventory_2</span>
                <span class="text-body-md">Equipment Catalog</span>
            </a>
        </nav>
    </div>

    <div class="flex items-center gap-6">
        <div class="relative group hidden md:block">
            <input class="pl-10 pr-4 py-2 bg-surface-container rounded-full border-none focus:ring-2 focus:ring-primary text-body-md w-64 transition-all group-hover:bg-surface-container-high" placeholder="Search resources..." type="text"/>
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
        </div>
        <div class="flex items-center gap-3">
            <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
            </button>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-on-surface-variant hover:text-danger px-4 py-2 rounded-lg hover:bg-surface-container-low transition-colors w-full text-left">
                    <span class="material-symbols-outlined text-body-lg">logout</span>
                    <span class="text-body-md font-semibold">Logout</span>
                </button>
            </form>
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-container cursor-pointer hover:opacity-90 transition-opacity">
                <img alt="User profile avatar" src="https://placehold.co/100x100" class="w-full h-full object-cover"/>
            </div>
        </div>
    </div>
</header>