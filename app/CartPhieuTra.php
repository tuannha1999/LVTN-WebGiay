<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartPhieuTra extends Model
{
    //
    public $products = [];
    public $totalPhieutra = 0;
    public $QuantyPhieutra = 0;

    public function __construct($phieutra)
    {
        if ($phieutra) {
            $this->products = $phieutra->products;
            $this->totalPhieutra = $phieutra->totalPhieutra;
            $this->QuantyPhieutra = $phieutra->QuantyPhieutra;
        }
    }
    public function addSanpham($product, $id, $size, $qty, $price, $img)
    {
        $newProduct =  ['quanty' =>  0, 'img' => $img, 'id_size' => $size->id, 'size' => $size->size, 'price' => 0, 'giaban' => $price, 'productinfo' => $product];
        if ($this->products) {
            if (array_key_exists($id . $size->id, $this->products)) {
                $newProduct = $this->products[$id . $size->id];
            }
        }
        $newProduct['quanty'] += $qty;
        $newProduct['price'] = $newProduct['quanty'] * $price;
        $this->products[$id . $size->id] = $newProduct;
        $this->QuantyPhieutra += $qty;
        $this->totalPhieutra += $price * $qty;
    }
    public function deleteSanPham($id)
    {
        $this->QuantyPhieutra -= $this->products[$id]['quanty'];
        $this->totalPhieutra -= $this->products[$id]['price'];
        unset($this->products[$id]);
    }
    public function minusSanPham($id)
    {
        $this->QuantyPhieutra--;
        $this->totalPhieutra -=  $this->products[$id]['giaban'];

        $this->products[$id]['quanty']--;
        $this->products[$id]['price'] =  $this->products[$id]['quanty'] *  $this->products[$id]['giaban'];
    }
}
