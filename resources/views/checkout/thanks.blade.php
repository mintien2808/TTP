<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-4">Cảm ơn bạn!</h1>

        <p class="text-lg mb-4">Đơn hàng của bạn đã được tiếp nhận thành công.</p>
        
        <div class="bg-gray-100 p-4 rounded-md">
            <h2 class="text-xl font-semibold">Thông tin đơn hàng</h2>
            <ul>
                <li><strong>Mã đơn hàng:</strong> #{{ $orderId }}</li>
                <li><strong>Ngày thanh toán:</strong> {{ now()->format('d/m/Y H:i') }}</li>
            </ul>
        </div>

        <div class="mt-6">
            <p>Cảm ơn bạn đã mua sắm tại chúng tôi. Chúng tôi sẽ gửi thông tin cập nhật về đơn hàng của bạn qua email.</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-purple-600 hover:underline">Quay lại trang chủ</a>
        </div>
    </div>
</x-app-layout>
