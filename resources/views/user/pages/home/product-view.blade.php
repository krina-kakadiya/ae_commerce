@extends('user.layout.master')

@section('title')
User / Product / View
@endsection

@section('container')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
            <div id="productMain" class="row">
                <div class="col-md-6">
                    <div data-slider-id="1" class="owl-carousel shop-detail-carousel">
                        @foreach ($productData->images as $item)
                        <div class="item"> <img src="{{ asset('product-image/'.$item['product_image']) }}" alt="" height="500"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <h1 class="text-center"> {{ $productData->title}} </h1>
                        <p class="goToDescription"><a href="#details" class="scroll-to">Scroll to product details</a>
                        </p>
                        <p class="price"> Rs.{{ $productData->price }} /- </p>
                        <p class="text-center buttons">
                            <a href="{{ route('user.add.to.cart',$productData->id) }}" class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i>
                                Add to cart
                            </a>
                        </p>
                    </div>
                    <div data-slider-id="1" class="owl-thumbs">
                        @foreach ($productData->images as $item)
                        <button class="owl-thumb-item">
                            <img src="{{ asset('product-image/'.$item['product_image']) }}" alt="" width="70"  height="100">
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="details" class="box">
                <h4>Product details</h4>
                <p> {!! $productData->description !!} </p>

                <hr>
            </div>
        </div>
    </div>
</div>
@endsection