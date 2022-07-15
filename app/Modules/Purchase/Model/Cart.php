<?php

namespace App\Modules\Purchase\Model;

use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    public const STATUS_CLOSE = 0;
    public const STATUS_OPEN = 1;
    public const STATUS_PAYMENT = 2;
    public const STATUS_ABANDONMENT = 3;


    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'status'
    ];

    protected $itens = null;

    protected $products = null;

    protected $payments = null;

    public function toArray()
    {
        if($this->itens == null){
            $this->getItens();
            $this->getProducts();
        }

        if($this->payments == null){
            $this->getPayments();
        }

        $itens = [];

        $invoiceTotal = 0;

        $payValue = $this->getPaymentsTotal();

        foreach($this->itens as $item){
            // aqui eu não estou fazendo uma query nova mas sim filtrando os dados da query antiga
            // isso evita o bug do N+1
            $product = $this->products->where('id', $item->id)->first();

            $data = [
                "id"        => $product->id,
                "name"      => $product->name,
                "price"     => $item->price,
                "quantity"  => $item->quantity,
                "toral"     => $item->getTotal(),
            ];
            $invoiceTotal = $invoiceTotal + $item->getTotal();
            array_push($itens, $data);
        }

        return [
            "id"                => $this->id,
            "email"             => $this->email,
            "status"            => $this->status,
            "itens"             => $itens,
            "payments"          => $this->payments,
            "invoice_value"     => $invoiceTotal,
            "invoice_payment"   => $payValue,
            "paid"              => ($invoiceTotal >= $payValue ? false : true ),
        ];
    }

    public static function statusIsValid(int $status):bool{

        if($status == Cart::STATUS_CLOSE || $status == Cart::STATUS_OPEN  || $status == Cart::STATUS_PAYMENT  || $status == Cart::STATUS_ABANDONMENT ){
           return true;
        }

        return false;

    }

    public function getItens(){
        $this->itens = ItemCart::where('cart_id', $this->id)->get();
        return $this->itens;
    }

    public function getPayments(){
        $this->payments = PaymentCart::where('cart_id', $this->id)->get();
        return $this->payments;
    }

    public function getProducts(){
        $list_itens = [];
        foreach($this->itens as $item){
            array_push($list_itens, $item->id);
        }

        $this->products =  Product::find($list_itens);
        return $this->products;
    }

    public function clearCart(){
        $this->getItens();

        $list_itens = [];

        foreach($this->itens as $item){
            array_push($list_itens, $item->id);
        }

        ItemCart::where('cart_id', $this->id)->whereIn('id', $list_itens)->get();

    }

    public function getPaymentsTotal(){
        if($this->payments == null){
            $this->getPayments();
        }
        
        $total = 0;

        foreach( $this->payments as $pay){
            $total = $total + $pay->price;
        }

        return $total;
    }




}
