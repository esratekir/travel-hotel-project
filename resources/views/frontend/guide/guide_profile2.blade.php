@extends('frontend.main_master')
@section('main') 

<div class="container-fluid py-5">
  <div class="container profil-con view-trip">
    <div class="text-center mb-3 pb-3">
      <h1>Profile Settings</h1>
    </div> 
    <div class="row main-set" > 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="clearfix"></div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.profile')}}" ><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.profile2')}}" class="current"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.profile3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.profile4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.profile5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.profile6')}}"><i class="fas fa-image"></i> Photos</a></li>
              <li><a href="{{route('guide.profile7')}}" data-target="password"><i class="fas fa-lock"></i>Change Password</a></li>
            </ul>            
          </div>
        </div>
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Location</h3>
            <div class="content with-padding">
              <form method="post" action="{{route('guide.update.profile2')}}">
                @csrf 
                <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                <div class="control-group">
                  <label>Country:</label>
                  <select name="country" id="countrySelect" class="form-control form-select">
                    <option value="" selected disabled>Choose a country</option>
                    @foreach($countries as $country)
                      <option value="{{ $country->id }}" {{ $country->id == $data->country ? 'selected' : ''}}>{{ $country->country }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="control-group mb-2">
                  <label>City:</label>
                  <select name="city" id="citySelect" class="form-control form-select">
                    <option value="" selected disabled>Choose a city</option>
                    @foreach($cities as $citi)
                      <option value="{{ $citi->id }}" {{ $citi->id == $data->city ? 'selected' : ''}}>{{ $citi->name }}</option>
                    @endforeach
                  </select>
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
  $(document).ready(function() {
    // Ülke seçildiğinde
    $("#countrySelect").change(function() {
      var selectedCountryId = $(this).val();
      // Şehirleri getir ve ikinci select'i güncelle
      $.get("/get-cities/" + selectedCountryId, function(data) {
        var citySelect = $("#citySelect");
        citySelect.empty(); // Önceki seçenekleri temizle
        $.each(data, function(index, city) {
          citySelect.append(new Option(city.name, city.id));
        });
      });
    });
  });
</script>

@endsection