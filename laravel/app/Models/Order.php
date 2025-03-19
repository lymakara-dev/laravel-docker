<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['order_date', 'total_price', 'customer_id'];

    protected function orderDate(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s'),
            get: fn($value) => Carbon::parse($value)->format('d/m/Y H:i:s')
        );
    }

    public function order()
    {
        return $this->hasMany(Payment::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
