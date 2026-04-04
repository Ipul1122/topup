<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - PULTOPUP</title>
    
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
            <h1 class="text-3xl font-bold text-slate-900 mb-6">Terms of Service</h1>
            <div class="prose max-w-none text-slate-600">
                <p>Please read these terms of service carefully before using Our Service.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">1. Interpretation and Definitions</h2>
                <p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">2. Acknowledgment</h2>
                <p>These are the Terms and Conditions governing the use of this Service and the agreement that operates between You and the Company. These Terms and Conditions set out the rights and obligations of all users regarding the use of the Service.</p>
                <p>Your access to and use of the Service is conditioned on Your acceptance of and compliance with these Terms and Conditions. These Terms and Conditions apply to all visitors, users and others who access or use the Service.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">3. User Accounts</h2>
                <p>When You create an account with Us, You must provide Us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of Your account on Our Service.</p>

                <h2 class="text-xl font-semibold text-slate-800 mt-6">4. Termination</h2>
                <p>We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these Terms and Conditions.</p>

                <p class="mt-8"><strong>Last updated:</strong> April 4, 2026</p>
            </div>
        </div>
    </main>

    @include('layouts.footerComponent')

</body>
</html>