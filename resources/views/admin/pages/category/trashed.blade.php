@extends('admin.layout.master')

@section('title')
Admin / Category / Trashed
@endsection

@section('container')
<div class="pagetitle">
    <h1>Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Category</li>
            <li class="breadcrumb-item active">Trashed</li>
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

                    <a class="btn btn-outline-secondary btn-sm" onclick="javascript:window.location='{{ route('admin.category.index')}}';"
                    style="float: right;margin-top: 25px;" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Go Back"> Go Back </a>


                    {{-- <a href="{{ route('admin.category.create')}}" class="btn btn-danger btn-sm"
                        style="float: right;margin-top: 25px;margin-right: 7px;" data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="Add New Category"> Force Delete All </a>

                        <a href="{{ route('admin.category.create')}}" class="btn btn-primary btn-sm"
                        style="float: right;margin-top: 25px;margin-right: 7px;" data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="Add New Category"> Restore All </a> --}}


                    <h5 class="card-title"> Trashed Category Data</h5>
                    <table class="table" id="CategoryTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Image</th>
                                <th>Category Name</th>
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
        $('#CategoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.category.trashed') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id',"width": "5%"},
                {data: 'category_image', name: 'category_image',"width": "5%"},
                {data: 'category_name', name: 'category_name',"width": "10%"},
                {data: 'created_at', name: 'created_at',"width": "8%"},
                {data: 'updated_at', name: 'updated_at',"width": "8%"},
                {data: 'category_status', name: 'category_status',"width": "5%"},
                {data: 'action', name: 'action', orderable: false, searchable: false ,"width": "8%"},
            ]
        });
    });

    // restore Function
    function restoreCategory(id) {
        event.preventDefault();
        swal.fire({
            title: "Restore?",
            icon: 'question',
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function(e) {
            if (e.value === true) {
                var url = "{{ route('admin.category.restore', ['_id_']) }}";
                var delete_url = url.replace('_id_', id);
                $.ajax({
                    url: delete_url,
                    success: function(results) {
                            $("#CategoryTable").DataTable().ajax.reload();
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

    // Force Delete Function
    function forceDeleteCategory(id) {
        event.preventDefault();
        swal.fire({
            title: "Force Delete?",
            icon: 'question',
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function(e) {
            if (e.value === true) {
                var url = "{{ route('admin.category.force.delete', ['_id_']) }}";
                var delete_url = url.replace('_id_', id);
                $.ajax({
                    url: delete_url,
                    success: function(results) {
                            $("#CategoryTable").DataTable().ajax.reload();
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