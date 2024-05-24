@extends('user.layout.master')
@section('title')
User / Home
@endsection
@section('container')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <!-- breadcrumb-->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li aria-current="page" class="breadcrumb-item active">Shopping cart</li>
        </ol>
      </nav>
    </div>
    {{--
    <?php 
      echo "<pre>";
      print_r(session('cart'))
      ?> --}}
    <div id="basket" class="col-lg-12">

      @if(!empty(session('cart')))

      <div class="box">
        <form method="post" action="checkout1.html">
          <h1>Shopping cart</h1>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th colspan="2">Product Image</th>
                  <th>Quantity</th>
                  <th>Unit price</th>
                  <th>Discount</th>
                  <th colspan="2">Total</th>
                </tr>
              </thead>
              <tbody>
                @php
                $grandTotal = 0;
                @endphp
                @foreach(session('cart') as $id => $details)
                @php $grandTotal += $details['total'] @endphp
                <tr data-id="{{ $id }}">
                  <td> <img src="{{ asset('product-image/'.$details['product_image']) }}" width="50" height="50"
                      class="img-responsive" /> </td>
                  <td> {{ $details['title'] }} </td>
                  <td> <input type="number" value="{{ $details['quantity'] }}"
                      class="form-control quantity update-cart"> </td>
                  <td> {{ $details['price'] }} </td>
                  <td>
                    @if ($details['discount'] != "")
                    {{ $details['discount'] }}
                    @else
                    {{ "-" }}
                    @endif
                  </td>
                  <td> {{ $details['total'] }} </td>
                  <td><a href="#"  data-toggle="tooltip" data-placement="bottom" title="Remove Product From Cart"><i class="fa fa-trash-o remove-from-cart"></i></a></td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5">Grand Total</th>
                  <th colspan="2"> {{ $grandTotal }} /-</th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
            <div class="left"><a href="{{ route('user.home') }}" class="btn btn-outline-secondary"><i
                  class="fa fa-chevron-left"></i> Continue shopping</a></div>
            <div class="right">
              @if (auth()->guard('user')->check())
              <a class="btn btn-primary" href="{{ route('user.checkout') }}">
                Proceed to checkout 
                <i class="fa fa-chevron-right"></i>
              </a>
              @else
              <a class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Please Login & Proceed to
                checkout <i class="fa fa-chevron-right"></i></a>
              @endif
            </div>
          </div>
        </form>
      </div>
      @else
      <div class="box">
        <center>
          <h3 style="font-family: cursive;">Your Cart Is Empty Please Continue Shopping</h3>
        </center>
        <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
          <div class="left"><a href="{{ route('user.home') }}" class="btn btn-outline-secondary"><i
                class="fa fa-chevron-left"></i> Continue shopping</a></div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
  
        $.ajax({
            url: '{{ route('user.update.cart') }}',
            method: "post",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });


    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('user.remove.from.cart') }}',
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });



</script>
@endsection