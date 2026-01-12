@extends('frontend.main_master')
@section('main') 

<!--
<div class="container-fluid page-header mobile-gizle">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 180px">
      <h3 class="display-4 text-white text-uppercase">Guide Register</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text-uppercase">Guide Register</p>
      </div>
    </div>
  </div>
</div>-->

<div class="container-fluid py-5">
  <div class="container view-trip">
    <div class="row main-set"> 
      <!-- Widget -->
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.register.step1')}}" class="current"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.register.step2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.register.step3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.register.step4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.register.step5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.register.step6')}}"><i class="fas fa-image"></i> Photos</a></li>
            </ul>            
          </div>
        </div>       
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Profile Settings</h3>
            <div class="content with-padding">
              <form method="post" action="{{route('update.guide.register.step1')}}" id="contactForm" enctype="multipart/form-data">
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
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required="required" value="{{$guide_reg->username}}">
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Gender:</label>
                    <select class="form-control form-select" name="gender">
                      <option value="" >-Gender-</option>
                      <option value="male" {{ $guide_reg->gender == "male" ? 'selected' : ''}}>Male</option>
                      <option value="female" {{ $guide_reg->gender == "female" ? 'selected' : ''}}>Female</option>
                    </select>
                  </div>                 
                </div>
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required="required" autocomplete="new-password"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Password (again):</label>
                    <input type="password" name="confirm_password" class="form-control" required="required" />
                  </div>
                </div>
               
                <div class="control-group">
                  <label>Profile Photo:</label>
                  <input class="form-control" name="image" type="file" id="image" required>
                </div>
                @if(isset($guide_reg->image))
                  <img src="{{ asset($guide_reg->image) }}" id="showImage" alt="200x200" width="100">
                @endif
                <div class="control-group">
                  <label>Motto:</label>
                  <input class="form-control" name="motto"  value="{{ $guide_reg->motto }}" type="text"  required>
                </div>       
                <div class="control-group">
                  <label>About Me:</label>
                  <textarea name="description"  class="form-control " rows="5" id="message"  required="required">{!! $guide_reg->description !!}</textarea>
                </div>
                <div class="row">
                  <div class="col-md-12">     
                    <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">Save and Next</button>
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
</div>


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