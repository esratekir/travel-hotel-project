@extends('frontend.main_master')
@section('main') 

<div class="container-fluid py-5">
  <div class="container view-trip">
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.register.step1')}}"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.register.step2')}}" class="current"><i class="fas fa-globe"></i> Location</a></li>
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
            <h3>Location</h3>
            <div class="content with-padding">
              <form method="post" action="{{route('update.guide.register.step2')}}" id="contactForm">
                @csrf 
                <div class="control-group">
                  <label>Country:</label>
                  <select name="country" id="countrySelect" class="form-control form-select">
                    <option value="" selected disabled>Choose a country</option>
                    @foreach($countries as $item)
                      <option value="{{ $item->id }}" {{ $guide_reg->country_select == $item->id ? 'selected' : ''}}>{{ $item->country}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="control-group mb-2">
                  <label>City:</label>
                  <select name="city" id="citySelect" class="form-control form-select">
                    <option value="" selected disabled>Choose a city</option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn buttons margin-top-0 margin-bottom-20">Save and Next</button>
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

<!-- Buradaki javascript kodum önce ülke seçtikten sonra o ülkeye ait şehirleri id'ye göre getirip seçmemizi sağlıyor -->
<script>
  $(document).ready(function() {
    var selectedCountryId ={{ $guide_reg->country_select == '' ? '0' : $guide_reg->country_select}} ;
    if(selectedCountryId){
      $.get("/get-cities/" + selectedCountryId, function(data) {
        $.each(data, function(index, city) {
          citySelect.append(new Option(city.name, city.id));
          if(city.id == {{ $guide_reg->city_select == '' ? '0' : $guide_reg->city_select}}){
            $("#citySelect").val(city.id).change();
          }  
        });
      });
    }
    // Ülke seçildiğinde
    $("#countrySelect").change(function() {
      var selectedCountryId = $(this).val();
      // Şehirleri getir ve ikinci select'i güncelle
      $.get("/get-cities/" + selectedCountryId, function(data) {
        var citySelect = $("#citySelect");
        citySelect.empty(); // Önceki seçenekleri temizle
        $.each(data, function(index, city) {         // 'each()' fonksiyonuyla dolaşılıp ikinci selecte eklenir.
          citySelect.append(new Option(city.name, city.id));
        });
      });
    });
  });
</script>

@endsection