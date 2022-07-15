<?php

namespace App\Modules\Payment\Model;


use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    public const STATUS_ACTIVE = 1;

    public const STATUS_DISABLE = 0;

    protected $table = 'payment_coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
        'status',
    ];

    public static function statusIsValid(int $status):bool{

        if($status == Coupon::STATUS_ACTIVE || $status == Coupon::STATUS_DISABLE ){
           return true;
        }

        return false;

    }


}
