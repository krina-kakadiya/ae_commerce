@extends('user.layout.master')
@section('title')
User / Orders
@endsection
@section('container')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <!-- breadcrumb-->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li aria-current="page" class="breadcrumb-item active">My Orders</li>
        </ol>
      </nav>
    </div>
    <div id="basket" class="col-lg-12">
      <div class="box">
        <form method="post" action="checkout1.html">
          @if (!$orderData->isEmpty())
          <h3> Order History </h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Product Image</th>
                  <th>Phone</th>
                  <th>Pin Code</th>
                  <th>Address</th>
                  <th>Total Amount</th>
                  <th>Payment Mode</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orderData as $eachOrder)
                <tr data-id="">
                  <td> 
                    @foreach($eachOrder->orderDetails as $subOrderImage)
                    <a href="{{ route('user.product.view',$subOrderImage->product->id) }}">
                      <img src="{{ asset('product-image/'.$subOrderImage->product->images[0]['product_image']) }}" width="50" height="50" class="img-responsive" />
                    </a>
                    @endforeach
                  </td>
                  <td> {{ $eachOrder['phone'] }} </td>
                  <td> {{ $eachOrder['pin_code'] }} </td>
                  <td> {{ $eachOrder['address'] }} </td>
                  <td> Rs. {{ $eachOrder['total_amount'] }}/- </td>
                  <td> <span class="badge rounded-pill bg-primary" style="cursor: pointer;">STRIPE</span> </td>

                  <td>
                    @if ($eachOrder['order_status'] == 1)
                    <a class="changeStatusOfOrder" data-id="{{ $eachOrder['id'] }}" data-toggle="tooltip" rel="tooltip"
                      data-placement="top" title="Pending"> <span class="badge  bg-warning">Pending</span> </a>
                    @elseif($eachOrder['order_status'] == 2)
                    <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Success"> <span
                        class="badge bg-success">Success</span> </a>
                    @elseif($eachOrder['order_status'] == 3)
                    <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Cancel"> <span
                        class="badge bg-danger">Cancel</span> </a>
                    @endif
                  </td>

                  <td> {{ Carbon\Carbon::parse($eachOrder['created_at'])->format('d-M-Y') }} </td>
                  <td>  
                        <a href="{{ route('user.order.view',$eachOrder->id) }}">
                          <i class="fa fa-eye" style="font-size:25px;color:rgb(0, 5, 7)" aria-hidden="true"></i>
                        </a>
                  </td>
                  <td>
                        <a href="{{ route('user.order.download.pdf',$eachOrder->id) }}">
                          <i class="fa fa-file-pdf-o" style="font-size:25px;color:red" aria-hidden="true"></i>
                        </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <center>
            <h3 style="font-family: cursive;">No Order Histrory</h3>
          </center>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
