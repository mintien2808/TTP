<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address1',
        'city',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
