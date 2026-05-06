<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang Belanja - ShopMart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">ShopMart</h1>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:text-blue-600">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                    <a href="/cart">
                        <button id="cartBtn" class="relative p-2 text-gray-600 hover:text-blue-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </button>
                    </a>
                    <a href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @if (session('completionTime'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            Waktu eksekusi update: {{ number_format(session('completionTime'), 4) }} detik
        </div>
    @endif

    @if (session('completionTime'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            Waktu eksekusi hapus: {{ number_format(session('completionTime'), 4) }} detik
        </div>
    @endif
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-shopping-cart text-blue-600 mr-3"></i>Keranjang Belanja
            </h2>
        </div>

        @if ($baskets->isEmpty())
            <div class="text-center py-16 bg-white rounded-lg shadow-sm">
                <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-600 text-xl mb-4">Keranjang kamu kosong nih.</p>
                <a href="/"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-store mr-2"></i>Yuk Belanja Sekarang
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600">Produk</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600">Harga</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600">Jumlah</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600">Subtotal</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($baskets as $item)
                            @php
                                $subtotal = $item->quantity * $item->product->price;
                                $total += $subtotal;
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                            class="w-16 h-16 object-cover rounded-lg shadow-sm" />
                                        <div>
                                            <h3 class="font-medium text-gray-800">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500">SKU: {{ $item->product->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-800">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <form action="/cart/update/{{ $item->id }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1" max="99"
                                                class="w-16 px-2 py-1 border rounded-lg text-center" />
                                            <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-800">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <form action="/cart/remove/{{ $item->id }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Yakin mau hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 transition duration-300">
                                            <i class="fas fa-trash-alt mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="py-4 px-6 text-right font-semibold text-gray-600">Total</td>
                            <td colspan="2" class="py-4 px-6 font-bold text-lg text-gray-800">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-8 flex justify-end items-center"> <!-- Changed justify-between to justify-end -->
                <div class="space-x-4">
                    <a href="/" class="inline-block px-6 py-3 text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Lanjut Belanja
                    </a>
                    <a href="/checkout"
                        class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-credit-card mr-2"></i>
                        Checkout
                    </a>
                </div>
            </div>
        @endif
    </section>
</body>

</html>
