<x-app-layout>
    @include('components.breadcrumb')
    <br>
    <div class="sample-text px-4 py-6 flex flex-col items-center justify-center">
        <h1 class="text-3xl font-bold mb-4 text-red-600 text-center">!!! Something Wrong !!!</h1>

        <p class="text-lg mb-4 text-center">It seems like you have canceled the order. If you have any inconvenience or questions, please feel free to contact us at</p>

        <p class="text-lg mb-4 text-center">Our email: <a href="mailto:mintien280803@gmail.com">TTPShop@gmail.com</a></p>

        <p class="text-lg mb-4 text-center">Hotline: 19001060</p>

        <div class="mt-6 text-center">
            <p>Thank you for visiting our store.</p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="genric-btn danger radius">Back to homepage</a>
        </div>
    </div>    
    @include('components.footer')
</x-app-layout>
