@extends('user.layout.master')
@section('title')
User / Home
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
            <div class="row products" id="productBody">
            </div>

            <div class="auto-load text-center">
                <div class="pages">

                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100"
                        enable-background="new 0 0 0 0" xml:space="preserve">
                        <path fill="#000"
                            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                        </path>
                    </svg>
                </div>
            </div>
            <div class="pages">
                <br><br><br><br>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

    var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        infinteLoadMore(page);
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });
        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "/?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
            })
            .done(function (response) {
                if (response.length == 0) {
                    $('.auto-load').html("<h3>You view all the products !<h3>");
                    return;
                }
                $('.auto-load').hide();
                $("#productBody").append(response);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
        }
    });
</script>
@endsection