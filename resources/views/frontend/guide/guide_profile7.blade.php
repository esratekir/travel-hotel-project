@extends('frontend.main_master')
@section('main')

<div class="container-fluid py-5">
  <div class="container profil-con view-trip">
    <div class="text-center mb-3 pb-3">
      <h1>Profile Settings</h1>
    </div> 
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="clearfix"></div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.profile')}}"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.profile2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.profile3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.profile4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.profile5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.profile6')}}"><i class="fas fa-image"></i> Photos</a></li>
              <li><a href="{{route('guide.profile7')}}"  class="current" data-target="password"><i class="fas fa-lock"></i>Change Password</a></li> 
            </ul>            
          </div>
        </div>
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Change Password</h3> 
            <div class="content with-padding">
              <form method="post" action="{{route('guide.update.profile7')}}" id="contactForm" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                <div class="form-row">
                  <div class="control-group col-sm-12">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" value="" autocomplete="new-password" required/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="control-group col-sm-12">
                    <label>Password (again):</label>
                    <input type="password" name="confirm_password" class="form-control" required/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>              
        </div>
      </div>          
    </div>
  </div>
</div>

@endsection