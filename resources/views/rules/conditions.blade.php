<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditions - PULTOPUP</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white pb-20">

    @include('layouts.navbarComponent')

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white rounded-2xl shadow-md p-6 lg:p-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-6">Conditions of Use</h1>
            <div class="prose max-w-none text-slate-600">
                <p>Welcome to pultopup. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following conditions of use, which together with our privacy policy govern pultopup's relationship with you in relation to this website.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">1. Use of the Website</h2>
                <p>By using this website, you warrant that you are at least 18 years of age or are accessing the website under the supervision of a parent or legal guardian.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">2. Product and Service Information</h2>
                <p>All prices displayed are in Indonesian Rupiah (IDR). Prices and availability of products are subject to change without prior notice. We strive to provide accurate product and pricing information, however, pricing or typographical errors may occur.</p>
                
                <h2 class="text-xl font-semibold text-slate-800 mt-6">3. Payment</h2>
                <p>Payment can be made via the payment gateways available on our website. We use a third-party payment provider to process payments securely. We do not store your credit card details.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">4. Limitation of Liability</h2>
                <p>pultopup will not be liable for any direct, indirect, incidental, special, or consequential damages that result from the use of, or the inability to use, the service or products purchased from the site.</p>

                <p class="mt-8"><strong>Last updated:</strong> April 4, 2026</p>
            </div>
        </div>
    </main>

    @include('layouts.footerComponent')

</body>
</html>