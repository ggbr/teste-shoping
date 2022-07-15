<?php

namespace App\Modules\Purchase\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentCart extends Model
{

    protected $table = 'payment_in_cart';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
        'payment_id',
        'price',
    ];

    public function toArray()
    {
        return [ 
            'id' => $this->payment_id,
            'price' => $this->price,
        ];
    }

}
