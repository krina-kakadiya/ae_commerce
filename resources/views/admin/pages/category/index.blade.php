@extends('admin.layout.master')

@section('title')
Admin / Category / Index
@endsection

@section('container')
<div class="pagetitle">
    <h1>Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Category</li>
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
                    <div class="dropdown" style="float: right;margin-top: 25px;margin-left:10px">
                        <a class="btn btn-dark btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">Print</a></li>
                            <li><a class="dropdown-item" href="#">Copy</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                            <li><a class="dropdown-item" href="#">Export Excel</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('admin.category.create')}}" class="btn btn-dark btn-sm"
                        style="float: right;margin-top: 25px;" data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="Add New Category"> Add New Category </a>

                    <a href="{{ route('admin.category.trashed')}}" class="btn btn-primary btn-sm"
                        style="float: right;margin-top: 25px;margin-right: 7px;" data-toggle="tooltip" rel="tooltip"
                        data-placement="top" title="Add New Category"> View Trashed Category </a>

                    <h5 class="card-title">Category Data</h5>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#CategoryTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
               // 'copy', 'csv', 'excel', 'pdf', 'print',
               {
                    extend: 'pdf',
                    columns: ':visible :not(:last-child)',
                    text: 'PDF',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5]
                    },
                },
                {
                    extend: 'print',
                    columns: ':visible :not(:last-child)',
                    text: 'Print',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                },
                {
                    extend: 'copy',
                    columns: ':visible :not(:last-child)',
                    text: 'Copy',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5]
                    },
                },
                {
                    extend: 'csv',
                    columns: ':visible :not(:last-child)',
                    text: 'CSV',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5]
                    },
                },
                {
                    extend: 'excel',
                    columns: ':visible :not(:last-child)',
                    text: 'Excel',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5]
                    },
                },
            ],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.category.index') }}",
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

    $("ul li").click(function() {
        var i = $(this).index() + 1
        var table = $('#CategoryTable').DataTable();
        if (i == 1) {
            table.button('.buttons-pdf').trigger();
        } else if (i == 2) {
            table.button('.buttons-print').trigger();
        } else if (i == 3) {
            table.button('.buttons-copy').trigger();
        } else if (i == 4) {
            table.button('.buttons-csv').trigger();
        } else if (i == 5) {
            table.button('.buttons-excel').trigger();
        }
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
                var url = "{{ route('admin.category.delete', ['_id_']) }}";
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

    // Change Status Function
    function changeStatusOfCategory(id) {
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
                var url = "{{ route('admin.category.updateStatus', ['_id_']) }}";
                var status_url = url.replace('_id_', id);

                $.ajax({
                    url: status_url,
                    type: "post",
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