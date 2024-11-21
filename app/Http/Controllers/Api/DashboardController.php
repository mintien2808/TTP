<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ReportTrait;

    public function activeCustomers(){
        return Customer::where('status', CustomerStatus::Active->value)->count();
    }

    public function activeProducts(){
        return Product::where('published', '=', 1)->count();
    }

    public function activeCategories(){
        return Category::where('active', '=',1)->count();
    }
}
