@extends('admin.layout.master')

@section('title')
Admin / User / Index
@endsection

@section('container')
<div class="pagetitle">
    <h1>User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">User</li>
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
                    <h5 class="card-title">Product Data</h5>
                    <table class="table" id="ProductTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
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
            paging: false,
            searching: false,
            ajax: "{{ route('admin.user.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id',"width": "5%"},
                {data: 'name', name: 'name',"width": "20%"},
                {data: 'email', name: 'email',"width": "20%"},
                {data: 'created_at', name: 'created_at',"width": "10%", orderable: false, searchable: false},
                {data: 'updated_at', name: 'updated_at',"width": "10%", orderable: false, searchable: false},
                {data: 'user_status', name: 'user_status',"width": "8%", orderable: false, searchable: false},
                {data: 'action', name: 'action',"width": "20%", orderable: false, searchable: false},
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
                var url = "{{ route('admin.user.delete', ['_id_']) }}";
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
    function changeStatusOfUser(id) {
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
                var url = "{{ route('admin.user.updateStatus', ['_id_']) }}";
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