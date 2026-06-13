<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Petra Borrow | Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background min-h-screen flex items-center justify-center p-margin-mobile md:p-gutter">

    <main class="w-full max-w-[1000px] grid grid-cols-1 md:grid-cols-2 bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-border-subtle min-h-[640px]">
        
        <div class="hidden md:flex flex-col justify-between p-stack-lg bg-surface-container relative overflow-hidden">
            <div class="absolute inset-0 opacity-5 pointer-events-none grid-pattern"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-headline-md">school</span>
                    <span class="text-title-lg font-bold">Petra Borrow</span>
                </div>
                <h1 class="mt-stack-lg text-headline-lg font-bold text-on-surface leading-tight">
                    Smart Resource <br/>Management for <br/>Petra Excellence.
                </h1>
                <p class="mt-stack-sm text-body-lg text-on-surface-variant max-w-[320px]">
                    Access classrooms, equipment, and laboratory facilities with your university credentials.
                </p>
            </div>
            
            <div class="relative z-10">
                <img alt="Petra Christian University Campus" class="w-full h-48 object-cover rounded-lg shadow-sm border border-border-subtle mb-stack-md" src="https://placehold.co/600x400"/>
                <div class="flex items-center gap-3">
                    <div class="h-1 w-12 bg-primary rounded-full"></div>
                    <div class="h-1 w-4 bg-outline-variant rounded-full"></div>
                    <div class="h-1 w-4 bg-outline-variant rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center p-stack-lg md:p-16 bg-surface-container-lowest">
            <div class="mb-stack-lg">
                <h2 class="text-headline-md font-bold text-on-surface">Welcome Back</h2>
                <p class="text-body-md text-on-surface-variant mt-1">Please enter your university details to continue.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-stack-md">
                @csrf

                <div class="space-y-2">
                    <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider" for="email">University Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">alternate_email</span>
                        <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low border @error('email') border-danger @else border-border-subtle @enderror rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               pattern=".+@(petra\.ac\.id|john\.petra\.ac\.id)$" 
                               placeholder="username@petra.ac.id" 
                               required 
                               title="Please use your @petra.ac.id or @john.petra.ac.id email address" 
                               type="email"/>
                    </div>
                    @error('email')
                        <p class="text-xs text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider" for="password">Password</label>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full pl-10 pr-12 py-3 bg-surface-container-low border @error('password') border-danger @else border-border-subtle @enderror rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••" 
                               required 
                               type="password"/>
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="password-toggle-icon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between py-1">
                    {{-- <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="peer h-5 w-5 rounded border-outline text-primary focus:ring-primary cursor-pointer transition-all" type="checkbox" name="remember" id="remember"/>
                        <span class="text-body-md text-on-surface-variant group-hover:text-on-surface transition-colors">Remember Me</span>
                    </label> --}}
                    <a class="text-label-md font-bold text-primary hover:underline underline-offset-4" href="#">Forgot Password?</a>
                </div>

                <button class="w-full bg-primary text-on-primary font-bold py-3.5 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    Login to Petra Borrow
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <div class="mt-stack-lg pt-stack-md border-t border-border-subtle text-center">
                <p class="text-body-md text-on-surface-variant">
                    Need technical assistance? 
                    <a class="text-primary font-bold hover:underline" href="#">Contact BAA</a>
                </p>
            </div>
        </div>
    </main>

    <div class="fixed inset-0 -z-10 opacity-30 pointer-events-none overflow-hidden">
        <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[60%] bg-primary-container rounded-full blur-[120px] opacity-20 transition-transform duration-300 ease-out"></div>
        <div class="absolute -bottom-[10%] -right-[5%] w-[40%] h-[60%] bg-secondary-container rounded-full blur-[120px] opacity-20 transition-transform duration-300 ease-out"></div>
    </div>

    <script>
        // Fungsi pembuka/penutup enkripsi password saat mata diklik
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        // Efek transisi halus mengikuti kursor mouse untuk background orbs bawaan Stitch
        document.addEventListener('mousemove', (e) => {
            const orbs = document.querySelectorAll('.fixed > div');
            if (orbs.length >= 2) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                orbs[0].style.transform = `translate(${x * 30}px, ${y * 30}px)`;
                orbs[1].style.transform = `translate(${-x * 30}px, ${-y * 30}px)`;
            }
        });
    </script>
</body>
</html>