<?php

namespace App\Http\Controllers;

use App\Hinhanh;
use App\Sanpham;
use App\Size;
use App\Loaisanpham;
use Session;
use Cart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function themGiohang(Request $req)
    {
        old('size');
        $product = Sanpham::where('id', $req->id)->first();
        $img = Hinhanh::where('id_sp', $req->id)->where('avt', 1)->first();
        $size = Size::where('size', $req->size)->where('id_sp', $req->id)->first();
        $sl = $req->qty;
        foreach (Cart::content() as $item) {
            if ($item->id == $req->id && $item->options->size->id == $req->size) {
                $sl = $item->qty + $req->qty;
            }
        }
        if ($size->soluong >= $sl) {
            Cart::add(
                [
                    'id' => $product->id,
                    'name' => $product->tensp,
                    'qty' => $req->qty,
                    'price' => $product->giakm == 0 ? $product->giaban : $product->giakm,
                    'options' => ['size' => $size, 'images' => $img->name,]
                ]
            );
            return response()->json(['success' => 'Đã thêm vào giỏ hàng', 'data' => Cart::count()]);
        }
        return response()->json(['error' => 'Số lượng trong kho còn ' . $size->soluong . ' sản phẩm' .
            '<br>' . 'Chúng tôi xin lỗi vì sự bất tiện này!']);
    }
    public function getCart()
    {
        $loai_sp = Loaisanpham::all();
        return view('pages.giohang.list_cart', compact('loai_sp'));
    }
    public function xoaGiohang($id)
    {
        Cart::remove($id);
        return view('pages.giohang.cart');
    }
    public function qtyUp($rowId)
    {
        $product = Cart::get($rowId);
        $size = Size::where('id', $product->options->size->id)->first();
        if ($size->soluong > $product->qty) {
            $qty = $product->qty + 1;
            Cart::update($rowId, $qty);
            return view('pages.giohang.cart');
        }
        return response()->json(['error' => 'Số lượng trong kho còn ' . $size->soluong . ' sản phẩm' .
            '<br>' . 'Chúng tôi xin lỗi vì sự bất tiện này!']);
    }
    public function qtyDown($rowId)
    {
        $product = Cart::get($rowId);
        if ($product->qty > 1) {
            $qty = $product->qty - 1;
            Cart::update($rowId, $qty);
            return view('pages.giohang.cart');
        }
        return view('pages.giohang.cart');
    }
}
