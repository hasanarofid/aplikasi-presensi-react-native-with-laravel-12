<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Fina Mandiri Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Brand -->
        <div class="text-center mb-10">
            <div class="inline-block p-4 bg-white rounded-3xl shadow-sm mb-6">
                <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo" class="w-24 h-24 object-contain">
            </div>
            <h1 class="text-2xl font-bold text-slate-900">PT Fina Mandiri Sejahtera</h1>
            <p class="text-slate-500 mt-2">Admin Portal • Presence Management</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Sign In</h2>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="email">Email Address</label>
                    <input type="email" name="email" id="email" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                        placeholder="admin@fms.co.id"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-semibold text-slate-700" for="password">Password</label>
                        <a href="#" class="text-xs font-semibold text-[#1E3A8A] hover:underline">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all" 
                        placeholder="••••••••"
                        required>
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A]">
                    <label for="remember" class="text-sm text-slate-600">Remember me for 30 days</label>
                </div>
                
                <button type="submit" 
                    class="w-full bg-[#1E3A8A] text-white p-4 rounded-2xl font-bold text-lg hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all shadow-lg shadow-blue-900/20">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-400 text-sm mt-10">
            © 2026 PT Fina Mandiri Sejahtera. All rights reserved.
        </p>
    </div>
</body>
</html>

