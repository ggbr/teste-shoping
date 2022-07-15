<?php

namespace App\Modules\Product\Service;

use App\Modules\Error\Error;
use App\Modules\Product\Model\Product;

class ProductService 
{

    public static function createNewProduct(string $name, int $price, int $status = 0, int $inventory = 0  )
    {
        self::validate(status: $status, inventory: $inventory);
       
        return Product::create([
            'name'      => $name,
            'status'    => $status,
            'inventory' => $inventory,
            'price'     => $price
        ]);
    }


    public static function validate(int $status, int $inventory) : void {
        if(! Product::statusIsValid($status)){
            throw new Error("status invalid", 400);
        }

        if($inventory < 0){
            throw new Error("inventory invalid", 400);
        }
    }


}
