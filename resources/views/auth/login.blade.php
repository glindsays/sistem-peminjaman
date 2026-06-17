<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SIFAS | Login</title>
    
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
                    <span class="text-title-lg font-bold">SIFAS</span>
                </div>
                <h1 class="mt-stack-lg text-headline-lg font-bold text-on-surface leading-tight">
                    Smart Resource <br/>Management for <br/>Petra Excellence.
                </h1>
                <p class="mt-stack-sm text-body-md text-on-surface-variant max-w-[320px]">
                    Access classrooms, equipment, and laboratory facilities with your university credentials.
                </p>
            </div>
            
            <div class="relative z-10 w-full mb-2">
                <div class="relative h-48 w-full overflow-hidden rounded-lg shadow-sm border border-border-subtle bg-surface-container-low">
                    <img class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-100" 
                         src="{{ asset('images/pcu1.jpg') }}" alt="Petra Campus Slide 1"/>
                    
                    <img class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0" 
                         src="{{ asset('images/pcu2.jpg') }}" alt="Petra Campus Slide 2"/>
                    
                    <img class="slide-img absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0" 
                         src="{{ asset('images/rektor.jpg') }}" alt="Rektor"/>
                </div>  
                <div class="flex items-center gap-2 mt-4">
                    <div class="slide-dot h-1 w-12 bg-primary rounded-full transition-all duration-300"></div>
                    <div class="slide-dot h-1 w-4 bg-outline-variant rounded-full transition-all duration-300"></div>
                    <div class="slide-dot h-1 w-4 bg-outline-variant rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center p-stack-lg md:p-16 bg-surface-container-lowest">
            <div class="mb-6">
                <h2 class="text-headline-md font-bold text-on-surface">Welcome Back</h2>
                <p class="text-body-md text-on-surface-variant mt-1">Please enter your university details to continue.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
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
                        
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="password-toggle-icon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-primary text-on-primary font-bold py-3.5 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    Login to SIFAS
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <div class="relative flex py-4 items-center">
                <div class="flex-grow border-t border-border-subtle"></div>
                <span class="flex-shrink mx-4 text-label-md text-on-surface-variant uppercase tracking-wider font-bold">Or</span>
                <div class="flex-grow border-t border-border-subtle"></div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('login.google') }}" class="w-full bg-surface-container-low border border-border-subtle text-on-surface font-bold py-3.5 rounded-lg shadow-sm hover:bg-surface-container transition-all flex items-center justify-center gap-3 active:scale-[0.98]">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                    </svg>
                    Sign in with Google
                </a>
                <p class="text-xs text-on-surface-variant text-center tracking-wide italic">
                    please login with your petra account
                </p>
            </div>

            <div class="mt-8 pt-6 border-t border-border-subtle text-center">
                <p class="text-body-md text-on-surface-variant">
                    Need technical assistance? 
                    <a class="text-primary font-bold hover:underline inline-flex items-center gap-1" 
                       href="https://wa.me/6281234067323?text=Halo%20BAA%20Petra%2C%20saya%20butuh%20bantuan%20terkait%20kendala%20sistem%20login%20di%20aplikasi%20SIFAS." 
                       target="_blank" 
                       rel="noopener noreferrer">
                        Contact BAA
                    </a>
                </p>
            </div>
        </div>
    </main>

    <div class="fixed inset-0 -z-10 opacity-30 pointer-events-none overflow-hidden">
        <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[60%] bg-primary-container rounded-full blur-[120px] opacity-20 transition-transform duration-300 ease-out"></div>
        <div class="absolute -bottom-[10%] -right-[5%] w-[40%] h-[60%] bg-secondary-container rounded-full blur-[120px] opacity-20 transition-transform duration-300 ease-out"></div>
    </div>

    <script>
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

        document.addEventListener('mousemove', (e) => {
            const orbs = document.querySelectorAll('.fixed > div');
            if (orbs.length >= 2) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                orbs[0].style.transform = `translate(${x * 30}px, ${y * 30}px)`;
                orbs[1].style.transform = `translate(${-x * 30}px, -${y * 30}px)`;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            let currentSlide = 0;
            const images = document.querySelectorAll('.slide-img');
            const dots = document.querySelectorAll('.slide-dot');
            const totalSlides = images.length;

            function nextSlide() {
                if (images.length === 0) return;
                images[currentSlide].classList.replace('opacity-100', 'opacity-0');
                dots[currentSlide].classList.replace('w-12', 'w-4');
                dots[currentSlide].classList.replace('bg-primary', 'bg-outline-variant');

                currentSlide = (currentSlide + 1) % totalSlides;

                images[currentSlide].classList.replace('opacity-0', 'opacity-100');
                dots[currentSlide].classList.replace('w-4', 'w-12');
                dots[currentSlide].classList.replace('bg-outline-variant', 'bg-primary');
            }

            setInterval(nextSlide, 3000);
        });
    </script>
</body>
</html>