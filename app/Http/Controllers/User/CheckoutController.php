<?php

namespace App\Http\Controllers\User;

use Stripe;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller {
    public function index(Request $request) {
        $auth =  Auth::guard('user')->user();

        $grandTotal= 0;
        foreach(session('cart') as $eachProduct){
            $grandTotal += $eachProduct['total'];
        }
        return view('user.pages.checkout.index', compact('auth', 'grandTotal'));
    }

    public function checkout(Request $request) {
        $id =  Auth::guard('user')->user()->id;
        $grandTotal= 0;
        foreach(session('cart') as $eachProduct){
            $grandTotal += $eachProduct['total'];
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|min:5',
            'email'         => 'required|email|min:10|max:50|unique:users,email,' . $id . ',id',
            'phone'         => 'required|numeric|min:10',
            'pin_code'      => 'required|numeric|min:6',
            'address'       => 'required|min:5',
            'card_no'       => 'required|numeric|min:16',
            'expiry_month'  => 'required|numeric|min:2',
            'expiry_year'   => 'required|numeric|min:2',
            'cvv'           => 'required|numeric|min:3',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $response = \Stripe\Token::create(array(
                "card" => array(
                    "number"    => $request->input('card_no'),
                    "exp_month" => $request->input('expiry_month'),
                    "exp_year"  => $request->input('expiry_year'),
                    "cvc"       => $request->input('cvv')
                )
            ));
            if (!isset($response['id'])) {
                return redirect()->route('user.checkout')->with(['message' => 'Error Detected something went to wrong !']);
            }

            $charge = \Stripe\Charge::create([
                'card' => $response['id'],
                'currency' => 'USD',
                'amount' =>  100,
                'description' => 'Stripe Payment',
            ]);

            if ($charge['status'] == 'succeeded') {
                $order = new Order();
                $order->user_id = $id;
                $order->phone = $request->phone;
                $order->pin_code = $request->pin_code;
                $order->address = $request->address;
                $order->payment_mode = 1;
                $order->total_amount = $grandTotal;
                if ($order->save()) {
                    $cartData = session('cart');
                    foreach ($cartData as $key =>  $eachData) {
                        $product = Product::where('id', $eachData['product_id'])->first();
                        $startDate = $product->discount_start;
                        $endDate = $product->discount_end;
                        $currentDate = Carbon::now();
                        $result1 = $currentDate->gte($startDate);
                        $result2 = $currentDate->lte($endDate);
                        if ($result1 ==  $result2) {
                            $discount = $eachData['discount'];
                        } else {
                            $discount = null;
                        }
                        $orderDetail = new OrderDetail();
                        $orderDetail->order_id = $order->id;
                        $orderDetail->user_id = $id;
                        $orderDetail->product_id = $eachData['product_id'];
                        $orderDetail->quantity = $eachData['quantity'];
                        $orderDetail->price = $eachData['price'];
                        $orderDetail->discount = $discount;
                        $orderDetail->total_amount = $eachData['total'];
                        $orderDetail->save();
                    }
                }
                session()->forget('cart');
                return redirect()->route('user.home')->with(['message' => 'Payment Success && Order successfully place !']);
            } else {
                return redirect()->route('user.checkout')->with(['message' => 'Error Detected something went to wrong !']);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
