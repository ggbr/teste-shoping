<?php

namespace App\Modules\Payment\Service;

use App\Modules\Error\Error;
use App\Modules\Payment\Model\Coupon;

class PaymentService 
{

    public static function createNewCoupon(string $name, int $value, int $status = 1){


        if(! Coupon::statusIsValid($status)){
            throw new Error("status invalid", 400);   
        }

        return Coupon::create([
            'name'      => $name,
            'value'     => $value,
            'status'    => $status,
        ]);
    }
}
