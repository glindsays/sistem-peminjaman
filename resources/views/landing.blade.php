<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <title>@yield('title', 'Petra Borrow | Sistem Peminjaman Kampus')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface flex flex-col min-h-screen">
    <section class="relative overflow-hidden py-24 px-margin-desktop grid-pattern min-h-[716px] flex flex-col justify-center">
        <div class="max-w-3xl relative z-10">
            <span class="inline-block bg-primary-container text-on-primary-container px-4 py-1.5 rounded-full font-label-md text-label-md mb-6 animate-fade-in">
                OFFICIAL CAMPUS RESOURCE PORTAL
            </span>
            <h1 class="font-display-lg text-display-lg text-on-background mb-8 leading-[1.1]">
                Campus Room & Equipment <br/><span class="text-primary">Borrowing System</span>
            </h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant mb-10 max-w-xl">
                Streamlined facility management for Petra Christian University. Reserve specialized laboratories, study rooms, and high-end equipment with real-time availability tracking.
            </p>
            <div class="flex flex-wrap gap-4">
                <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-title-md text-title-md shadow-soft hover:shadow-lg transition-all active:scale-95">
                    Borrow Now
                </button>
                <button class="bg-surface-container-lowest text-primary border border-primary px-8 py-4 rounded-xl font-title-md text-title-md hover:bg-surface-container-low transition-all">
                    Check Availability
                </button>
            </div>
        </div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/2 h-[500px] hidden lg:block opacity-20 pointer-events-none">
            <div class="w-full h-full bg-primary rounded-l-[100px] rotate-12 blur-3xl"></div>
        </div>
    </section>

    <section class="px-margin-desktop py-stack-lg">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-background">Resource Availability</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Live monthly status overview of all campus facilities</p>
            </div>
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-success"></span>
                    <span class="text-label-md font-label-md">Available</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-danger"></span>
                    <span class="text-label-md font-label-md">Occupied</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="md:col-span-8 bg-surface-container-lowest rounded-3xl shadow-soft p-stack-md border border-border-subtle">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-title-lg text-title-lg">November 2024</h3>
                    <div class="flex gap-2">
                        <button class="p-2 hover:bg-surface-container-low rounded-lg border border-border-subtle">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button class="p-2 hover:bg-surface-container-low rounded-lg border border-border-subtle">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">MON</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">TUE</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">WED</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">THU</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">FRI</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">SAT</div>
                    <div class="text-center py-2 font-label-md text-label-md text-on-surface-variant">SUN</div>
                    <div class="h-24"></div>
                    <div class="h-24"></div>
                    <div class="h-24"></div>
                    <div class="h-24 bg-success/10 border border-success/20 rounded-xl p-2 flex flex-col justify-between group cursor-pointer hover:bg-success/20 transition-colors">
                        <span class="font-label-md text-label-md">1</span>
                        <div class="space-y-1">
                            <div class="w-full h-1 bg-success rounded-full"></div>
                            <div class="w-full h-1 bg-success rounded-full"></div>
                        </div>
                    </div>
                    <div class="h-24 bg-danger/10 border border-danger/20 rounded-xl p-2 flex flex-col justify-between group cursor-pointer hover:bg-danger/20 transition-colors">
                        <span class="font-label-md text-label-md">2</span>
                        <div class="space-y-1">
                            <div class="w-2/3 h-1 bg-danger rounded-full"></div>
                        </div>
                    </div>
                    <div class="h-24 bg-success/10 border border-success/20 rounded-xl p-2 flex flex-col justify-between cursor-pointer">
                        <span class="font-label-md text-label-md">3</span>
                        <div class="space-y-1"><div class="w-full h-1 bg-success rounded-full"></div></div>
                    </div>
                    <div class="h-24 bg-success/10 border border-success/20 rounded-xl p-2 flex flex-col justify-between cursor-pointer">
                        <span class="font-label-md text-label-md">4</span>
                        <div class="space-y-1"><div class="w-full h-1 bg-success rounded-full"></div></div>
                    </div>
                    
                    <script>
                        for(let i=5; i<=30; i++) {
                            const status = Math.random() > 0.3 ? 'success' : 'danger';
                            document.write(`
                                <div class="h-24 bg-${status}/10 border border-${status}/20 rounded-xl p-2 flex flex-col justify-between cursor-pointer hover:bg-${status}/20 transition-colors">
                                    <span class="font-label-md text-label-md">${i}</span>
                                    <div class="space-y-1"><div class="w-${Math.random() > 0.5 ? 'full' : '2/3'} h-1 bg-${status} rounded-full"></div></div>
                                </div>
                            `);
                        }
                    </script>
                </div>
            </div>
            
            <div class="md:col-span-4 flex flex-col gap-6">
                <div class="bg-primary text-on-primary rounded-3xl p-stack-md shadow-soft">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined">analytics</span>
                        <span class="font-title-md text-title-md">System Statistics</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-on-primary/70 font-label-md text-label-md">ACTIVE RESERVATIONS</p>
                            <p class="text-3xl font-bold">142</p>
                        </div>
                        <div>
                            <p class="text-on-primary/70 font-label-md text-label-md">RESOURCES FREE</p>
                            <p class="text-3xl font-bold">28</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-surface-container-high rounded-3xl p-stack-md border border-border-subtle overflow-hidden">
                    <h4 class="font-title-md text-title-md mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        Live Traffic
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-surface-container-lowest p-3 rounded-2xl border border-border-subtle">
                            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined">meeting_room</span>
                            </div>
                            <div>
                                <p class="font-title-md text-title-md">AV Room 204</p>
                                <p class="text-label-md text-on-surface-variant">Occupied until 14:00</p>
                            </div>
                            <span class="ml-auto w-2 h-2 rounded-full bg-danger animate-pulse"></span>
                        </div>
                        <div class="flex items-center gap-4 bg-surface-container-lowest p-3 rounded-2xl border border-border-subtle">
                            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined">videocam</span>
                            </div>
                            <div>
                                <p class="font-title-md text-title-md">Sony A7 IV Kit</p>
                                <p class="text-label-md text-on-surface-variant">Available for pickup</p>
                            </div>
                            <span class="ml-auto w-2 h-2 rounded-full bg-success"></span>
                        </div>
                        <div class="flex items-center gap-4 bg-surface-container-lowest p-3 rounded-2xl border border-border-subtle">
                            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined">laptop_mac</span>
                            </div>
                            <div>
                                <p class="font-title-md text-title-md">iMac Studio Lab</p>
                                <p class="text-label-md text-on-surface-variant">2 seats available</p>
                            </div>
                            <span class="ml-auto w-2 h-2 rounded-full bg-success"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-margin-desktop py-stack-lg bg-surface-container-low/50">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-background">Featured Facilities</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Browse our premium spaces and top-tier equipment</p>
            </div>
            <button class="text-primary font-bold flex items-center gap-2 hover:translate-x-1 transition-transform">
                View Catalog <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-stack-lg">
            <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-soft group border border-border-subtle">
                <div class="h-56 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://placehold.co/600x400" alt="Multimedia Laboratory"/>
                    <div class="absolute top-4 left-4 bg-success text-on-primary px-3 py-1 rounded-full text-label-md font-label-md">Available</div>
                </div>
                <div class="p-6">
                    <p class="text-label-md font-label-md text-primary mb-1 uppercase tracking-wider">Multimedia Laboratory</p>
                    <h3 class="font-title-lg text-title-lg mb-4">Space-X Studio 402</h3>
                    <div class="flex items-center gap-4 text-on-surface-variant font-body-md text-body-md">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">groups</span> 12 Pax</span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> Building Q, 4F</span>
                    </div>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-soft group border border-border-subtle">
                <div class="h-56 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://placehold.co/600x400" alt="Quiet Zone"/>
                    <div class="absolute top-4 left-4 bg-danger text-on-primary px-3 py-1 rounded-full text-label-md font-label-md">Occupied</div>
                </div>
                <div class="p-6">
                    <p class="text-label-md font-label-md text-primary mb-1 uppercase tracking-wider">Quiet Zone</p>
                    <h3 class="font-title-lg text-title-lg mb-4">Focus Capsule 10A</h3>
                    <div class="flex items-center gap-4 text-on-surface-variant font-body-md text-body-md">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">groups</span> 2 Pax</span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> Library, 2F</span>
                    </div>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-soft group border border-border-subtle">
                <div class="h-56 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://placehold.co/600x400" alt="Conference Hall"/>
                    <div class="absolute top-4 left-4 bg-success text-on-primary px-3 py-1 rounded-full text-label-md font-label-md">Available</div>
                </div>
                <div class="p-6">
                    <p class="text-label-md font-label-md text-primary mb-1 uppercase tracking-wider">Conference Hall</p>
                    <h3 class="font-title-lg text-title-lg mb-4">Grand Auditorium Q</h3>
                    <div class="flex items-center gap-4 text-on-surface-variant font-body-md text-body-md">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">groups</span> 250 Pax</span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> Building Q, 1F</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
            <div class="bg-surface-container-lowest p-4 rounded-3xl border border-border-subtle hover:border-primary transition-all cursor-pointer group">
                <div class="aspect-square rounded-2xl bg-surface-container mb-4 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-primary group-hover:scale-110 transition-transform">photo_camera</span>
                </div>
                <h4 class="font-title-md text-title-md">DSLR Camera Kit</h4>
                <p class="text-label-md text-on-surface-variant mb-2">Sony Alpha Series</p>
                <div class="flex justify-between items-center">
                    <span class="text-label-md font-bold text-success">5 In Stock</span>
                    <span class="material-symbols-outlined text-on-surface-variant">add_circle</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-4 rounded-3xl border border-border-subtle hover:border-primary transition-all cursor-pointer group">
                <div class="aspect-square rounded-2xl bg-surface-container mb-4 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-primary group-hover:scale-110 transition-transform">mic</span>
                </div>
                <h4 class="font-title-md text-title-md">Podcast Gear</h4>
                <p class="text-label-md text-on-surface-variant mb-2">Shure SM7B + Rodecaster</p>
                <div class="flex justify-between items-center">
                    <span class="text-label-md font-bold text-success">2 In Stock</span>
                    <span class="material-symbols-outlined text-on-surface-variant">add_circle</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-4 rounded-3xl border border-border-subtle hover:border-primary transition-all cursor-pointer group">
                <div class="aspect-square rounded-2xl bg-surface-container mb-4 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-primary group-hover:scale-110 transition-transform">laptop_mac</span>
                </div>
                <h4 class="font-title-md text-title-md">MacBook Pro 16"</h4>
                <p class="text-label-md text-on-surface-variant mb-2">M2 Max / 32GB RAM</p>
                <div class="flex justify-between items-center">
                    <span class="text-label-md font-bold text-danger">Out of Stock</span>
                    <span class="material-symbols-outlined text-on-surface-variant">info</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-4 rounded-3xl border border-border-subtle hover:border-primary transition-all cursor-pointer group">
                <div class="aspect-square rounded-2xl bg-surface-container mb-4 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-primary group-hover:scale-110 transition-transform">lightbulb</span>
                </div>
                <h4 class="font-title-md text-title-md">Studio Lighting</h4>
                <p class="text-label-md text-on-surface-variant mb-2">Godox Softbox Kit</p>
                <div class="flex justify-between items-center">
                    <span class="text-label-md font-bold text-success">8 In Stock</span>
                    <span class="material-symbols-outlined text-on-surface-variant">add_circle</span>
                </div>
            </div>
        </div>
    </section>

    <section class="px-margin-desktop py-stack-lg text-center">
        <div class="bg-inverse-surface text-inverse-on-surface rounded-[48px] p-stack-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none grid-pattern"></div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="font-headline-lg text-headline-lg mb-4">Ready to start your project?</h2>
                <p class="font-body-lg text-body-lg mb-8 opacity-80">Access world-class facilities and equipment at Petra Christian University. Your creative and academic journey starts here.</p>
                <button class="bg-primary-fixed text-on-primary-fixed px-10 py-4 rounded-2xl font-title-md text-title-md hover:scale-105 transition-transform active:scale-95">
                    Log In with Petra ID
                </button>
            </div>
        </div>
    </section>

    <button class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center z-[100] active:scale-90 transition-transform">
        <span class="material-symbols-outlined">add</span>
    </button>
</body>



    <script>
        // Micro-interactions and atmospheric effects
        document.addEventListener('mousemove', (e) => {
            const blobs = document.querySelectorAll('.hero-blob');
            const x = (window.innerWidth - e.pageX) / 20;
            const y = (window.innerHeight - e.pageY) / 20;
            blobs.forEach(blob => {
                blob.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Simple scroll reveal
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            section.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
            observer.observe(section);
        });
    </script>

</html>