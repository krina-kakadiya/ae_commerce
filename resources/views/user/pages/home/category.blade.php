@extends('user.layout.master')

@section('title')
User / Category / View
@endsection

@section('container')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                <h5>
                    {{ Session::get('message') }}
                </h5>
            </div>
            <br>
            @endif

            <div class="box">
                @if (!empty($categoryDetails))
                <h3>
                    <img src="{{ asset('category-image/'.$categoryDetails['category_image']) }}" alt="" height="65"
                        width="65">
                    {{ $categoryDetails['category_name'] }}
                </h3>
                @else
                <h3>Category Not Found</h3>
                @endif
            </div>

            <div class="row products">
                @forelse ($productData as $item)
                <div class="col-lg-3 col-md-4">
                    <div class="product">
                        <a href=""><img src="{{ asset('product-image/'.$item->images[0]['product_image']) }}" alt="" height="250" width="230"></a>
                        <div class="text">
                            <h3>
                                <a href="detail.html"> {{ $item->title }} </a>
                            </h3>
                            <p class="price">
                                <del></del> Rs.{{ $item->price }} /-
                            </p>
                            <p class="buttons">
                                <a href="{{ route('user.product.view',$item->id) }}" class="btn btn-outline-secondary">View detail</a>
                                <a href="{{ route('user.add.to.cart',$item->id) }}" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add tocart
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <h5 class="card-title mb-2"> NO PRODUCTS FOUND </h5>
                <br><br>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection