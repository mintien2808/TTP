<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <!-- Hiển thị sản phẩm trong giỏ hàng -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Your Items</h2>
            <ul>
                @foreach ($products as $product)
                    <li class="mb-2">
                        <strong>{{ $product->title }}</strong> - 
                        Price: ${{ number_format($product->price, 2) }} x 
                        Quantity: {{ $cartItems[$product->id]['quantity'] }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="text-right mb-6">
            <h3 class="text-xl font-bold">Total: ${{ number_format($total, 2) }}</h3>
        </div>

        <div class="mt-8">
            <h1 class="text-2xl font-bold mb-6">Thông Tin Thanh Toán</h1>
            
            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Họ</label>
                        <input 
                            type="text" 
                            name="first_name" 
                            id="first_name" 
                            value="{{ old('first_name', $customer->first_name ?? $user->first_name) }}" 
                            required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Tên</label>
                        <input 
                            type="text" 
                            name="last_name" 
                            id="last_name" 
                            value="{{ old('last_name', $customer->last_name ?? $user->last_name) }}" 
                            required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone', $customer->phone ?? $user->phone) }}" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="address1" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <input 
                        type="text" 
                        name="address1" 
                        id="address1" 
                        value="{{ old('address1', $billingAddress->address1 ?? '') }}" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                    @error('address1')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Thành phố</label>
                    <input 
                        type="text" 
                        name="city" 
                        id="city" 
                        value="{{ old('city', $billingAddress->city ?? '') }}" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                    @error('city')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="total" value="{{ $total }}">

                <div class="flex justify-end mt-4">
                    <button 
                        type="submit" 
                        name="payUrl"
                        class="bg-purple-600 text-black py-2 px-6 rounded-lg hover:bg-purple-700 focus:ring-purple-600">
                        Xác nhận và thanh toán
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
