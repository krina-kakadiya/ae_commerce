@extends('admin.layout.master')

@section('title')
Admin / Order / Index
@endsection

@section('container')
<div class="pagetitle">
    <h1>Order</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Order</li>
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
                    <h5 class="card-title">Order Data</h5>
                    <table class="table" id="ProductTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Pin Code</th>
                                <th>Address</th>
                                <th>Payment Method</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
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
          ajax: "{{ route('admin.order.index') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'id',"width": "5%"},
            {data: 'user_details', name: 'user_details',"width": "20%"},
            {data: 'pin_code', name: 'pin_code',"width": "10%"},
            {data: 'address', name: 'address',"width": "20%"},
            {data: 'payment_mode', name: 'payment_mode',"width": "10%"},
            {data: 'total_amount', name: 'total_amount',"width": "10%"},
            {data: 'created_at', name: 'created_at',"width": "10%", orderable: false, searchable: false},
            {data: 'order_status', name: 'user_status',"width": "10%", orderable: false, searchable: false},
            {data: 'action', name: 'action',"width": "10%", orderable: false, searchable: false},
          ]
      });

    });
    function changeStatusOfOrder(id) {
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
                var url = "{{ route('admin.order.updateStatus', ['_id_']) }}";
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