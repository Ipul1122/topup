<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skyfoxmarket - Top Up Games</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white pb-20">

    @include('layouts.navbarComponent')

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 text-center">
        <h1 class="text-3xl font-bold text-slate-900 mb-4">Selamat datang di website skyfoxmarket!</h1>
        <p class="text-lg text-slate-600 mb-8">Silahkan pilih topup yang kamu inginkan dari berbagai game populer.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ url('/mobile-legends') }}" class="block bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6">
                <img src="{{ asset('image/mobile-legends-logo.jpg') }}" alt="Mobile Legends Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Mobile Legends</h2>
                <p class="text-sm text-slate-500 mt-2">Top up Diamond Mobile Legends</p>
            </a>
            
            <!-- Tambahkan game lain di sini nanti -->
            <a href="{{ url('/free-fire') }}" class="block bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6">
                <img src="{{ asset('image/free-fire-logo.jpg') }}" alt="Free Fire Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Free Fire</h2>
                <p class="text-sm text-slate-500 mt-2">Top up Diamond Free Fire</p>
            </a>
            
            <div class="block bg-white rounded-2xl shadow-md p-6 opacity-50 cursor-not-allowed">
                <img src="{{ asset('image/clash-of-clans-logo.jpg') }}" alt="Clash of Clans Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Clash Of Clans</h2>
                <p class="text-sm text-slate-500 mt-2">Segera hadir</p>
            </div>
        </div>
    </main>

    @include('layouts.footerComponent')

</body>
</html>