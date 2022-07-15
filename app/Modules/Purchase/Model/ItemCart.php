<?php

namespace App\Modules\Purchase\Model;

use Illuminate\Database\Eloquent\Model;

class ItemCart extends Model
{

    protected $table = 'iten_in_cart';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'price',
        'quantity',
    ];

    public function getTotal(){
        return $this->price * $this->quantity;
    }

    public function toArray(){
        return ["Id" => $this->id];
    }

}
