@extends('admin.index')
@section('content')
<div class="content-wrapper">
            <!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admins /</span> Edit Admin Data</h4>

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
                    <form id="validate-form" method="POST" action="{{route('admins.update',$admin->id)}}" enctype="multipart/form-data">
                      @method('PUT')

                    	@csrf
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="text" name="name" value="{{$admin->name}}" id="html5-text-input" />
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="email" name="email" value="{{$admin->email}}" id="html5-email-input" />
                        </div>
                      </div>
                     
                      <div class="mb-3 row">
                        <label for="html5-password-input" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                          <input class="form-control" type="password" name="password" id="html5-password-input" />
                        </div>
                      </div>
                     
                      <div class="mb-3 row">
                        <label for="html5-range" class="col-md-2 col-form-label">profile_image</label>
                        <div class="col-md-10">
                        <input class="form-control" name="profile_image" type="file" id="formFile" />
                              <img width="8%" src="{{url('storage/'.$admin->profile_image)}}">
                        </div>
                      </div>

                       <div class="row">
                        <label for="html5-role_id-input" class="col-md-2 col-form-label">Admin Role</label>
                        <div class="col-md-10">
                          <select class="form-control" id="role_id" name="role_id">
                                @if(count($roles)) @foreach($roles as $row)
                                @if($admin->roles->isNotEmpty())
                                <option value="{{$row->id}}" @if($row->id == $admin->roles[0]->id) selected @endif>{{$row->name}}</option>
                                @else
                                <option value="{{$row->id}}" >{{$row->name}}</option>
                                @endif
                                @endforeach @endif
                            </select>
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