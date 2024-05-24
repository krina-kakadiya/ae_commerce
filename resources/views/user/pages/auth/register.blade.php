@extends('user.layout.master')

@section('title')
User / Register
@endsection

@section('container')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <h1>New account</h1>
                <hr>
                <form action="{{ route('user.register')}}" method="post" id="userRegForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Full Name"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address"
                            required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password"
                            required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#userRegForm').validate({ 
            rules: {
               name: {
                  required: true,
                  minlength: 5,
                  maxlength: 50,
               },
                email: {
                    required: true,
                    minlength: 10,
                    maxlength: 50,
                    remote: { 
                            type: 'POST',
                            url: '{{ route("user.check.mail") }}',
                            data: {
                                email: function() { 
                                    return $('#userRegForm :input[name="email"]').val();
                                },
                                '_token': '{{ csrf_token() }}',
                            }
                        },
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                },
            },
            messages: {
               name:{required:  "Full name is required",},
                email: {
                  required:  "Email is required",
                  remote: "This email is already exists !",
               },
                password: {  required:"Password is required ",},
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