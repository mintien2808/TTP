<x-app-layout>
  
    @include('components.header')
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Producta Checkout</h2>
              <p>Home <span>-</span> Shop Single</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <section class="checkout_area padding_top">
    <div class="container">
      <div class="billing_details">
        <div class="row">
          <div class="col-lg-8">
            <h3>Billing Details</h3>
            <form class="row contact_form" action="{{ route('checkout.process') }}" method="post" >
                @csrf
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="first" name="first_name" value="{{ old('first_name', $customer->first_name ?? $user->first_name) }}" placeholder="First name"/>
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="last" name="last_name" value="{{ old('last_name', $customer->last_name ?? $user->last_name) }}" placeholder="Last name"/>
                @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? $user->phone) }}" placeholder="Phone number"/>
                @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="email" name="compemailany" value="{{ old('email', $customer->email ?? $user->email) }}" placeholder="Email" />
                @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror


              </div>
              <div class="col-md-12 form-group p_star">
                <select class="country_select" id="country_select" onchange="updateStates()" name='country_code'>
                    @foreach ($countries as $country)
                        <option value="{{ $country->code }}" {{ $billingAddress->country_code == $country->code ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-12 form-group p_star">
                <select class="country_select" id="state_select" name='states'> 
                    @foreach ($currentStates as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-12 form-group p_star">
                <input type="text" class="form-control" id="add1" name="address1" value="{{ old('address1', $billingAddress->address1 ?? '') }}" placeholder="Address line 01"/>
              </div>
          
          </div>
          <div class="col-lg-4">
            <div class="order_box">
              <h2>Your Order</h2>
              <ul class="list">
                <li>
                  <a href="#">Product
                    <span>Total</span>
                  </a>
                </li>
                @foreach ($products as $product)
                <li>
                  <a href="#">{{ $product->title }}
                    <span class="middle">x {{ $cartItems[$product->id]['quantity'] }}</span>
                    <span class="last">{{ number_format($product->price, 0) }}đ </span>
                  </a>
                </li>
                @endforeach
              </ul>
              <ul class="list list_2">
                <li>
                  <a href="#">Subtotal
                    <span>{{ number_format($total, 0) }}</span>
                  </a>
                </li>
                <li>
                  <a href="#">Total
                    <span>{{ number_format($total, 0) }}</span>
                  </a>
                </li>
              </ul>
              <div class="payment_item active">
                <div class="radion_btn">
                  <input type="radio" id="f-option6" name="selector" />
                  <label for="f-option6">MoMo </label>
                  <img src="img/product/single-product/card.jpg" alt="" />
                  <div class="check"></div>
                </div>
                <p>
                  Please send a check to Store Name, Store Street, Store Town,
                  Store State / County, Store Postcode.
                </p>
              </div>
              <div class="creat_account">
                <input type="checkbox" id="f-option4" name="selector" />
                <label for="f-option4">I’ve read and accept the </label>
                <a href="#">terms & conditions*</a>
              </div>
              <input type="hidden" name="total" value="{{ $total }}">
              <button type="submit" class="btn_3" name='payUrl'>Proceed to Paypal</a>
                @if ($errors->any())
                    <div class="text-red-500 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================End Checkout Area =================-->

  <!--::footer_part start::-->
  @include('components.footer')
  <!--::footer_part end::-->
  <script>
    const countries = @json($countries);

    function updateStates() {
        const countrySelect = document.getElementById('country_select');
        const stateSelect = document.getElementById('state_select');
        const selectedCountryCode = countrySelect.value;

        // Tìm quốc gia được chọn
        const selectedCountry = countries.find(country => country.code === selectedCountryCode);

        // Xóa danh sách hiện tại
        stateSelect.innerHTML = '';

        // Thêm states mới nếu có
        if (selectedCountry && selectedCountry.states) {
            selectedCountry.states.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            });
        }
    }

</script>


  <!-- jquery plugins here-->
  <!-- jquery -->
  <!-- popper js -->
  
</x-app-layout>