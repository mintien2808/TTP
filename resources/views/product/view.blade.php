<x-app-layout>
    <div  x-data="productItem({{ json_encode([
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'image' => $product->image ?: '/img/noimage.png',
                    'title' => $product->title,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'addToCartUrl' => route('cart.add', $product)
                ]) }})" class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div
                    x-data="{
                      images: {{$product->images->count() ?
                 $product->images->map(fn($im) => $im->url) : json_encode(['/img/noimage.png'])}},
                      activeImage: null,
                      prev() {
                          let index = this.images.indexOf(this.activeImage);
                          if (index === 0)
                              index = this.images.length;
                          this.activeImage = this.images[index - 1];
                      },
                      next() {
                          let index = this.images.indexOf(this.activeImage);
                          if (index === this.images.length - 1)
                              index = -1;
                          this.activeImage = this.images[index + 1];
                      },
                      init() {
                          this.activeImage = this.images.length > 0 ? this.images[0] : null
                      }
                    }"
                >
                    <div class="relative">
                        <template x-for="image in images">
                            <div
                                x-show="activeImage === image"
                                class="w-full h-[240px] sm:h-[400px] flex items-center justify-center"
                            >
                                <img :src="image" alt="" class="w-auto h-auto max-h-full mx-auto"/>
                            </div>
                        </template>
                        <a
                            @click.prevent="prev"
                            class="cursor-pointer bg-black/30 text-white absolute left-0 top-1/2 -translate-y-1/2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </a>
                        <a
                            @click.prevent="next"
                            class="cursor-pointer bg-black/30 text-white absolute right-0 top-1/2 -translate-y-1/2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </div>
                    <div class="flex">
                        <template x-for="image in images">
                            <a
                                @click.prevent="activeImage = image"
                                class="cursor-pointer w-[80px] h-[80px] border border-gray-300 hover:border-purple-500 flex items-center justify-center"
                                :class="{'border-purple-600': activeImage === image}"
                            >
                                <img :src="image" alt="" class="w-auto max-auto max-h-full"/>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <h1 class="text-lg font-semibold">
                    {{$product->title}}
                </h1>
                <div class="text-xl font-bold mb-6">${{$product->price}}</div>
                @if ($product->quantity === 0)
                    <div class="bg-red-400 text-white py-2 px-3 rounded mb-3">
                        The product is out of stock
                    </div>
                @endif
                <div class="flex items-center justify-between mb-5">
                    <label for="quantity" class="block font-bold mr-4">
                        Quantity
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        x-ref="quantityEl"
                        value="1"
                        min="1"
                        class="w-32 focus:border-purple-500 focus:outline-none rounded"
                    />
                </div>
                <button
                    :disabled="product.quantity === 0"
                    @click="addToCart($refs.quantityEl.value)"
                    class="btn-primary py-4 text-lg flex justify-center min-w-0 w-full mb-6"
                    :class="product.quantity === 0 ? 'cursor-not-allowed' : 'cursor-pointer'"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    Add to Cart
                </button>
                <div class="mb-6" x-data="{expanded: false}">
                    <div
                        x-show="expanded"
                        x-collapse.min.120px
                        class="text-gray-500 wysiwyg-content"
                    >
                        {!! $product->description !!}
                    </div>
                    <p class="text-right">
                        <a
                            @click="expanded = !expanded"
                            href="javascript:void(0)"
                            class="text-purple-500 hover:text-purple-700"
                            x-text="expanded ? 'Read Less' : 'Read More'"
                        ></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>        
    <div class="p-6 bg-gray-200 border-b border-gray-200">
        <h1 class="text-xl font-semibold">Bình Luận</h1>
        <hr class="my-4">
        
        <div x-data="{ open: false }">

            <button @click =" 
                @if (auth()->check())
                    open = !open    
                @else
                window.location.href = '{{ route('login') }}';
                @endif
            " class="btn-primary py-2 px-4 rounded text-white">
                Đánh giá sản phẩm   
            </button>
            
            <div x-show="open" x-transition class="mt-4 bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">  
            
                    <input 
                    type="hidden" 
                    name="user_id" 
                    value="@if(auth()->check()) {{ auth()->user()->id }} @endif"
                    >

                    <div class="mb-3">
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Đánh giá:</label>
                        <select name="rating" id="rating" class="block w-full rounded border-gray-300 focus:ring-purple-500 focus:border-purple-500 text-sm">
                            <option value="" disabled selected>Chọn số sao</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} sao</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Bình luận:</label>
                        <textarea name="comment" id="comment" rows="3" class="block w-full rounded border-gray-300 focus:ring-purple-500 focus:border-purple-500 text-sm resize-none"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class=" bg-purple-500 text-black py-2 px-4 rounded hover:bg-purple-600 text-sm">
                            Gửi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        
        <br>
        @if ($reviews->isEmpty())
            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
        @else
            @foreach ($reviews as $review)
                <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-bold text-gray-800">{{ $review->user->name }}</p>
                        <p class="text-gray-600 text-sm">Rating: {{ $review->rating }}</p>
                        
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        @if (Auth::check() && Auth::user()->id == $review->user_id)
                            <!-- Nút sửa -->
                            <a href="{{ route('reviews.edit', $review->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                <span class="font-semibold">Sửa</span>
                            </a>
                        @endif
                        
                        @if (Auth::check() && Auth::user()->id == $review->user_id)
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                    <span class="font-semibold">Xoá</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>    
    </div>
        
</x-app-layout>


<script>
    function LoginRequest() {
        if (typeof toastr !== 'undefined') {
            toastr.error('You must be logged in to add a review.');
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        } else {
            console.error('Toastr is not loaded.');
        }
    }
</script>
