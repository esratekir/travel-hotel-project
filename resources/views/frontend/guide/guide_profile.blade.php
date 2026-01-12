@extends('frontend.main_master')
@section('main') 

<!-- 
<div class="container-fluid page-header mobile-gizle">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 180px">
      <h3 class="display-4 text-white text-uppercase">Guide Profile</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text-uppercase">Guide Profile</p>
      </div>
    </div>
  </div>
</div> -->

<div class="container-fluid py-5">
  <div class="container profil-con view-trip">
    <div class="text-center mb-3 pb-3">
      <h1>Profile Settings</h1>
    </div>
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
          <div class="sidebar margin-top-20">
            <div class="user-smt-account-menu-container">
              <ul class="user-account-nav-menu" id="">
                <li><a href="{{route('guide.profile')}}" class="current" data-target="profile"><i class="far fa-user"></i> Profile Settings</a></li>
                <li><a href="{{route('guide.profile2')}}" data-target="location"><i class="fas fa-globe"></i> Location</a></li>
                <li><a href="{{route('guide.profile3')}}" data-target="languages"><i class="fas fa-language"></i> Languages</a></li>
                <li><a href="{{route('guide.profile4')}}" data-target="activities"><i class="fas fa-glass-cheers"></i> Activities</a></li>
                <li><a href="{{route('guide.profile5')}}" data-target="rate"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
                <li><a href="{{route('guide.profile6')}}" data-target="photos"><i class="fas fa-image"></i> Photos</a></li>
                <li><a href="{{route('guide.profile7')}}" data-target="password"><i class="fas fa-lock"></i>Change Password</a></li>
              </ul>            
            </div>
          </div>       
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Profile Settings</h3>
            <div class="content with-padding pro-in">
              <form method="post" action="{{route('guide.update.profile1')}}" enctype="multipart/form-data">
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
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Your Name:  </label>
                    <input type="text" name="name" class="form-control" value="{{$userData->name}}" required="required"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{$userData->email}}" required="required"/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Phone:</label>
                    <input type="text" name="phone" class="form-control" value="{{$userData->phone}}" onkeypress="validate(event)"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Gender:</label>
                    <select class="form-control form-select" name="gender">
                      <option selected="{{$userData->gender}}"></option>
                      <option value="male" {{ $userData->gender == "male" ? 'selected' : ''}}>Male</option>
                      <option value="female" {{ $userData->gender == "female" ? 'selected' : ''}}>Female</option>
                    </select>
                  </div>
                </div>
                
                <div class="control-group">
                  <label>Profile Photo:</label>
                  <input class="form-control" name="image" id="image" type="file" id="formFile" src="{{asset($userData->image)}}">
                </div>

                @if(isset($userData->image))
                  <img src="{{ asset($userData->image) }}" id="showImage" alt="200x200" width="100" class="mt-2 mb-1">
                @endif

                <div class="control-group">
                  <label>Motto:</label>
                  <input class="form-control" name="motto" type="text" value="{{$userData->motto}}"  required>
                </div>

                <div class="control-group">
                  <label>About Me:</label>
                  <textarea name="description" class="form-control py-3 px-4" rows="5" id="message"  required="required">{!! $userData->description !!}</textarea>
                </div>
                <div class="control-group">
                  <span class="d-block mt-3" style="font-size:12px">By clicking Save and Continue, you agree to our Terms of Service, Policies and Cookies Policy. You may receive SMS Notifications from us and can opt out any time.</span>
                </div>

                <div class="row mt-2">
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

<script>
  function validate(evt) {
  var theEvent = evt || window.event;
  // Handle paste
  if (theEvent.type === 'paste') {
    key = event.clipboardData.getData('text/plain');
  } else {
    // Handle key press
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\+/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });
  });
</script>

@endsection