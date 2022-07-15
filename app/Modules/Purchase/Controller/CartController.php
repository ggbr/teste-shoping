<?php

namespace App\Modules\Purchase\Controller;

use Illuminate\Http\Request;
use App\Modules\Error\Error;
use App\Http\Controllers\Controller;
use App\Modules\Purchase\Service\CartService;

class CartController extends Controller
{

    public function createNewCart(Request $request){

        $email     = $request->input('email');
        $status    = $request->input('status', 1);

        try{
            return CartService::createNewCart($email, $status);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }

    public function addItemInCart(Request $request){

        $this->validate($request, [
            'cart_id'       => 'required',
            'product_id'    => 'required',
            'quantity'      => 'required',
        ]);

        $cartId      = $request->input('cart_id');
        $productId   = $request->input('product_id');
        $quantity    = $request->input('quantity');

        try{
            return CartService::addItemInCart($cartId, $productId,$quantity);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }

    public function removeItenInCart(Request $request){
        $this->validate($request, [
            'cart_id' => 'required',
            'item_id' => 'required',
        ]);

        $cartId      = $request->input('cart_id');
        $productId   = $request->input('product_id');

        try{
            return CartService::removeItenInCart($cartId, $productId);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }

    public function getCart(int $id){
        try{
            return CartService::getCart($id);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }

    public function clearAllItensInCart(int $id){
        try{
            return CartService::clearAllItensInCart($id);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }

    public function addPayment(Request $request){

        $this->validate($request, [
            'cart_id' => 'required',
            'payment_id' => 'required',
        ]);

        $cartId      = $request->input('cart_id');
        $paymentId   = $request->input('payment_id');

        try{
            return CartService::addPayment($cartId, $paymentId);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }

    }



}
