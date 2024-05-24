@extends('user.layout.master')
@section('title')
User / Checkout
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


            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li aria-current="page" class="breadcrumb-item active">Checkout</li>
                </ol>
            </nav>
        </div>
        <div id="checkout" class="col-lg-12">
            <div class="box">
                <form method="post" id="userCheckOutForm"
                    action="{{ route('user.checkout',['grand_total'=>$grandTotal])}}">
                    @csrf
                    <h3>Personal Details</h3>
                    <div class="content py-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">Full Name</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="hidden" name="id" value="{{ $auth->id }}">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter Full Name" value="{{ $auth->name }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter Email Address" value="{{ $auth->email }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">Phone</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street">Pin Code</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="pin_code" id="pin_code"
                                        class="form-control @error('pin_code') is-invalid @enderror"
                                        placeholder="Enter Pin Code Number" value="{{ old('pin_code') }}" required>
                                    @error('pin_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="company">Address</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <textarea name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror" cols="10" rows="5"
                                        placeholder="Enter Your Address" required> {{ old('address') }} </textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="company">Card Number</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="card_no" id="card_no"
                                        class="form-control @error('card_no') is-invalid @enderror" autocomplete="off"
                                        placeholder="Enter Card Number" required />
                                    @error('card_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">CVC</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="cvv" id="cvv"
                                        class="form-control @error('cvv') is-invalid @enderror" autocomplete="off"
                                        placeholder="Enter CVV" required />
                                    @error('cvv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">Expiration Month</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="expiry_month" id="expiry_month"
                                        class="form-control @error('expiry_month') is-invalid @enderror"
                                        autocomplete="off" placeholder="MM" required />
                                    @error('expiry_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">Expiration year</label>
                                    <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                                    <input type="text" name="expiry_year" id="expiry_year"
                                        class="form-control @error('expiry_year') is-invalid @enderror"
                                        autocomplete="off" placeholder="YYYY" required />
                                    @error('expiry_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer d-flex justify-content-between">
                        <a href="{{ route('user.cart') }}" class="btn btn-outline-secondary"><i
                                class="fa fa-chevron-left"></i>Back to Cart</a>
                        <div id="payment1">
                            <button class="form-control btn btn-success submit-button" type="submit"> Total <b>{{ $grandTotal }} </b>  &nbsp; Pay Now » </button>
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
    $(document).ready(function () {
        
        $('#userCheckOutForm').validate({ 
            rules: { 
                name: { required: true, minlength: 5, maxlength: 50,},
                email: { required: true, minlength: 10, maxlength: 50,
                    remote: { 
                        type: 'POST',
                        url: '{{ route("user.check.mail") }}',
                        data: {
                            email: function() { 
                                return $('#userCheckOutForm :input[name="email"]').val();
                            },
                            id: function() {
                                return $('#userCheckOutForm :input[name="id"]').val();
                            },
                            '_token': '{{ csrf_token() }}',
                        },
                    },
                },
                phone:      { required: true, number: true, minlength: 10,},
                pin_code:   { required: true, number: true, minlength: 6, },
                address:    { required: true, minlength: 5, },

                card_no:        { required: true, number: true,  minlength: 16,},
                cvv:            { required: true, number: true,  minlength: 3, },
                expiry_month:   { required: true, number: true,  minlength: 2, },
                expiry_year:    { required: true, number: true,  minlength: 2,},

            },
            messages: {
               name:{required:  "Full name is required",},
                email: { 
                    required:  "Email is required",
                    remote: "This email is already exists !",
                },
               phone:       {  required:"phone number is required ",},
               pin_code:    {  required:"pin code is required ",},
               address:     {  required:"phone is required ",},
         },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection