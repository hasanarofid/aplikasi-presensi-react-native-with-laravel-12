<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Presensi App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-indigo-900 mb-8">Admin Login</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email Address</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            
            <button type="submit" class="w-full bg-indigo-900 text-white p-3 rounded font-bold hover:bg-indigo-800 transition">Login</button>
        </form>
    </div>
</body>
</html>
