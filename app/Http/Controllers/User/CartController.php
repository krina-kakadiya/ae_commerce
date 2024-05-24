<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index() {
        return view('user.pages.cart.index');
    }

    public function addToCart($id) {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $product = Product::where('id', $id)->first();
            $startDate = $product->discount_start;
            $endDate = $product->discount_end;
            $currentDate = Carbon::now();
            $result1 = $currentDate->gte($startDate);
            $result2 = $currentDate->lte($endDate);
            $totalPrice = $product->price * 1;
            if (!empty($product->discount) && $result1 ==  $result2) {
                $discount = $product->discount;
                $multiplyByDiscount = $totalPrice * $discount;
                $divideByHundred = $multiplyByDiscount / 100;
                $finalTotalPrice = $totalPrice - $divideByHundred;
            } else {
                $discount = null;
                $finalTotalPrice = $totalPrice;
            }
            $cart[$id] = [
                "product_id" => $product->id,
                "product_image" => $product->images[0]['product_image'],
                "title" => $product->title,
                "quantity" => 1,
                "stock" => $product->stock,
                "price" => $product->price,
                "discount" => $discount,
                "discount_start" => $product->discount_start,
                "discount_end" => $product->discount_end,
                "total" => $finalTotalPrice,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request) {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            $product = Product::where('id', $request->id)->first();

            $startDate = $product->discount_start;
            $endDate = $product->discount_end;
            $currentDate = Carbon::now();

            $result1 = $currentDate->gte($startDate);
            $result2 = $currentDate->lte($endDate);

            $totalPrice = $product->price * $request->quantity;
            $discount = $product->discount;

            if (!empty($product->discount) && $result1 ==  $result2) {

                $multiplyByDiscount = $totalPrice * $discount;
                $divideByHundred = $multiplyByDiscount / 100;
                $finalTotalPrice = $totalPrice - $divideByHundred;
            } else {
                $finalTotalPrice = $totalPrice;
            }

            $cart = session()->get('cart');
            $cart[$request->id]["total"] = $finalTotalPrice;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request) {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
