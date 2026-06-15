<div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-surface-container-lowest border-b border-outline-variant flex items-center px-4 z-40 shadow-soft gap-4">
    <button id="openSidebarBtn" class="p-2 rounded-xl text-primary hover:bg-surface-container-low transition-colors">
        <span class="material-symbols-outlined text-headline-md">menu</span>
    </button>
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-headline-md">school</span>
        <span class="font-bold text-title-md text-primary tracking-wide">Petra Borrow</span>
    </div>
</div>

<div id="sidebarBackdrop" class="hidden fixed inset-0 bg-black/40 z-40 md:hidden backdrop-blur-xs opacity-0 transition-opacity duration-300"></div>

<aside id="sidebarMenu" class="fixed top-0 left-0 z-50 w-64 h-screen bg-surface-container-lowest border-r border-outline-variant flex flex-col justify-between p-5 shadow-soft -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <div>
        <div class="flex items-center justify-between px-2 py-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-headline-md">school</span>
                <div class="flex flex-col">
                    <span class="font-bold text-title-lg text-primary tracking-wide leading-none">Petra Borrow</span>
                    <span class="text-[10px] text-outline font-medium tracking-wider uppercase mt-1">Fasilitas Kampus</span>
                </div>
            </div>

            <button id="closeSidebarBtn" class="md:hidden p-1.5 rounded-lg text-outline hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <nav class="space-y-1.5">
            @auth
                @if(auth()->user()->role_id == 1)
                    @include('partials.nav-admin')
                @elseif(auth()->user()->role_id == 2)
                    @include('partials.nav-mahasiswa')
                @elseif(auth()->user()->role_id == 3)
                    @include('partials.nav-dosen')
                @endif
            @endauth
        </nav>
    </div>

    @auth
    <div class="border-t border-outline-variant pt-4 flex flex-col gap-3">
        <div class="flex items-center gap-3 px-2 py-1.5 rounded-xl bg-surface-container-low">
            <div class="w-10 h-10 rounded-full bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center font-semibold text-body-lg shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex flex-col truncate">
                <span class="text-body-md font-semibold text-on-surface truncate">{{ auth()->user()->name }}</span>
                <span class="text-label-md text-outline capitalize">
                    @if(auth()->user()->role_id == 1) Admin 
                    @elseif(auth()->user()->role_id == 2) Mahasiswa 
                    @else Dosen @endif
                </span>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-error rounded-xl hover:bg-error-container hover:text-on-error-container transition-all duration-200 text-body-md font-medium group cursor-pointer">
                <span class="material-symbols-outlined text-body-lg group-hover:scale-105 transition-transform">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
    @endauth

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebarMenu');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar(isOpen) {
            if (isOpen) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }

        if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
        if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
        if (backdrop) backdrop.addEventListener('click', () => toggleSidebar(false));
    });
</script>