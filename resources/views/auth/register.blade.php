
    @if (session('error'))
            <div class="py-2 px-3 bg-red-500 text-white mb-2 rounded">
                {{ session('error') }}
            </div>
    @endif

        <x-auth-session-status class="mb-4" :status="session('status')"/>


<x-app-layout>
    @include('components.header')
    <!--================login_part Area =================-->
    <section class="login_part padding_top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 order-md-2">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Already a member?</h2> 
                            <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                            <a href="{{ route('login') }}" class="btn_3">Login</a> 
                        </div>
                    </div>
                </div>
                
    
                <!-- Đổi vị trí form đăng nhập sang phải -->
                <div class="col-lg-6 col-md-6 order-md-1">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Welcome To Our Shop <br>
                                 Register With Us</h3>
                            <form class="row contact_form" action="{{ route('register') }}" method="POST" >
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                @csrf
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="name" name="name" :value="old('name')" placeholder="Username">
                                        @error('name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" :value="old('email')" placeholder="Email">
                                        @error('email')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" :value="old('password')" placeholder="Password">
                                        @error('password')
                                            <span class="text-red-500 text-sm ">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  placeholder="Repeat Password">
                                        @error('password_confirmation')
                                            <span class="text-red-500 text-sm ">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" class="btn_3">Register</button>
                                    @if (Route::has('password.request'))
                                        <a class="lost_pass" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    @include('components.footer')
    @include('components.js')
    <!--================login_part end =================-->

</x-app-layout>