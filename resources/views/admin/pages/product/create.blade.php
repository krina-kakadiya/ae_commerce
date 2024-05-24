@extends('admin.layout.master')

@section('title')
Admin / Product / Create
@endsection

@section('container')
<div class="pagetitle">
    <h1>Product</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Product</li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div>

@if ($errors->any())
    <div class="col-lg-8 alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create New Product</h5>
                    <form action="{{ route('admin.product.store') }}" method="post" id="productAddForm"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-12 message">
                            <label for="inputName5" class="form-label">Product Image</label>
                            <span class="form-input-required" style="font-weight: normal;color: red;">*</span>

                            <input type="file" name="product_image[]" id="product_image"
                                value="{{ old('product_image') }}"
                                class="form-control @error('product_image') is-invalid @enderror" multiple="multiple"
                                required />

                            @error('product_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="col-md-6 message">
                            <label for="inputEmail5" class="form-label">Title</label>
                            <span class="form-input-required" style="font-weight: normal;color: red;">*</span>

                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror" required>

                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 message">
                            <label for="inputPassword5" class="form-label">Category</label>
                            <span class="form-input-required" style="font-weight: normal;color: red;">*</span>

                            <select name="category" id="category" class="form-select" aria-hidden="true">
                                <option value="" selected> Select Category </option>
                                @foreach ($categoryData as $item)
                                <option value="{{ $item['id']}}" {{ ( old('category') == $item['id'] ? "selected":"") }} > {{ $item['category_name']}}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-4 message">
                            <label for="inputCity" class="form-label">Price</label>
                            <span class="form-input-required" style="font-weight: normal;color: red;">*</span>

                            <input type="text" name="price" id="price" value="{{ old('price') }}"
                                class="form-control @error('price') is-invalid @enderror" max="999999.99" required />

                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="col-md-4 message">
                            <label for="inputState" class="form-label">Stock</label>
                            <input type="text" name="stock" id="stock" value="{{ old('stock') }}" class="form-control">

                        </div>
                        <div class="col-md-4 message">
                            <label for="inputZip" class="form-label">Shipping Fee</label>
                            <input type="text" name="shipping_fee" id="shipping_fee" value="{{ old('shipping_fee') }}"
                                class="form-control" max="999.99">
                        </div>


                        <div class="col-md-4 message">
                            <label for="inputCity" class="form-label">Discount</label>
                            <input type="text" name="discount" id="discount" value="{{ old('discount') }}"
                                class="form-control" max='100'>
                        </div>

                        <div class="col-md-8 message">
                            <label for="inputState" class="form-label"> Discount Date Range </label>
                            <input type="text" name="date_range" id="date_range" class="form-control" value="" />
                        </div>


                        <div class="col-md-12 message">
                            <label for="inputName5" class="form-label">Description</label>
                            <span class="form-input-required" style="font-weight: normal;color: red;">*</span>
                            <textarea class="form-control" id="description"
                                name="description">{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-12">
                            <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                            <div class="form-check">
                                <input type="radio" name="product_status" id="product_status" class="form-check-input"
                                    value="0" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="product_status" id="product_status" class="form-check-input"
                                    value="1">
                                <label class="form-check-label" for="gridRadios2">
                                    Inactive
                                </label>
                            </div>

                            @error('category_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror


                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-secondary"
                                onclick="javascript:window.location='{{ route('admin.product.index')}}';"> Cancel
                            </button>
                        </div>
                    </form><!-- End Multi Columns Form -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('admin/assets/ck/ckeditor.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('admin/assets/js/jquery.MultiFile.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script>
    var editorTextarea;
    ClassicEditor
            .create( document.querySelector( '#description' ) )
            .then( editor => {
                    editorTextarea = editor;
                    // console.log( editor );
            } )
            .catch( error => {
                    // console.error( error );
            } );


            jQuery('#stock').keyup(function () {  
                this.value = this.value.replace(/[^0-9]/g,''); 
            });


            $('#product_image').MultiFile({
                accept:'gif|jpg|png',
            });




    $(document).ready(function () {

        $('input[name="date_range"]').daterangepicker({
            autoUpdateInput: false,
            timePicker: true,
            locale: {
            cancelLabel: 'Clear'
            }
        });

        $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD hh:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD hh:mm:ss'));
        });

        $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


        $.validator.addMethod("ck_editor", function () {
            var content_length = editorTextarea.getData (). trim (). length;
            return content_length> 0;
            },
            "Please insert content for the page."
        );


        $('#productAddForm').validate({ 

            ignore:[],
            rules: {
                product_image: {
                    required: true,
                },
                title: {
                    required: true,
                    minlength: 8,
                    maxlength: 50,
                },
                category: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true,
                    maxlength: 9,
                    max: 999999.99,
                },
                stock: {
                    number: true,
                    maxlength: 5,
                },
                shipping_fee: {
                    number: true,
                    maxlength: 6,
                    max: 999.99,
                },
                discount: {
                    required: function(element) {
                        return $('#date_range').is(':filled');
                    },   
                    number: true,
                    maxlength: 5,
                    max: 99.99,
                },
                date_range: {
                    required: function(element) {
                        return $('#discount').is(':filled');
                    },     
                },
                
                description: {
                    ck_editor: true,
                    },
            },
            messages: {
                product_image: {
                            required: "Image is  require !",
                            extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp).",
                        },
                title: {
                            required: "Title is require !",
                        },
                category: {
                            required: "Category name require !",
                        },
                price: {
                            required : "Price is required !",
                            number: "Please enter numbers only ",
                            max: "Please enter a value less than or equal to 9,99,999.99 ",
                },
                stock: {
                    number: "Please enter numbers only ",
                },
                shipping_fee: {
                    number: "Please enter numbers only ",
                    max: "Please enter a value less than or equal to 999.99 ",

                },
                discount: {
                    required: "Please write discount percentage !",
                    number: "Please enter numbers only ",
                    max: "Please enter a discount value less than or equal to 99.99 ",
                },
                date_range: {
                            required: "Please select discount date range !",
                        },

                description: {
                            ck_editor: "Description is require",
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