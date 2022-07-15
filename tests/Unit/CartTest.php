<?php

namespace Tests\Unit;

use App\Modules\Product\Service\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Purchase\Service\CartService;

class CartTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_new_cart()
    {
        $cart = CartService::createNewCart(null, 1);

        if($cart->status == 1){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }

    }

    public function test_add_product_cart()
    {
        $cart = CartService::createNewCart(null, 1);

        $product = ProductService::createNewProduct("Produto 1",1000, 1);

        $cartItem = CartService::addItemInCart($cart->id,$product->id,3);

        $cartArray = $cartItem->toArray();

        if($cartArray['invoice_value'] == 3000){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }
    }


    public function test_add_2_product_cart()
    {
        $cart = CartService::createNewCart(null, 1);

        $product = ProductService::createNewProduct("Produto 1",1000, 1);

        CartService::addItemInCart($cart->id,$product->id,3);
        
        $cartItem2 = CartService::addItemInCart($cart->id,$product->id,3);

        $cartArray = $cartItem2->toArray();

        if($cartArray['invoice_value'] == 6000){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }

    }


    public function test_add_2_product_different_cart()
    {
        $cart = CartService::createNewCart(null, 1);

        $product = ProductService::createNewProduct("Produto 1",1000, 1);
        $product2 = ProductService::createNewProduct("Produto 2",2000, 1);

        CartService::addItemInCart($cart->id,$product->id,3);

        $cartItem2 = CartService::addItemInCart($cart->id,$product2->id,3);

        $cartArray = $cartItem2->toArray();

        if($cartArray['invoice_value'] == 9000){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }

    }

    public function test_clear_cart()
    {
        $cart = CartService::createNewCart(null, 1);

        $product = ProductService::createNewProduct("Produto 1",1000, 1);

        CartService::addItemInCart($cart->id,$product->id,3);

        CartService::clearAllItensInCart($cart->id);

        $cartItem = CartService::getCart($cart->id);

        $cartArray = $cartItem->toArray();


        if($cartArray['invoice_value'] == 0){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }

    }

    
}
