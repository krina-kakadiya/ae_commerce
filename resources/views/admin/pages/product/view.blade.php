@extends('admin.layout.master')

@section('title')
Admin / Product / View
@endsection

@section('container')
<div class="pagetitle">
  <h1>Product</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Product</li>
      <li class="breadcrumb-item active">View</li>

    </ol>
  </nav>
</div>

<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <a href="{{ URL::previous() }}" class="btn btn-dark btn-sm" style="float: right;margin-top: 25px;"
            data-toggle="tooltip" rel="tooltip" data-placement="top" title="Go Back">Go Back</a>

          <h5 class="card-title">Product Details</h5>
          @foreach ($productImagesData as $item)
          <img src="{{ asset('product-image/'.$item['product_image']) }}" height="150" width="150"
            style="margin-right: 30px;">
          @endforeach
          <p></p>
          <br>

          <table class="table table-bordered">
            <tbody>
              <tr>
                <th scope="row">Title</th>
                <td>{{ $productData->title }} </td>
              </tr>
              <tr>
                <th scope="row">Category</th>
                <td>{{ $productData->category->category_name }}</td>
              </tr>
              <tr>
                <th scope="row">Price</th>
                <td>{{ $productData->price }}</td>
              </tr>
              <tr>
                <th scope="row">Stock</th>
                <td>{{ $productData->stock }} </td>
              </tr>
              <tr>
                <th scope="row">Shipping Fee</th>
                <td>{{ $productData->shipping_fee }}</td>
              </tr>
              <tr>
                <th scope="row">Discount</th>
                <td>{{ $productData->discount }}</td>
              </tr>
              <tr>
                <th scope="row">From Date </th>
                <td>{{ $productData->discount_start }} </td>
              </tr>
              <tr>
                <th scope="row">To Date </th>
                <td>{{ $productData->discount_end }}</td>
              </tr>
              <tr>
                <th scope="row">Description</th>
                <td>{!! $productData->description !!}</td>
              </tr>
              <tr>
                <th scope="row">Status</th>
                <td>
                  <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Status">
                    <span @if($productData->product_status == 0)? class="badge rounded-pill bg-success" @else
                      class="badge
                      rounded-pill bg-danger" @endif style="cursor: pointer;">
                      @if($productData->product_status == 0) Active @else Inactive @endif </span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection