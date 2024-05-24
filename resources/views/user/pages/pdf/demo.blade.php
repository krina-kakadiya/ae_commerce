<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua.</p>
  
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
      <hr>
      <tfoot>
        <tr>
          <td colspan="6"></td>
          <td> <b> Grand Total : </b> </td>
          <td> <b> Rs. {{ $grandTotal }} /- </b></td>
        </tr>

      </tfoot>
    </table>
  
</body>
</html>