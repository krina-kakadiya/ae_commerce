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
          <li aria-current="page" class="breadcrumb-item">My Orders</li>
          <li aria-current="page" class="breadcrumb-item active">Details</li>
        </ol>
      </nav>
    </div>
    <div id="basket" class="col-lg-12">
      <div class="box">
        <form method="post" action="checkout1.html">
          <h3> Order Details </h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th colspan="2">Product Image</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Total</th>
                  <th>Order Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orderDetails as $eachOrder)
                <tr data-id="">
                  <td> <a href="{{ route('user.product.view',$eachOrder->product->id) }}"><img
                        src="{{ asset('product-image/'.$eachOrder->product->images[0]['product_image']) }}" width="50"
                        height="50" class="img-responsive" /></a></td>
                  <td> {{ $eachOrder->product['title'] }} </td>
                  <td> {{ $eachOrder['quantity'] }} </td>
                  <td> {{ $eachOrder['price'] }} </td>
                  <td> {{ $eachOrder['discount'] }} </td>

                  <td> Rs. {{ $eachOrder['total_amount'] }}/- </td>
                  <td> {{ Carbon\Carbon::parse($eachOrder['created_at'])->format('d-M-Y') }} </td>
                  <td>
                    @if ($eachOrder['order_detail_status'] == 1)
                    <a class="changeStatusOfOrder" data-id="{{ $eachOrder['id'] }}" data-toggle="tooltip" rel="tooltip"
                      data-placement="top" title="Pending"> <span class="badge  bg-warning">Pending</span> </a>
                    @elseif($eachOrder['order_detail_status'] == 2)
                    <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Delevered"> <span
                        class="badge bg-success">Delevered</span> </a>
                    @elseif($eachOrder['order_detail_status'] == 3)
                    <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Cancel"> <span
                        class="badge bg-danger">Cancel</span> </a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
            <div class="left"><a href="{{ route('user.order') }}" class="btn btn-outline-secondary"><i
                  class="fa fa-chevron-left"></i> Back </a></div>
            <div class="right">
              {{-- <button class="btn btn-outline-secondary"><i class="fa fa-refresh"></i> Update cart</button> --}}
              {{-- <a class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Proceed to checkout <i
                  class="fa fa-chevron-right"></i></a> --}}
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
        $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // change status
    $(document).on("click",".changeStatusOfOrder",function() {
      var id = $(this).attr("data-id");
      if(confirm("Are You sure want to change status !")) {
          $.ajax({
              method:'post',
              url: '/update-status/'+id,
              success: function (data) {
                  location.reload();
              },
          });
      }
  });
});



</script>
@endsection