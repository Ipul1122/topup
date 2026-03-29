<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $product->name }}</title>
    @vite('resources/css/app.css')
    
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan</h1>
        
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <h2 class="font-semibold text-blue-800">{{ $product->name }}</h2>
            <p class="text-blue-600 font-bold text-lg mt-1">Rp {{ number_format($product->price_sell, 0, ',', '.') }}</p>
        </div>

        <form id="checkout-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">ID Game (User ID + Zone ID)</label>
                <input type="text" name="target_user_id" placeholder="Contoh: 113332888(2576)" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Pastikan ID benar. Kesalahan ID bukan tanggung jawab kami.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pembeli</label>
                <input type="text" name="customer_name" placeholder="Nama Kamu" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp</label>
                <input type="number" name="customer_phone" placeholder="08123456789" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" id="pay-button"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                Bayar Sekarang
            </button>
        </form>
    </div>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const payButton = document.getElementById('pay-button');
            const formData = new FormData(form);

            // Ubah tombol jadi loading
            payButton.innerHTML = 'Memproses...';
            payButton.disabled = true;

            try {
                // Tembak data ke Controller Checkout
                const response = await fetch("{{ route('checkout.process') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Jika sukses dapet token, munculkan Pop-up Midtrans
                    window.snap.pay(result.snap_token, {
                        onSuccess: function(result){
                            alert("Pembayaran sukses! Sistem sedang memproses top-up kamu.");
                            window.location.href = '/'; // Redirect ke home
                        },
                        onPending: function(result){
                            alert("Menunggu pembayaran kamu!");
                        },
                        onError: function(result){
                            alert("Pembayaran gagal!");
                        },
                        onClose: function(){
                            alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
                        }
                    });
                } else {
                    alert('Gagal: ' + result.message);
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan sistem.');
            } finally {
                // Kembalikan tombol seperti semula
                payButton.innerHTML = 'Bayar Sekarang';
                payButton.disabled = false;
            }
        });
    </script>
</body>
</html>