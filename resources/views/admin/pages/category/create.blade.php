@extends('admin.layout.master')

@section('title')
Admin / Category / Create
@endsection

@section('container')
<div class="pagetitle">
    <h1>Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Category</li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create New Category</h5>
                    <form action="{{ route('admin.category.store') }}" method="post" id="CategoryAddForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Image <font style="font-weight: normal;color: red;">*</font></label>
                            <div class="col-sm-10 message">
                                <input type="file" name="category_image" id="category_image"
                                    value="{{ old('category_image') }}"
                                    class="form-control @error('category_image') is-invalid @enderror" required>
                                @error('category_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Category <font style="font-weight: normal;color: red;">*</font></label>
                            <div class="col-sm-10 message">
                                <input type="text" name="category_name" id="category_name"
                                    value="{{ old('category_name') }}"
                                    class="form-control @error('category_name') is-invalid @enderror" required>
                                @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Status <font style="font-weight: normal;color: red;">*</font></legend>
                            <div class="col-sm-10 message">
                                <div class="form-check">
                                    <input type="radio" name="category_status" id="category_status"
                                        class="form-check-input" value="0" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="category_status" id="category_status"
                                        class="form-check-input" value="1">
                                    <label class="form-check-label" for="gridRadios2">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-secondary" onclick="javascript:window.location='{{ route('admin.category.index')}}';"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script>
    $(document).ready(function () {     
        $('#CategoryAddForm').validate({ 
            rules: {
                category_image: {
                    required: true,
                    extension: "jpg|jpeg|png|ico|bmp",
                },
                category_name: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                    remote: { 
                            type: 'POST',
                            url: '{{ url('admin/check/category') }}',
                            data: {
                                name: function() { 
                                    return $('#CategoryAddForm :input[name="category_name"]').val();
                                },
                                '_token': '{{ csrf_token() }}',
                            }
                        },
                },
                category_status: {
                    required: true,
                },
            },
            messages: {
                category_image: {
                            required: "Please select image",
                            extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp).",
                        },

                category_name: {
                            required: "Category name require",
                            remote: "This category is already exists !",
                        },
                        category_status: {
                            required: "please select status",
                        },

                    },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.message').append(error);
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