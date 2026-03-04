<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Presensi App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-indigo-900 text-white flex-shrink-0">
            <div class="p-6 text-2xl font-bold border-b border-indigo-800">
                Presensi Admin
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.employees.index') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.employees.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-users mr-3"></i> Employees
                </a>
                <a href="{{ route('admin.shifts.index') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.shifts.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-clock mr-3"></i> Shifts
                </a>
                <a href="{{ route('admin.attendances.index') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.attendances.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-calendar-check mr-3"></i> Attendances
                </a>
                <a href="{{ route('admin.approvals.index') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.approvals.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-tasks mr-3"></i> Approvals
                </a>
                <a href="{{ route('admin.settings') }}" class="block py-3 px-6 hover:bg-indigo-800 {{ request()->routeIs('admin.settings') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-10">
                    @csrf
                    <button type="submit" class="w-full text-left py-3 px-6 hover:bg-red-800 text-red-300">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            <header class="mb-8 flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                <div class="text-gray-600">
                    Welcome, <span class="font-bold text-indigo-700">{{ auth()->user()->name }}</span>
                </div>
            </header>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
