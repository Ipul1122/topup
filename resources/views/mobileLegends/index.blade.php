<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Mobile Legends - pultopup</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Sembunyikan panah input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white pb-20">

    @include('layouts.navbarComponent')

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="lg:w-1/3">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
                    <div class="h-40 bg-slate-900 relative">
                        <img src="https://esports.id/img/article/525620200508124032.jpg" alt="MLBB Banner" class="w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                    </div>
                    
                    <div class="p-6 relative">
                        <img src="https://upload.wikimedia.org/wikipedia/en/e/e5/Mobile_Legends_Bang_Bang_logo.png" alt="MLBB Logo" class="w-20 h-20 rounded-2xl absolute -top-12 left-6 border-4 border-white bg-slate-900 shadow-md">
                        
                        <div class="mt-8">
                            <h1 class="text-2xl font-bold text-slate-900">Mobile Legends</h1>
                            <p class="text-sm text-slate-500 mt-1">Moonton</p>
                            
                            <div class="mt-4 space-y-3 text-sm text-slate-600">
                                <p>Top up Diamond Mobile Legends resmi, proses otomatis 1 detik, aman dan terpercaya.</p>
                                <ul class="space-y-2 mt-4 text-xs font-medium">
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Buka 24 Jam</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Pembayaran Instan via QRIS</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-2/3">
                <form id="topup-form" class="space-y-6">
                    @csrf

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">1</div>
                            <h2 class="text-lg font-bold text-slate-800">Masukkan ID Game</h2>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="number" id="user_id" placeholder="Masukkan User ID" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                            <div>
                                <input type="number" id="zone_id" placeholder="Zone ID" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-3 italic">Untuk mengetahui User ID Anda, silakan klik menu profile dibagian kiri atas pada menu utama game. Contoh: 12345678 (1234).</p>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">2</div>
                            <h2 class="text-lg font-bold text-slate-800">Pilih Nominal Top Up</h2>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($products as $product)
                            <label class="cursor-pointer relative group">
                                <input type="radio" name="product_id" value="{{ $product->id }}" data-price="{{ $product->price_sell }}" class="peer hidden" required>
                                <div class="border-2 border-slate-100 rounded-2xl p-4 h-full flex flex-col items-start bg-white peer-checked:border-blue-600 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                    <svg class="w-6 h-6 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 9l3 13h14l3-13-10-7zm0 2.5l7.5 5.5H4.5L12 4.5zM4.8 11h3.4l1.6 8H6.5l-1.7-8zm5.5 0h3.4v8h-3.4v-8zm5.5 0h3.4l1.7 8h-3.3l-1.8-8z"/></svg>
                                    
                                    <div class="font-bold text-slate-800 text-sm mb-1 leading-tight">{{ $product->name }}</div>
                                    <div class="text-xs font-semibold text-blue-600 mt-auto pt-2">Rp {{ number_format($product->price_sell, 0, ',', '.') }}</div>
                                </div>
                                <div class="absolute top-3 right-3 text-blue-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">3</div>
                            <h2 class="text-lg font-bold text-slate-800">Detail Kontak</h2>
                        </div>
                        
                        <div class="space-y-4 mb-8">
                            <div>
                                <input type="number" id="whatsapp" placeholder="Nomor WhatsApp (Cth: 08123...)" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                            <div>
                                <input type="email" id="email" placeholder="Alamat Email (Untuk Bukti Transaksi)" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <div class="flex justify-between items-center mb-3 text-sm text-slate-500">
                                <span>Harga Item</span>
                                <span id="display-price" class="font-medium text-slate-700">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center mb-4 text-sm text-slate-500">
                                <span>PPN (11%)</span>
                                <span id="display-ppn" class="font-medium text-slate-700">Rp 0</span>
                            </div>
                            <div class="border-t border-dashed border-slate-300 pt-4 flex justify-between items-center mb-6">
                                <span class="text-slate-800 font-bold">Total Pembayaran</span>
                                <span id="display-total" class="text-2xl font-black text-blue-600">Rp 0</span>
                            </div>

                            <button type="submit" id="pay-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Beli Sekarang
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>

    @include('layouts.footerComponent')

    <script>
        const PPN_RATE = 0.11;
        let selectedPrice = 0;

        // Listener saat produk diklik
        document.querySelectorAll('input[name="product_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                selectedPrice = parseFloat(this.getAttribute('data-price'));
                
                const ppn = selectedPrice * PPN_RATE;
                const total = selectedPrice + ppn;

                document.getElementById('display-price').innerText = 'Rp ' + Math.round(selectedPrice).toLocaleString('id-ID');
                document.getElementById('display-ppn').innerText = 'Rp ' + Math.round(ppn).toLocaleString('id-ID');
                document.getElementById('display-total').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
            });
        });

        // Submit Form
        document.getElementById('topup-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if(selectedPrice === 0) {
                alert('Silakan pilih nominal top up terlebih dahulu!');
                return;
            }

            const payButton = document.getElementById('pay-button');
            const originalText = payButton.innerHTML;

            const userId = document.getElementById('user_id').value;
            const zoneId = document.getElementById('zone_id').value;
            const targetUserId = `${userId}(${zoneId})`;
            
            const wa = document.getElementById('whatsapp').value;
            const email = document.getElementById('email').value;
            const productId = document.querySelector('input[name="product_id"]:checked').value;

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('product_id', productId);
            formData.append('target_user_id', targetUserId);
            formData.append('customer_phone', wa);
            formData.append('customer_email', email);

            // Ganti Button State
            payButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...`;
            payButton.disabled = true;

            try {
                const response = await fetch("{{ route('checkout.process') }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await response.json();

                if (result.success) {
                    window.snap.pay(result.snap_token, {
                        onSuccess: function(result){ 
                            alert("Pembayaran sukses! Item kamu sedang dikirim."); 
                            window.location.reload(); 
                        },
                        onPending: function(result){ 
                            alert("Menunggu pembayaran! Cek petunjuk di Midtrans."); 
                        },
                        onError: function(result){ 
                            alert("Pembayaran gagal!"); 
                        },
                        onClose: function(){
                            alert("Kamu menutup pop-up sebelum menyelesaikan pembayaran.");
                        }
                    });
                } else {
                    alert('Gagal: ' + result.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan sistem, silakan coba lagi.');
            } finally {
                payButton.innerHTML = originalText;
                payButton.disabled = false;
            }
        });
    </script>
</body>
</html>