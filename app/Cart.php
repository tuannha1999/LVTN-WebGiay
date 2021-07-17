<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $products = [];
    public $supplier = [];

    public $totalPrice = 0;
    public $totalQuanty = 0;

    public function __construct($cart)
    {
        if ($cart) {
            $this->products = $cart->products;
            $this->supplier = $cart->supplier;
            $this->totalPrice = $cart->totalPrice;
            $this->totalQuanty = $cart->totalQuanty;
        }
    }
    public function addNCC($ncc, $id)
    {
        $newSupplier =  ['supplierinfo' => $ncc];
        if ($this->supplier) {
            if (array_key_exists($id, $this->supplier)) {
                $newSupplier = $this->supplier[$id];
            }
        }
        $this->supplier[$id] = $newSupplier;
    }
    public function AddCart($product, $id, $size, $qty, $price)
    {
        $newProduct =  ['quanty' =>  0, 'id_size' => $size->id, 'size' => $size->size, 'price' => 0, 'entryprice' => $price, 'productinfo' => $product];
        if ($this->products) {
            if (array_key_exists($id . $size->id, $this->products)) {
                $newProduct = $this->products[$id . $size->id];
            }
        }
        // $this->products[$id . $size->id] = $newProduct;
        // $this->totalPrice += $price * $qty;
        // $this->totalQuanty = $qty;
        $newProduct['quanty'] += $qty;
        $newProduct['price'] = $newProduct['quanty'] * $price;
        $this->products[$id . $size->id] = $newProduct;
        $this->totalQuanty += $qty;
        $this->totalPrice += $price * $qty;
    }
    public function DeleteItemCart($id)
    {
        $this->totalQuanty -= $this->products[$id]['quanty'];
        $this->totalPrice -= $this->products[$id]['price'];
        unset($this->products[$id]);
    }
    public function DeleteNCC($id)
    {
        unset($this->supplier[$id]);
    }
    public function updateCart($id, $qty, $price)
    {
        $this->totalQuanty -= $this->products[$id]['quanty'];
        $this->totalPrice -= $this->products[$id]['price'];

        $this->products[$id]['quanty'] = $qty;
        $this->products[$id]['entryprice'] = $price;
        $this->products[$id]['price'] = $qty * $this->products[$id]['entryprice'];

        $this->totalQuanty += $this->products[$id]['quanty'];
        $this->totalPrice += $this->products[$id]['price'];
    }
}
