<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    public $products = null;
    public $totalPrice = 0;
    public $totalQuanty = 0;

    public function __construct($cart)
    {
        if ($cart) {
            $this->products = $cart->products;
            $this->totalPrice = $cart->totalPrice;
            $this->totalQuanty = $cart->totalQuanty;
        }
    }
    public function addCart($product, $id, $quanty)
    {
        $newProduct = ['quanty' => 0, 'price' => $product->giaban, 'productInfo' => $product];
        if ($this->products) {
            if (array_key_exists($id, $this->products)) {
                $newProduct = $this->products[$id];
            }
        }
        $newProduct['quanty'] += $quanty;
        $newProduct['price'] = $newProduct['quanty'] * $product->giaban;
        $this->products[$id] = $newProduct;
        $this->totalQuanty += $quanty;
        $this->totalPrice += $product->giaban * $quanty;
    }
    public function deleteCart($id)
    {
        $this->totalPrice -= $this->products[$id]['price'];
        $this->totalQuanty -= $this->products[$id]['quanty'];
        unset($this->products[$id]);
    }
    public function updateCart($id, $quanty)
    {
        $this->totalQuanty -= $this->products[$id]['quanty'];
        $this->totalPrice -= $this->products[$id]['price'];

        $this->products[$id]['quanty'] = $quanty;
        $this->products[$id]['price'] = $quanty * $this->products[$id]['productInfo']->giaban;

        $this->totalQuanty += $this->products[$id]['quanty'];
        $this->totalPrice += $this->products[$id]['price'];
    }
}
