<?php

namespace App\Modules\Payment\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Error\Error;
use App\Modules\Payment\Service\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Criar novo cupom de desconto
     *
     * @bodyParam  name string  required Nome do cupom de desconto
     * @bodyParam  value int  required  Valor do cupom
     * @bodyParam status int  required  status do cupom 1 - ativo e 0 - desativado Example:1
     */
    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|max:255',
            'value' => 'required',
        ]);

        $name      = $request->input('name');
        $status    = $request->input('status', 1);
        $value     = $request->input('value');

        try{
            return PaymentService::createNewCoupon($name, $value, $status);
        }catch(Error $e){
            return response(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response(['message' => "Ops! Server error"], 500);
        }

    }

}
