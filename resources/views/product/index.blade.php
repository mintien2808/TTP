<?php
    $categoryList = \App\Models\Category::getActiveAsTree();
    
?>

<x-app-layout>

    @include('components.header')
    <!-- Header part end-->
    @include('components.banner')
    <!-- feature_part start-->

    <section class="feature_part padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section_tittle text-center">
                        <h2>Featured Category</h2>
                    </div>
                </div>
            </div>
                <x-category-list :category-list="$categoryList"/>
        </div>
    </section>

    <?php if ( $products->count() === 0 ): ?>
    <div class="text-center text-gray-600 py-16 text-xl">
        There are no products published
    </div>
    <?php else: ?>
    
    <section class="product_list section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h2>awesome <span>shop</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product_list_slider owl-carousel">
                        <div class="single_product_list_slider">
                            <div class="row align-items-center justify-content-between">
                                @foreach($products as $product)
                                <div class="col-lg-3 col-sm-6" x-data="productItem({{ json_encode([
                                        'id' => $product->id,
                                        'slug' => $product->slug,
                                        'image' => $product->image ?: '/img/noimage.png',
                                        'title' => $product->title,
                                        'price' => $product->price,
                                        'addToCartUrl' => route('cart.add', $product)
                                     ]) }})">
                                    <div class="single_product_item">
                                            <a href="{{route('product.view', $product->slug)}}">
                                                <img src="{{$product->image}}" alt="noimg" style="height:300px;object-cover:fit;">
                                            </a>
                                        <div class="single_product_text">
                                            <h4 style="font-size:23px;">{{$product->title}}</h4>
                                            <h3 style="font-size:20px;">
                                                <script>
                                                    document.write(new Intl.NumberFormat('vi-VN', {
                                                        style: 'currency',
                                                        currency: 'VND'
                                                    }).format({{ $product->price }}));
                                                </script>
                                            </h3>
                                            <button class="btn-mt3" @click="addToCart()" style="color:red   ">
                                                ADD TO CART
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{$products->appends(['sort' => request('sort'), 'search' => request('search')])->links()}}
                @endif
            </div>
        </div>
    </section>
    
    <!-- product_list part start-->

    <!-- subscribe_area part start-->
    <section class="subscribe_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="subscribe_area_text text-center">
                        <h5>Join Our Newsletter</h5>
                        <h2>Subscribe to get Updated
                            with new offers</h2>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="enter email address"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <a href="#" class="input-group-text btn_2" id="basic-addon2">subscribe now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::subscribe_area part end::-->

    <!-- subscribe_area part start-->
    <section class="client_logo padding_top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_1.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_2.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_3.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_4.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_5.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_3.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_1.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_2.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_3.png" alt="">
                    </div>
                    <div class="single_client_logo">
                        <img src="img/client_logo/client_logo_4.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::subscribe_area part end::-->

    <!--::footer_part start::-->
    @include('components.footer')
    <!--::footer_part end::-->

    @include('components.js')
</x-app-layout>