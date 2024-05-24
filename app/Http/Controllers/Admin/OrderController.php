<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Order::select('*');
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_details', function ($row) {
                    $result = $row->user;
                    return  "Name :" . $result->name . " <br> Email : " . $result->email;
                })
                ->editColumn('payment_mode', function ($row) {
                    $mode = $row->payment_mode;
                    if ($mode == "1") {
                        return "<span class='badge rounded-pill bg-primary' style='cursor: pointer;'>STRIPE</span>";
                    } elseif ($mode == "2") {
                        return "<span class='badge rounded-pill bg-info' style='cursor: pointer;'>COD</span>";
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })

                ->editColumn('order_status', function ($row) {
                    $status = $row->order_status;
                    if ($status == "1") {
                        $data = "<a class='changeStatusOfOrder'  href='javascript:void(0);' onclick='changeStatusOfOrder($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Pending'> <span class='badge rounded-pill bg-warning' style='cursor: pointer;'>Pending</span> </a>";
                    } elseif ($status == "2") {
                        $data = "<a class='changeStatusOfOrder'  href='javascript:void(0);' onclick='changeStatusOfOrder($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Success'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Success</span> </a>";
                    } elseif ($status == "3") {
                        $data = "<a class='changeStatusOfOrder'  href='javascript:void(0);' onclick='changeStatusOfOrder($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Cancel'> <span class='badge rounded-pill bg-danger' style='cursor: pointer;'>Cancel</span> </a>";
                    }
                    return $data;
                })
                ->addColumn('action', function ($row) {
                    $btn = "<a href='/admin/order/view/$row->id' class='btn btn-dark btn-sm viewPost' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='View Post'> View </a>";
                    return $btn;
                })
                ->rawColumns(['user_details','payment_mode', 'order_status', 'action'])
                ->make(true);
        }
        return view('admin.pages.order.index');
    }

    public function updateStatus($id) {
        $order = Order::findOrFail($id);
        $status = $order->order_status;
        if ($status == 1) {
            $order->order_status = "2";
        } elseif ($status == 2) {
            $order->order_status = "3";
        } elseif ($status == 3) {
            $order->order_status = "1";
        }
        $order->save();
        Session::flash('success', "Order status change successfully !");
    }

    public function view($id, Request $request) {
        if ($request->ajax()) {
            $data = OrderDetail::where('order_id', $id)->with('order', 'product')->get();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('product_image', function ($row) {
                    foreach ($row->product->images as $each) {
                        $url = asset("product-image/$each->product_image");
                        $link = "/admin/product/view/$each->product_id";
                        return '<a href='. $link .'><img src=' . $url . ' border="0" width="50"  height="50" class="img-rounded" align="center" /></a>';
                    }
                })
                ->addColumn('product_details', function ($row) {
                    $result = $row->product;
                    return  "Title :" . $result->title . " <br> Category : " . $result->category->category_name;
                })
                ->addColumn('discount', function ($row) {
                    $discount = $row->discount;
                    if (!empty($discount)) {
                        return $discount;
                    } else {
                    return " No Discount ";
                    }
                })
                ->editColumn('order_detail_status', function ($row) {
                    $status = $row->order_detail_status;
                    if ($status == "1") {
                        $data = "<a class='changeStatusOfOrderDetail'  href='javascript:void(0);' onclick='changeStatusOfOrderDetail($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Pending'> <span class='badge rounded-pill bg-warning' style='cursor: pointer;'>Pending</span> </a>";
                    } elseif ($status == "2") {
                        $data = "<a class='changeStatusOfOrderDetail'  href='javascript:void(0);' onclick='changeStatusOfOrderDetail($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Delevered '> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Delevered </span> </a>";
                    } elseif ($status == "3") {
                        $data = "<a class='changeStatusOfOrderDetail'  href='javascript:void(0);' onclick='changeStatusOfOrderDetail($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Cancel'> <span class='badge rounded-pill bg-danger' style='cursor: pointer;'>Cancel</span> </a>";
                    }
                    return $data;
                })

                ->rawColumns(['product_image', 'product_details', 'discount','order_detail_status'])
                ->make(true);
        }
        return view('admin.pages.order.view', compact('id'));
    }

    public function updateStatusOrderDetails($id) {
        $order = OrderDetail::findOrFail($id);
        $status = $order->order_detail_status;
        if ($status == 1) {
            $order->order_detail_status = "2";
        } elseif ($status == 2) {
            $order->order_detail_status = "3";
        } elseif ($status == 3) {
            $order->order_detail_status = "1";
        }
        $order->save();
        Session::flash('success', "Order status change successfully !");
    }
}
