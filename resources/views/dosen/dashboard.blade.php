@extends('layouts.app')

@section('title', 'Student Dashboard - Petra Borrow')

@section('content')
<div class="p-margin-desktop max-w-container-max mx-auto space-y-stack-lg">
    
    <section class="relative overflow-hidden rounded-2xl bg-primary h-56 flex items-center px-12 text-on-primary">
        <div class="relative z-10 w-full md:w-2/3">
            <h2 class="font-headline-lg text-headline-lg mb-2 text-white">Welcome back, Petra Student!</h2>
            <p class="font-body-lg text-body-lg opacity-90 max-w-lg text-white/90 font-light">
                Manage your facility requests and equipment borrowings effortlessly. Your campus experience starts here.
            </p>
            <div class="mt-6 flex gap-4">
                <button class="bg-surface-container-lowest text-primary px-6 py-2 rounded-xl font-bold hover:bg-white transition-colors flex items-center gap-2 text-sm shadow-soft">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    New Request
                </button>
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 opacity-20 hidden md:block">
            <img class="object-cover h-full w-full" src="https://placehold.co/400x300" alt="Campus Facade"/>
        </div>
        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-primary-container rounded-full opacity-30 blur-3xl"></div>
    </section>

    <section class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold text-on-background">Recent Requests</h3>
                <p class="text-sm text-on-surface-variant">Track and manage your current facility and equipment bookings.</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-primary font-semibold hover:underline flex items-center gap-1 text-sm">
                    <span class="material-symbols-outlined text-[20px]">history</span>
                    View History
                </button>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-border-subtle overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant font-semibold text-xs uppercase tracking-wider">
                            <th class="px-6 py-4">Request ID</th>
                            <th class="px-6 py-4">Facility Name</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-primary font-semibold">#PB-2024-089</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-primary-container/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-sm">meeting_room</span>
                                    </div>
                                    <span>Multimedia Room B-201</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Room</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Oct 14, 2024</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning border border-warning/20">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    <button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="View">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-secondary hover:bg-secondary/10 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-danger hover:bg-danger/10 rounded-lg transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-primary font-semibold">#PB-2024-088</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-secondary-container/10 flex items-center justify-center text-secondary">
                                        <span class="material-symbols-outlined text-sm">camera_enhance</span>
                                    </div>
                                    <span>Sony A7III Mirrorless Camera</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Equipment</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Oct 12, 2024</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success border border-success/20">
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="View">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-primary font-semibold">#PB-2024-087</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-primary-container/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-sm">computer</span>
                                    </div>
                                    <span>Graphic Lab Station 04</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Room</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Oct 10, 2024</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger border border-danger/20">
                                    Rejected
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="View">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-primary font-semibold">#PB-2024-085</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-secondary-container/10 flex items-center justify-center text-secondary">
                                        <span class="material-symbols-outlined text-sm">speaker</span>
                                    </div>
                                    <span>Portable Sound System XL</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Equipment</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">Oct 08, 2024</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success border border-success/20">
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="View">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Micro-interactions animasi klik button dari Stitch
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'scale(0.97)';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = 'scale(1)';
        });
    });
</script>
@endpush