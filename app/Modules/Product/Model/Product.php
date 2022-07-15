<?php

namespace App\Modules\Product\Model;

use App\Modules\Product\Model\Product as ModelProduct;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public const STATUS_ACTIVE = 1;

    public const STATUS_DISABLE = 0;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'inventory',
        'price'
    ];

    public static function statusIsValid(int $status):bool{

        if($status == ModelProduct::STATUS_ACTIVE || $status == ModelProduct::STATUS_DISABLE ){
           return true;
        }

        return false;

    }

    public function validateSale(){

        if($this->status == Product::STATUS_DISABLE){
            return false;
        }

        if($this->inventory < 1){
            return false;
        }

        return true;
    }


}
