<?php

namespace App\Modules\Product\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Error\Error;
use App\Modules\Product\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function create(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'price' => 'required',
        ]);

        $name      = $request->input('name');
        $status    = $request->input('status', 0);
        $inventory = $request->input('inventory', 0);
        $price     = $request->input('price');

        try {
            return ProductService::createNewProduct($name, $price, $status, $inventory);
        } catch (Error $e) {
            return response(['message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response(['message' => "Ops! Server error"], 500);
        }
    }
}
