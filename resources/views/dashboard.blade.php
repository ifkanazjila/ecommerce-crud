<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMart - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    @if (isset($completionTime))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
            Waktu load produk: {{ number_format($completionTime, 4) }} detik
        </div>
    @endif
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">ShopMart</h1>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="/login">Login</a>
                        <a href="/register">Register</a>
                    @endguest
                    @auth
                        <button class="relative p-2 text-gray-600 hover:text-blue-600">
                            <i class="fas fa-heart text-xl"></i>
                        </button>
                        <a href="/cart">
                            <button id="cartBtn" class="relative p-2 text-gray-600 hover:text-blue-600">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </button>
                        </a>
                        <a href="/logout">Logout</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl md:text-6xl font-bold mb-4">Belanja Mudah & Hemat</h2>
                <p class="text-xl mb-8">Temukan produk terbaik dengan harga terjangkau</p>

            </div>
        </div>
    </section>

    <div id="completionTimeMsg"
        class="fixed top-5 right-5 z-50 hidden bg-green-100 text-green-800 px-4 py-2 rounded shadow"></div>
    <!-- Products -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h3 class="text-3xl font-bold">Produk Terlaris</h3>
            </div>
            <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="font-bold text-lg mb-2 line-clamp-2">{{ $product['name'] }}</h4>
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= floor($product['rating']) ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-gray-600 text-sm ml-2">{{ $product['rating'] }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                </span>
                            </div>
                            @auth
                                <button onclick="addToCart({{ $product['id'] }})"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                    <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                                </button>
                            @else
                                <a href="/login"
                                    class="w-full block text-center bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 transition duration-300">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login untuk beli
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="/">
                        <h4 class="text-xl font-bold mb-4">ShopMart</h4>
                    </a>
                    <p class="text-gray-300">Platform e-commerce terpercaya untuk semua kebutuhan Anda.</p>
                </div>
                <div>
                    <h5 class="font-bold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-white">Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-4">Ikuti Kami</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white"><i
                                class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i
                                class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i
                                class="fab fa-instagram text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 ShopMart. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    <script>
        function addToCart(productId) {
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // penting buat proteksi CSRF
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const msg = document.getElementById('completionTimeMsg');
                        msg.innerText = 'Waktu eksekusi: ' + data.completion_time.toFixed(4) + ' detik';
                        msg.classList.remove('hidden');
                        setTimeout(() => msg.classList.add('hidden'), 3000);
                    } else {
                        alert('Gagal menambahkan ke keranjang!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
        }
    </script>

</body>

</html>
