<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionCustomerOfferPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    // Relationship => 1:M => "CustomerOfferPrice" And "TransactionCustomerOfferPrice"
    // "one transaction" has "many products"
    public function customer_offer_price()
    {
        return $this->hasMany(CustomerOfferPrice::class,'transaction_customer_offer_id','id');
    }
    // public function transaction_customer_offer_price()
    // {
    //     return $this->hasMany(CustomerOfferPrice::class,'transaction_customer_offer_id','id');
    // }
    // Relationship => 1:M => "Customer" And "TransactionCustomerOfferPrice"
    // "one transaction" belongs to "one customer"
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    // Relationship => 1:M => "Store" And "TransactionCustomerOfferPrice"
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault(['name' => '']);
    }
    // Relationship => 1:M => "User" And "TransactionCustomerOfferPrice"
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault(['name' => '']);
    }
}
