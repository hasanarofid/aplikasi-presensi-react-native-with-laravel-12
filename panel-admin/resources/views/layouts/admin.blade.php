<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - PT Fina Mandiri Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .sidebar-link { transition: all 0.3s; }
        .sidebar-link:hover { transform: translateX(5px); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ isOpen: false }" x-cloak>
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="isOpen = false" 
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden">
        </div>

        <!-- Sidebar -->
        <aside :class="isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:static w-72 bg-[#1E3A8A] text-white flex flex-col inset-y-0 shadow-2xl z-50 transform transition-transform duration-300 ease-in-out">
            <div class="p-8 pb-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-xl">
                        <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-tight">FMS Panel</span>
                        <span class="text-[10px] text-blue-200 uppercase tracking-widest font-bold">PT Fina Mandiri Sejahtera</span>
                    </div>
                </div>
                <!-- Close Mobile Button -->
                <button @click="isOpen = false" class="lg:hidden text-white/50 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 mt-8 px-4 space-y-2 overflow-y-auto">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'fas fa-chart-line', 'label' => 'Dashboard'],
                        ['route' => 'admin.employees.index', 'icon' => 'fas fa-user-friends', 'label' => 'Employees'],
                        ['route' => 'admin.shifts.index', 'icon' => 'fas fa-business-time', 'label' => 'Shift Management'],
                        ['route' => 'admin.attendances.index', 'icon' => 'fas fa-calendar-check', 'label' => 'Attendance Logs'],
                        ['route' => 'admin.approvals.index', 'icon' => 'fas fa-clipboard-check', 'label' => 'Leave Requests'],
                        ['route' => 'admin.settings', 'icon' => 'fas fa-sliders-h', 'label' => 'General Settings'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']) || 
                                   (str_contains($item['route'], '.index') && request()->routeIs(str_replace('.index', '.*', $item['route'])));
                    @endphp
                    <a href="{{ route($item['route']) }}" 
                       class="sidebar-link flex items-center py-3.5 px-4 rounded-2xl {{ $isActive ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-blue-100 hover:bg-white/5' }}">
                        <i class="{{ $item['icon'] }} w-6 text-xl mr-3 opacity-80"></i>
                        <span class="text-sm tracking-wide">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-6 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full py-3 px-4 rounded-xl text-red-100 hover:bg-red-500/20 transition-all font-semibold">
                        <i class="fas fa-power-off w-6 text-xl mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Navbar -->
            <header class="h-20 glass border-b border-slate-200 sticky top-0 z-30 px-4 md:px-8 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Hamburger Menu -->
                    <button @click="isOpen = true" class="mr-4 lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center lg:hidden">
                        <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo" class="w-8 h-8 object-contain mr-3">
                        <span class="font-bold text-slate-900 uppercase text-xs hidden sm:inline">FMS Admin</span>
                    </div>
                    <div class="flex-1 px-4 hidden lg:block">
                        <h1 class="text-xl font-bold text-slate-800">@yield('title', 'Overview')</h1>
                        <p class="text-xs text-slate-500 font-medium">Welcome back to your administration dashboard.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-5">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">Super Administrator</span>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-slate-200 border-2 border-white shadow-sm flex items-center justify-center font-bold text-slate-500">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="p-4 md:p-8">
                @if(session('success'))
                    <div class="flex items-center p-4 mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl shadow-sm">
                        <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center p-4 mb-6 bg-rose-50 border border-rose-100 text-rose-800 rounded-2xl shadow-sm">
                        <i class="fas fa-exclamation-circle mr-3 text-rose-500"></i>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="mt-auto py-8 text-center text-slate-400 text-[10px] md:text-xs border-t border-slate-200 bg-white">
                © 2026 PT Fina Mandiri Sejahtera. Dashboard developed for premium presence management.
            </footer>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

