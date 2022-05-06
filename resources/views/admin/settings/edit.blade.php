@extends('admin.index')
@section('content')
<div class="content-wrapper">
            <!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">settings /</span> Edit setting Data</h4>

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

                    <form id="validate-form" method="POST" action="{{route('settings.update',$setting->id)}}" enctype="multipart/form-data">
                      @method('PUT')

                    	@csrf

                  <div class="nav-align-top mb-4">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-home"
                          aria-controls="navs-justified-home"
                          aria-selected="true"
                        >
                          <i class="tf-icons bx bx-cog"></i> General Setting
                          <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span>
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-profile"
                          aria-controls="navs-justified-profile"
                          aria-selected="false"
                        >
                          <i class="tf-icons bx bx-link-alt "></i> Website Links
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-messages"
                          aria-controls="navs-justified-messages"
                          aria-selected="false"
                        >
                          <i class="tf-icons bx bx-link-alt"></i> Social Links
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        <div class="mb-3 row">
                        <label for="website_name" class="col-md-2 col-form-label">website_name</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="text" name="website_name" value="{{$setting->website_name}}" id="website_name" />
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label for="address" class="col-md-2 col-form-label">address</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="text" name="address" value="{{$setting->address}}" id="address" />
                        </div>
                      </div>
                     
                      <div class="mb-3 row">
                        <label for="website_bio" class="col-md-2 col-form-label">website_bio</label>
                        <div class="col-md-10">
                          <textarea class="form-control" name="website_bio" id="website_bio" >{{$setting->website_bio}}</textarea>
                        </div>
                      </div>
                     
                      <div class="mb-3 row">
                        <label for="website_logo" class="col-md-2 col-form-label">website_logo</label>
                        <div class="col-md-10">
                        <input class="form-control" name="website_logo" type="file" id="formFile" />
                        @if($setting->website_logo)
                              <img src="{{url('storage/'.$setting->website_logo)}}">
                        @endif
                        </div>
                      </div>

                       <div class="mb-3 row">
                        <label for="websiteicon" class="col-md-2 col-form-label">website_icon</label>
                        <div class="col-md-10">
                        <input class="form-control" name="website_icon" type="file" id="formFile" />
                        @if($setting->website_icon)
                              <img src="{{url('storage/'.$setting->website_icon)}}">
                        @endif
                        </div>
                      </div>
                      </div>
                      <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                         <div class="mb-3 row">
                        <label for="email" class="col-md-2 col-form-label">email</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="email" name="email" value="{{$setting->email}}" id="email" />
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label for="phone" class="col-md-2 col-form-label">phone</label>
                        <div class="col-md-10">
                          <input required class="form-control" type="text" name="phone" value="{{$setting->phone}}" id="phone" />
                        </div>
                      </div>
                     
                      <div class="mb-3 row">
                        <label for="whatsapp_phone" class="col-md-2 col-form-label">whatsapp_phone</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control" name="whatsapp_phone" id="whatsapp_phone"  value="{{$setting->whatsapp_phone}}"/>
                        </div>
                      </div>
                     
                     
                      </div>
                      <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <div class="mb-3 row">
                        <label for="facebook_link" class="col-md-2 col-form-label">facebook_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="facebook_link" id="facebook_link" value="{{$setting->facebook_link}}"/>
                        </div>
                      </div>


                       <div class="mb-3 row">
                        <label for="twitter_link" class="col-md-2 col-form-label">twitter_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="twitter_link" id="twitter_link" value="{{$setting->twitter_link}}"/>
                        </div>
                      </div>

                       <div class="mb-3 row">
                        <label for="instagram_link" class="col-md-2 col-form-label">instagram_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="instagram_link" id="instagram_link" value="{{$setting->instagram_link}}" />
                        </div>
                      </div>
                       <div class="mb-3 row">
                        <label for="youtube_link" class="col-md-2 col-form-label">youtube_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="youtube_link" id="youtube_link" value="{{$setting->youtube_link}}"/>
                        </div>
                      </div>


                      <div class="mb-3 row">
                        <label for="telegram_link" class="col-md-2 col-form-label">telegram_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="telegram_link" id="telegram_link" value="{{$setting->telegram_link}}"/>
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label for="whatsapp_link" class="col-md-2 col-form-label">whatsapp_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="whatsapp_link" id="whatsapp_link" value="{{$setting->whatsapp_link}}"/>
                        </div>
                      </div>
                      
                       <div class="mb-3 row">
                        <label for="tiktok_link" class="col-md-2 col-form-label">tiktok_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="tiktok_link" id="tiktok_link" value="{{$setting->tiktok_link}}"/>
                        </div>
                      </div>
                      
                     <div class="mb-3 row">
                        <label for="linkedin_link" class="col-md-2 col-form-label">linkedin_link</label>
                        <div class="col-md-10">
                          <input type="url" class="form-control" name="linkedin_link" id="linkedin_link" value="{{$setting->linkedin_link}}"/>
                        </div>
                      </div>
                     
                      </div>
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