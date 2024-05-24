@extends('admin.layout.master')

@section('title')
Admin / Product / Index
@endsection

@section('container')
<div class="pagetitle">
    <h1>Product</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Product</li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </nav>
</div>

@if (Session::has('message'))
<div class="alert alert-success" role="alert">
    <h5>
        {{ Session::get('message') }}
    </h5>
</div>
@endif

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{ route('admin.product.create')}}" class="btn btn-dark btn-sm"
                        style="float: right;margin-top: 25px;" data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="Add New Product">Add New Product</a>

                        <a href="{{ route('admin.product.trashed')}}" class="btn btn-primary btn-sm"
                        style="float: right;margin-top: 25px;margin-right: 7px;" data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="View Trashed Product"> View Trashed Product </a>

                    <h5 class="card-title">Product Data</h5>
                    <table class="table" id="ProductTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Image</th>
                                <th>Title</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#ProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.product.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id',"width": "5%"},
                {data: 'product_image', name: 'product_image',"width": "8%", orderable: false, searchable: false},
                {data: 'title', name: 'title',"width": "10%"},
                {data: 'category', name: 'category',"width": "10%"},
                {data: 'description', name: 'description',"width": "25%"},
                {data: 'created_at', name: 'created_at',"width": "8%", orderable: false, searchable: false},
                {data: 'updated_at', name: 'updated_at',"width": "8%", orderable: false, searchable: false},
                {data: 'product_status', name: 'product_status',"width": "5%", orderable: false, searchable: false},
                {data: 'action', name: 'action',"width": "15%", orderable: false, searchable: false},
            ]
        });
    });



    // Delete Function
    function deleteConfirmation(id) {
        event.preventDefault();
        swal.fire({
            title: "Delete?",
            icon: 'question',
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function(e) {
            if (e.value === true) {
                var url = "{{ route('admin.product.delete', ['_id_']) }}";
                var delete_url = url.replace('_id_', id);
                $.ajax({
                    url: delete_url,
                    success: function(results) {
                            $("#ProductTable").DataTable().ajax.reload();
                            location.reload();
                    },
                });
            } else {
                e.dismiss;
            }
        }, function(dismiss) {
            return false;
        })
    }

    // Change Status Function
    function changeStatusOfProduct(id) {
        event.preventDefault();
        swal.fire({
            title: "Change Status ?",
            icon: 'question',
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function(e) {

            if (e.value === true) {
                var url = "{{ route('admin.product.updateStatus', ['_id_']) }}";
                var status_url = url.replace('_id_', id);

                $.ajax({
                    url: status_url,
                    type: "post",
                    success: function(results) {
                            $("#ProductTable").DataTable().ajax.reload();
                            location.reload();
                    },
                });
            } else {
                e.dismiss;
            }
        }, function(dismiss) {
            return false;
        })
    }
</script>
@endsection