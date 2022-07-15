<?php

namespace App\Modules\Purchase\Service;

use App\Modules\Error\Error;
use App\Modules\Payment\Model\Coupon;
use App\Modules\Product\Model\Product;
use App\Modules\Purchase\Model\Cart;
use App\Modules\Purchase\Model\ItemCart;
use App\Modules\Purchase\Model\PaymentCart;

class CartService 
{

    public static function  createNewCart(string $email = null, int $status = 1){

        self::validate(status: $status, email: $email);

        return Cart::create([
            'email' => $email,
            'status'=> $status
        ]);
    }

    public static function addItemInCart(int $cartId, int $productId, int $quantity){

        $cart = CartService::findCart($cartId);

        $product = CartService::findProduct($productId);

        if($product->validateSale()){
            throw new Error("product invalid", 400);   
        }

        $item = ItemCart::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        if(is_null($item)){
            ItemCart::create([
                'cart_id'       => $cart->id,
                'product_id'    => $product->id,
                'price'         => $product->price,
                'quantity'      => $quantity,
            ]);
        }else{
            $item->quantity = $item->quantity + $quantity;
            $item->save();
        }

        return $cart;

    }

    public static function removeItenInCart(int $cartId, int $productId,){
        $cart = CartService::findCart($cartId);

        $product = CartService::findProduct($productId);

        $item = ItemCart::where('cart_id', $cart->id)->where('product_id', $product->id)->frist();

        if(is_null($item)){
            throw new Error("item not found", 400);
        }else{
            $item->delete();
        }

    }

    public static function getCart(int $cartId){
        $cart = CartService::findCart($cartId);

        $cart->getItens();

        $cart->getProducts();

        return $cart;
    }

    public static function clearAllItensInCart(int $cartId){
        $cart = CartService::findCart($cartId);

        $cart->clearCart();

    }


    public static function validate(string $email = null, int $status) : void {

        if(! Cart::statusIsValid($status)){
            throw new Error("status invalid", 400);
        }

        if(! is_null($email)){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Error("email invalid", 400);
            }
        }
        
    }

    public static function findCart(int $cartId) {
        $cart = Cart::find($cartId);

        if(is_null($cart)){
            throw new Error("cart not found", 400);
        }

        return $cart;
    }

    public static function findPayment(int $paymenId) {
        $coupon = Coupon::find($paymenId);

        if(is_null($coupon)){
            throw new Error("coupon not found", 400);
        }

        return $coupon;
    }

    public static function findProduct(int $productId) {
        $product = Product::find($productId);

        if(is_null($product)){
            throw new Error("product not found", 400);
        }

        return $product;
    }

    public static function addPayment(int $cartId, int $paymenId){

        $cart = CartService::findCart($cartId);

        $paymen = CartService::findPayment($paymenId);

        $paymentCart = PaymentCart::where('cart_id', $cart->id)->where('payment_id', $paymen->id)->first();

        if(is_null($paymentCart)){
            PaymentCart::create([
                'cart_id'       => $cart->id,
                'payment_id'    => $paymen->id,
                'price'         => $paymen->value,
            ]);
        }else{
            throw new Error("discount coupon already used", 400);
        }
      
        return $cart;
    } 

}
