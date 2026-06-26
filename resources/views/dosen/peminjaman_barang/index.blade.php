@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-headline-lg font-bold text-on-surface">Persetujuan Peminjaman Barang</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Review dan kelola pengajuan peminjaman inventaris barang dari mahasiswa.</p>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-2xl shadow-soft overflow-hidden">
        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low text-label-md text-outline uppercase tracking-wider border-b border-border-subtle">
                    <tr>
                        <th class="px-6 py-4 font-bold">Pemohon</th>
                        <th class="px-6 py-4 font-bold">Barang & Jumlah</th>
                        <th class="px-6 py-4 font-bold">Detail Acara</th>
                        <th class="px-6 py-4 font-bold">Jadwal Pinjam</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse($pengajuan as $p)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-on-surface">{{ $p->user->name }}</div>
                                <div class="text-label-md text-outline">{{ $p->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-on-surface">{{ $p->barang->nama_barang }}</div>
                                <div class="text-label-md text-outline mt-0.5 font-bold text-blue-600">{{ $p->jumlah_barang }} Unit</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-on-surface">{{ $p->nama_acara }}</div>
                                <div class="text-label-md text-outline">{{ $p->nama_penyelenggara }}</div>
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <div class="text-sm text-on-surface font-medium">
                                    {{ \Carbon\Carbon::parse($p->tgl_peminjaman)->format('d M Y') }} <br> s/d <br> {{ \Carbon\Carbon::parse($p->tgl_pengembalian)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @if($p->status_izin == 'Pending')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">Pending</span>
                                @elseif($p->status_izin == 'Disetujui')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Disetujui</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                @if($p->status_izin == 'Pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('dosen.peminjaman_barang.updateStatus', $p->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_izin" value="Disetujui">
                                            <button type="button" onclick="confirmAction(event, 'Approve', 'Setujui peminjaman barang ini?')" 
                                                    class="px-3 py-1.5 rounded-lg bg-emerald-50 text-success hover:bg-emerald-600 hover:text-white font-bold text-xs transition-colors shadow-sm">
                                                Approve
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('dosen.peminjaman_barang.updateStatus', $p->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_izin" value="Ditolak">
                                            <button type="button" onclick="confirmAction(event, 'Reject', 'Tolak peminjaman barang ini?')" 
                                                    class="px-3 py-1.5 rounded-lg bg-rose-50 text-danger hover:bg-rose-600 hover:text-white font-bold text-xs transition-colors shadow-sm">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="block w-full rounded-lg border border-border-subtle bg-surface-container-low px-3 py-2 text-[11px] leading-5 text-outline italic whitespace-normal sm:text-xs sm:leading-normal">Selesai Review</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="font-bold text-body-lg block">Belum Ada Pengajuan Masuk</span>
                                <span class="block text-label-md text-outline mt-1">Data peminjaman inventaris barang akan muncul di sini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-border-subtle">
            @forelse($pengajuan as $p)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-bold text-on-surface">{{ $p->user->name }}</div>
                            <div class="text-label-md text-outline">{{ $p->user->email }}</div>
                        </div>
                        @if($p->status_izin == 'Pending')
                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200 shrink-0">Pending</span>
                        @elseif($p->status_izin == 'Disetujui')
                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200 shrink-0">Disetujui</span>
                        @else
                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200 shrink-0">Ditolak</span>
                        @endif
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-3 space-y-1.5 text-body-md">
                        <div><span class="text-outline text-label-md uppercase tracking-wider">Barang</span><div class="font-bold text-on-surface">{{ $p->barang->nama_barang }}</div><div class="text-label-md font-bold text-primary">{{ $p->jumlah_barang }} Unit</div></div>
                        <div><span class="text-outline text-label-md uppercase tracking-wider">Acara</span><div class="font-semibold text-on-surface">{{ $p->nama_acara }}</div><div class="text-label-md text-outline">{{ $p->nama_penyelenggara }}</div></div>
                        <div><span class="text-outline text-label-md uppercase tracking-wider">Jadwal</span><div class="font-semibold text-on-surface">{{ \Carbon\Carbon::parse($p->tgl_peminjaman)->format('d M Y') }} &ndash; {{ \Carbon\Carbon::parse($p->tgl_pengembalian)->format('d M Y') }}</div></div>
                    </div>
                    @if($p->status_izin == 'Pending')
                        <div class="flex gap-2">
                            <form action="{{ route('dosen.peminjaman_barang.updateStatus', $p->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status_izin" value="Disetujui">
                                <button type="button" onclick="confirmAction(event, 'Approve', 'Setujui peminjaman barang ini?')" class="w-full px-3 py-2 rounded-lg bg-emerald-50 text-success hover:bg-emerald-600 hover:text-white font-bold text-xs transition-colors">Approve</button>
                            </form>
                            <form action="{{ route('dosen.peminjaman_barang.updateStatus', $p->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status_izin" value="Ditolak">
                                <button type="button" onclick="confirmAction(event, 'Reject', 'Tolak peminjaman barang ini?')" class="w-full px-3 py-2 rounded-lg bg-rose-50 text-danger hover:bg-rose-600 hover:text-white font-bold text-xs transition-colors">Reject</button>
                            </form>
                        </div>
                    @else
                        <span class="block w-full rounded-lg border border-border-subtle bg-surface-container-low px-3 py-2 text-[11px] leading-5 text-outline italic whitespace-normal text-center sm:text-xs sm:leading-normal">Selesai Review</span>
                    @endif
                </div>
            @empty
                <div class="px-6 py-12 text-center text-on-surface-variant">
                    <span class="font-bold text-body-lg block">Belum Ada Pengajuan Masuk</span>
                </div>
            @endforelse
        </div>
    </div>

</div>

    @if($pengajuan->hasPages())
    <div class="flex justify-center">
        {{ $pengajuan->links() }}
    </div>
    @endif

<div id="app-data" data-success="{{ session('success') }}" data-error="{{ session('error') }}" class="hidden"></div>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    const appData = document.getElementById('app-data');
    const sessionSuccess = appData.dataset.success;
    const sessionError = appData.dataset.error;
    if (sessionSuccess) Toast.fire({ icon: 'success', title: sessionSuccess });
    if (sessionError) Toast.fire({ icon: 'error', title: sessionError });

    function confirmAction(event, actionType, message) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        let confirmColor = actionType === 'Approve' ? '#10b981' : '#ef4444'; 
        let confirmIcon = actionType === 'Approve' ? 'question' : 'warning';

        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: confirmIcon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl font-bold',
                cancelButton: 'rounded-xl font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection