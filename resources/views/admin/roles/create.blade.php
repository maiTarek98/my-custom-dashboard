@extends('admin.index')
@section('content')
<div class="content-wrapper">
            <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Roles /</span> Create A new role</h4>

        <div class="row">

                <div class="col-xl-12">
                  <!-- HTML5 Inputs -->
                @if(count($errors))
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

                  <div class="card mb-4">
                    <h5 class="card-header">Fill Form</h5>
                    <div class="card-body">
                    <form id="validate-form" method="POST" action="{{route('roles.store')}}" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="text" name="name" value="{{old('name')}}" id="html5-text-input" />
                        </div>
                      </div>
                                           
                      <div class="row">
                @if(count($permissions))
                @foreach($permissions as $row)
                <div class="col-md-3">
                <label>{{ Form::checkbox('permission_id[]', $row->id,old('permission_id') && in_array($row->id,old('permission_id')) ? true : false, array('class' => 'name', 'required')) }}
                {{ $row->display_name }}</label> <br/>
                </div>
                @endforeach
                @endif
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                  </form>
                    </div>
                  </div>
                </div>
    </div>
  </div>
</div>
@endsection