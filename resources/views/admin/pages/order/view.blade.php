@extends('admin.layout.master')

@section('title')
Admin / Order / View
@endsection

@section('container')
<div class="pagetitle">
  <h1>Order</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Order</li>
      <li class="breadcrumb-item active">View</li>
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
          <a href="{{ URL::previous() }}" class="btn btn-dark btn-sm" style="float: right;margin-top: 25px;"
            data-toggle="tooltip" rel="tooltip" data-placement="top" title="Go Back">Go Back</a>

          <h5 class="card-title">Order Details Data</h5>
          <table class="table" id="ProductTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Product Image</th>
                <th>Product Details</th>
                <th>Quantity</th>
                <th>Price </th>
                <th>Discount</th>
                <th>Total</th>
                <th>Status</th>
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

    var id  = "{{ $id }}";
    $('#ProductTable').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        ajax:{
          url: '/admin/order/view/'+id,
        },
        columns: [
          {data: 'DT_RowIndex', name: 'id',"width": "4%"},
          {data: 'product_image', name: 'product_image',"width": "10%"},
          {data: 'product_details', name: 'product_details',"width": "20%"},
          {data: 'quantity', name: 'quantity',"width": "10%"},
          {data: 'price', name: 'price',"width": "10%"},
          {data: 'discount', name: 'discount',"width": "10%"},
          {data: 'total_amount', name: 'total_amount',"width": "10%"},
          {data: 'order_detail_status', name: 'order_detail_status',"width": "10%"},

        ]
    });
  });

  function changeStatusOfOrderDetail(id) {
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
                var url = "{{ route('admin.order.detail.updateStatus', ['_id_']) }}";
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