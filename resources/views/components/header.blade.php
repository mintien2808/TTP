<header class="main_menu home_menu" style="" x-data="{
    mobileMenuOpen: false,
    cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
}"
@cart-change.window="cartItemsCount = $event.detail.count" style="background-color: antiquewhite;">

    <div class="container" >
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light" style="position: fixed; top: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.02); width:1200px; background-color:rgb(204, 223, 226); border-radius:5px; padding:0 20px;  ">
                    <a class="navbar-brand" href="{{route('home')}}"> <img src="{{asset('img/logo.png')}}" alt="logo" style="width:3em"> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_icon"><i class="fas fa-bars"></i></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('home')}}">Home</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_3"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    pages
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                    <a class="dropdown-item" href="tracking.html">tracking</a>
                                    <a class="dropdown-item" href="checkout.html">product checkout</a>
                                    <a class="dropdown-item" href="confirmation.html">confirmation</a>
                                    <a class="dropdown-item" href="elements.html">elements</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_2"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    blog
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                    <a class="dropdown-item" href="blog.html"> blog</a>
                                    <a class="dropdown-item" href="single-blog.html">Single blog</a>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="hearer_icon d-flex">
                        <a  href="{{ route('cart.index') }}" title="Cart">
                            <i class="fa fa-cart-plus" aria-hidden="true" style="font-size:25px;"></i>
                                <small
                                    x-show="cartItemsCount"
                                    x-transition
                                    x-text="cartItemsCount"
                                    x-cloak
                                    class="py-[2px] px-[8px] rounded-full bg-red-500"
                                ></small>
                        </a>
                            @if(Auth::user())

                            <a href="{{ route('profile') }}" title="Go to Profile">
                                <i class="fa fa-user fa-5x" aria-hidden="true" style="font-size:25px;"></i>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" title="Logout"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    <i class="fa fa-sign-out-alt fa-5x" aria-hidden="true" style="font-size:25px;"></i>
                                </a>
                            </form>
                            
                            <a href="{{ route('order.index') }}" title="View Order History">
                                <i class="fa fa-history fa-5x" aria-hidden="true" style="font-size: 25px;"></i>
                            </a>
                            
                            @else 
                                <a href="{{ route('login') }}" title="Login">
                                    <i class="fa fa-sign-in-alt fa-5x" aria-hidden="true" style="font-size:25px;"></i>
                                </a>
                            @endif
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>