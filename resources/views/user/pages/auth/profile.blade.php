@extends('user.layout.master')

@section('title')
User / profile
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
            @endif
            <!-- breadcrumb-->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li aria-current="page" class="breadcrumb-item active">My Profile</li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-6">
            <div class="box">
                <h1>Change password</h1>
                <hr>
                <form action="{{ route('user.change.password')}}" method="post" id="userChangePasswordForm">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Old password</label>
                        <input type="password" name="old_password" id="old_password"
                            class="form-control @error('old_password') is-invalid @enderror"
                            placeholder="Enter Old Password" required>
                        @error('old_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="password_1">New password</label>
                        <input type="password" name="new_password" id="new_password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            placeholder="Enter New Password" required>
                        @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="password_2">Retype new password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                            placeholder="Retype New Password" required>
                        @error('new_password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div style="margin-top: 7px;color: rgb(240, 4, 24);" id="CheckPasswordMatch"></div>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save new
                            password</button>

                    </div>
                </form>
            </div>
        </div>



        <div class="col-lg-6">
            <div class="box">
                <h1>Personal details</h1>
                <hr>
                <form action="{{ route('user.profile.update')}}" method="post" id="userProfileForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="hidden" name="id" value="{{ $auth->id }}">

                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Full Name"
                            value="{{ $auth->name }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address"
                            value="{{ $auth->email }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>

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

    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#new_password_confirmation").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords does not match!");
        else
            $("#CheckPasswordMatch").html("Passwords match.");
    }

    $("#new_password_confirmation").keyup(checkPasswordMatch);

        // personal details form
        $('#userProfileForm').validate({ 
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
                                    return $('#userProfileForm :input[name="email"]').val();
                                },
                                id: function() {
                                    return $('#userProfileForm :input[name="id"]').val();
                                },
                                '_token': '{{ csrf_token() }}',
                            }
                        },
                },

            },
            messages: {
               name:{required:  "Full name is required",},
                email: {
                  required:  "Email is required",
                  remote: "This email is already exists !",
               },
               
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


        // change password form
        $('#userChangePasswordForm').validate({ 
            rules: {
                old_password:   { required: true, minlength: 6, maxlength: 20 },
                new_password:   { required: true, minlength: 6, maxlength: 20 },
                new_password_confirmation:     { required: true, minlength: 6, maxlength: 20 },

            },
            messages: {
                old_password:   { required:  "Old Password is required" },
                new_password:   { required:  "New Password is required" },
                new_password_confirmation:     { required:  "Retype new password is required "},
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