<?php

namespace App\Modules\Purchase\Controller;

use Illuminate\Http\Request;
use App\Modules\Error\Error;
use App\Http\Controllers\Controller;
use App\Modules\Purchase\Service\CartService;

class CartController extends Controller
{

    /**
     * Criar novo carrinho de compra
     *
     * @bodyParam  email string  Email do cliente, pode ser null Example:joao@gmail.com
     * @bodyParam  status int  required  status do carrinho 
     */
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

    /**
     * Adiciona um novo item no carrinho
     * 
     * Se o produto adicionado já estiver no carrinho, ira ser acresentado a quantidade no carrinho
     *
     * @bodyParam  cart_id int  Id do carrinho
     * @bodyParam  product_id int  Id do produto
     * @bodyParam  quantity int  quantidade de produtos adicionados
     */
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

    /**
     * Remove um produto do carrinho
     * 
     * @bodyParam  cart_id int  Id do carrinho
     * @bodyParam  product_id int  Id do produto
     */
    public function removeItenInCart(Request $request){
        $this->validate($request, [
            'cart_id' => 'required',
            'product_id' => 'required',
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

    /**
     * Busca os dados do Carrinho
     * @urlParam id integer required  Id do carrinho.
     */
    public function getCart(int $id){
        try{
            return CartService::getCart($id);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }


    /**
     * Retira todos os produtos do Carrinho
     * 
     * @bodyParam  id int  Id do carrinho
     */
    public function clearAllItensInCart(int $id){
        try{
            return CartService::clearAllItensInCart($id);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }
    }


    /**
     * Adiciona um cupom de desconto no carrinho
     * 
     * @bodyParam  cart_id int  Id do carrinho
     * @bodyParam  payment_id int  Id do cupom
     */
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
