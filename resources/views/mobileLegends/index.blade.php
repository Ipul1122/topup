<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Mobile Legends - skyfoxmarket</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="text/javascript" src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

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
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <input type="number" id="user_id" placeholder="Masukkan User ID" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                            <div>
                                <input type="number" id="zone_id" placeholder="Zone ID" required 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                            </div>
                            <div>
                                <button type="button" id="btn-check-username" 
                                    class="w-full px-4 py-3 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
                                    Cek Akun
                                </button>
                            </div>
                        </div>
                        <div id="username-check-result" class="hidden mt-3 p-3 rounded-xl text-xs font-medium border"></div>
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

    <!-- Modal Konfirmasi Pembelian -->
    <div id="checkout-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002-2M9 5a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Konfirmasi Pembelian
                </h3>
                <button type="button" onclick="closeCheckoutModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-100 space-y-3">
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Game</span>
                        <span class="font-semibold text-slate-700">Mobile Legends</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>ID Game (Zone)</span>
                        <span id="modal-game-id" class="font-semibold text-slate-700">-</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Nickname / Username</span>
                        <span id="modal-nickname" class="font-bold text-blue-600 text-sm">-</span>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-500">
                        <span>Item</span>
                        <span id="modal-item-name" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Harga</span>
                        <span id="modal-item-price" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>PPN (11%)</span>
                        <span id="modal-item-ppn" class="font-semibold text-slate-800">-</span>
                    </div>
                    <hr class="border-dashed border-slate-200">
                    <div class="flex justify-between items-center pt-2">
                        <span class="font-bold text-slate-800">Total Pembayaran</span>
                        <span id="modal-total-pay" class="text-xl font-black text-blue-600">-</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-5 bg-slate-50 border-t border-slate-100 flex gap-3">
                <button type="button" onclick="closeCheckoutModal()" class="w-1/2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-600 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </button>
                <button type="button" id="btn-modal-confirm" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition text-sm shadow-md shadow-blue-600/20">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <script>
        const PPN_RATE = 0.11;
        let selectedPrice = 0;

        // Cek Akun/Username
        document.getElementById('btn-check-username').addEventListener('click', async function() {
            const userId = document.getElementById('user_id').value;
            const zoneId = document.getElementById('zone_id').value;
            const resultDiv = document.getElementById('username-check-result');

            if (!userId || !zoneId) {
                alert('Silakan isi User ID dan Zone ID terlebih dahulu!');
                return;
            }

            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

            resultDiv.classList.add('hidden');

            try {
                const response = await fetch('/api/digiflazz/cek-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        game_code: 'mobilelegend',
                        user_id: `${userId}(${zoneId})`
                    })
                });

                const res = await response.json();

                resultDiv.classList.remove('hidden', 'bg-green-50', 'border-green-200', 'text-green-800', 'bg-red-50', 'border-red-200', 'text-red-800');

                if (response.ok && res.status === 1) {
                    resultDiv.classList.add('bg-green-50', 'border-green-200', 'text-green-800');
                    resultDiv.innerHTML = `<span class="font-bold">Info Akun:</span> ${res.data}`;
                } else {
                    resultDiv.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
                    resultDiv.innerHTML = `<span class="font-bold">Gagal:</span> ${res.message || 'Gagal mengecek username'}`;
                }
            } catch (error) {
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
                resultDiv.innerHTML = `<span class="font-bold">Error:</span> Gagal terhubung ke server untuk mengecek username.`;
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

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

        // Fungsi untuk menutup modal
        window.closeCheckoutModal = function() {
            const modal = document.getElementById('checkout-modal');
            modal.classList.add('hidden');
        };

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
            const productRadio = document.querySelector('input[name="product_id"]:checked');
            const productId = productRadio.value;
            const productName = productRadio.closest('label').querySelector('.font-bold').innerText;

            // Ganti Button State ke "Memverifikasi..."
            payButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memverifikasi Akun...`;
            payButton.disabled = true;

            let nickname = "Tidak Diketahui";
            let verificationFailed = false;

            // 1. Jalankan inquiry username otomatis
            try {
                const response = await fetch('/api/digiflazz/cek-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        game_code: 'mobilelegend',
                        user_id: targetUserId
                    })
                });

                const res = await response.json();
                if (response.ok && res.status === 1) {
                    nickname = res.data;
                } else {
                    verificationFailed = true;
                    nickname = `Gagal memverifikasi (${res.message || 'Error API'})`;
                }
            } catch (error) {
                verificationFailed = true;
                nickname = "Gagal terhubung ke server verifikasi";
            }

            // Hitung harga rincian
            const ppn = selectedPrice * PPN_RATE;
            const total = selectedPrice + ppn;

            // 2. Isi data ke modal
            document.getElementById('modal-game-id').innerText = `${userId} (${zoneId})`;
            
            const nicknameSpan = document.getElementById('modal-nickname');
            nicknameSpan.innerText = nickname;
            if (verificationFailed) {
                nicknameSpan.className = "font-bold text-red-600 text-sm italic";
            } else {
                nicknameSpan.className = "font-bold text-green-600 text-sm";
            }

            document.getElementById('modal-item-name').innerText = productName;
            document.getElementById('modal-item-price').innerText = 'Rp ' + Math.round(selectedPrice).toLocaleString('id-ID');
            document.getElementById('modal-item-ppn').innerText = 'Rp ' + Math.round(ppn).toLocaleString('id-ID');
            document.getElementById('modal-total-pay').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');

            // Reset tombol beli sekarang ke semula
            payButton.innerHTML = originalText;
            payButton.disabled = false;

            // 3. Tampilkan Modal
            const modal = document.getElementById('checkout-modal');
            modal.classList.remove('hidden');

            // 4. Setup Tombol Konfirmasi di Modal
            const btnModalConfirm = document.getElementById('btn-modal-confirm');
            btnModalConfirm.onclick = async function() {
                // Tutup modal
                closeCheckoutModal();

                // Ganti Button State ke "Memproses Pembayaran..."
                payButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menghubungkan ke Midtrans...`;
                payButton.disabled = true;

                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('product_id', productId);
                formData.append('target_user_id', targetUserId);
                formData.append('customer_phone', wa);
                formData.append('customer_email', email);

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
            };
        });
    </script>
</body>
</html>