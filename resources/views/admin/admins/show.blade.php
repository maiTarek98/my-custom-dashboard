@extends('admin.index')
@section('content')
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admins /</span> Show Admin Data</h4>
    <div class="row">
      <div class="col-xl-12">
       <div class="card mb-4">

        <div class="card-body">
          <dl class="row mt-2">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{$admin->name}}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{$admin->email}}</dd>

            <dt class="col-sm-3">Profile Image</dt>
            <dd class="col-sm-9"><img width="8%" src="{{url('storage/'.$admin->profile_image)}}"></dd>

            <dt class="col-sm-3">Admin Role</dt>
            <dd class="col-sm-9">{{$admin->roles()->first()->name}}</dd>

          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection