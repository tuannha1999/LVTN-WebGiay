<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Sanpham;
use Session;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function themGiohang(Request $req, $id, $quanty)
    {
        $product = Sanpham::where('masp', $id)->first();
        if ($product != null) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->addCart($product, $id, $quanty);
            $req->Session()->put('Cart', $newCart);
        }
        return view('pages.sanpham.cart');
    }
    public function getCart()
    {
        if (Session('Cart') != null) {
            return view('pages.sanpham.cart');
        }
        $oldCart = Session('cart');
        $cart = new Cart($oldCart);

        return view('pages.sanpham.cart');
    }
    public function xoaGiohang(Request $req, $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->deleteCart($id);
        if (count($newCart->products) > 0) {
            $req->Session()->put('Cart', $newCart);
        } else {
            $req->Session()->forget('Cart');
        }
        return redirect('cart');
    }
    public function suaAllGiohang(Request $req)
    {
        foreach ($req->data as $item) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->updateCart($item["key"], $item["value"]);
            $req->Session()->put('Cart', $newCart);
        }
    }
}
