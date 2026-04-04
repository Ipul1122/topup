<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PULTOPUP - Top Up Games</title>
    
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
        <h1 class="text-3xl font-bold text-slate-900 mb-4">Selamat datang di website pultopup!</h1>
        <p class="text-lg text-slate-600 mb-8">Silahkan pilih topup yang kamu inginkan dari berbagai game populer.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ url('/mobile-legends') }}" class="block bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6">
                <img src="https://upload.wikimedia.org/wikipedia/en/e/e5/Mobile_Legends_Bang_Bang_logo.png" alt="Mobile Legends Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Mobile Legends</h2>
                <p class="text-sm text-slate-500 mt-2">Top up Diamond Mobile Legends</p>
            </a>
            
            <!-- Tambahkan game lain di sini nanti -->
            <div class="block bg-white rounded-2xl shadow-md p-6 opacity-50 cursor-not-allowed">
                <img src="https://upload.wikimedia.org/wikipedia/en/2/2f/Free_Fire_logo.png" alt="Free Fire Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Free Fire</h2>
                <p class="text-sm text-slate-500 mt-2">Segera hadir</p>
            </div>
            
            <div class="block bg-white rounded-2xl shadow-md p-6 opacity-50 cursor-not-allowed">
                <img src="https://upload.wikimedia.org/wikipedia/en/thumb/e/e0/Clash_of_Clans_Logo.png/220px-Clash_of_Clans_Logo.png" alt="Clash of Clans Logo" class="w-24 h-24 mx-auto mb-4 object-contain">
                <h2 class="text-xl font-semibold text-slate-800">Clash Of Clans</h2>
                <p class="text-sm text-slate-500 mt-2">Segera hadir</p>
            </div>
        </div>
    </main>

    @include('layouts.footerComponent')

</body>
</html>