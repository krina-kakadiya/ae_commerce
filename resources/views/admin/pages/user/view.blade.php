@extends('admin.layout.master')

@section('title')
Admin / User / View
@endsection

@section('container')
<div class="pagetitle">
  <h1>User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">User</li>
      <li class="breadcrumb-item active">View</li>

    </ol>
  </nav>
</div>


<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <a href="{{ URL::previous() }}" class="btn btn-dark btn-sm" style="float: right;margin-top: 25px;"
            data-toggle="tooltip" rel="tooltip" data-placement="top" title="Go Back">Go Back</a>

          <h5 class="card-title">User Details</h5>
          <p></p>
          <br>


          <table class="table table-bordered">
            <tbody>
              <tr>
                <th scope="row">Name</th>
                <td>{{ $user->name }} </td>
              </tr>
              <tr>
                <th scope="row">Eamil</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th scope="row">Created Date</th>
                <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-M-Y')}}</td>
              </tr>
              <tr>
                <th scope="row">Updated Date</th>
                <td>{{ Carbon\Carbon::parse($user->updated_at)->format('d-M-Y')}}</td>
              </tr>


              <tr>
                <th scope="row">Status</th>
                <td>
                  <a data-toggle="tooltip" rel="tooltip" data-placement="top" title="Status">
                    <span @if($user->user_status == 0)? class="badge rounded-pill bg-success" @else
                      class="badge
                      rounded-pill bg-danger" @endif  style="cursor: pointer;">
                      @if($user->user_status == 0) Active @else Inactive @endif </span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection