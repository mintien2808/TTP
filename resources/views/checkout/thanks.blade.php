<x-app-layout>
    @include('components.header')
    @include('components.breadcrumb')
    <div class="confirmation_part padding_top bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-semibold text-center text-green-600 mb-6">Cảm ơn bạn!</h1>
    
        <p class="text-lg text-center text-gray-700 mb-6">Đơn hàng của bạn đã được tiếp nhận thành công.</p>
        
        <div class="bg-gray-50 p-5 rounded-md shadow-sm">
            <h2 class="text-xl font-semibold text-gray-800">Thông tin đơn hàng</h2>
            <ul class="mt-3 text-gray-600">
                
                    <li><strong>Mã đơn hàng:</strong> #{{ $orderId }}</li>
                    <li><strong>Ngày thanh toán:</strong> {{ now()->format('d/m/Y H:i') }}</li>
               
            </ul>
        </div>
    
        <div class="mt-8 text-center">
            <p class="text-lg text-gray-700">Cảm ơn bạn đã mua sắm tại chúng tôi. Chúng tôi sẽ gửi thông tin cập nhật về đơn hàng của bạn qua email.</p>
        </div>
    
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-purple-600 hover:underline text-lg font-semibold">Quay lại trang chủ</a>
        </div>
    </div>
    
    @include('components.footer')
    @include('components.js')
</x-app-layout>
