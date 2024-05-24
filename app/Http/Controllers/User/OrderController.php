<?php

namespace App\Http\Controllers\User;

use PDF;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index(Request $request) {
        $auth =  Auth::guard('user')->user()->id;
        $orderData = Order::where('user_id',$auth)->get();
        return view('user.pages.order.index', compact('orderData'));
    }
    
    public function updateStatus($id) {
        $order = OrderDetail::find($id);
        $order->order_detail_status = "3";
        $order->save();
        Session::flash('message', "Order cancel successfully !");
    }
    public function orderView($id) {
        $orderDetails = OrderDetail::where('order_id',$id)->get();
        return view('user.pages.order.view-order', compact('orderDetails'));
    }
    public function downloadPDF($id) {
        $order = Order::findOrFail($id)->first();
        $grandTotal = $order->total_amount;
        $orderDetails = OrderDetail::where('order_id',$id)->get();

        $data = [
            'title' => 'Payment Slip',
            'date' => date('m/d/Y'),
            'grandTotal' => $grandTotal,
            'orderDetails' => $orderDetails
        ]; 
        $pdf = PDF::loadView('user.pages.pdf.demo', $data);
        return $pdf->download('e_com_order_history.pdf');
    }
}