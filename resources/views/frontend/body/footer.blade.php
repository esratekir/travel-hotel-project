@php 
  $social_media = App\Models\Settings::find(1);
@endphp

@php 
  $company_settings = App\Models\Settings::find(1);
@endphp

@php 
  $site_settings = App\Models\Settings::find(1);
@endphp

<div class="foot">
  <div class="container-fluid bg-dark ">
    <div class="container footer">
      <div class="row text-white-50 pt-5 pt3">
        <div class="col-lg-3 col-md-6 mb-5 mb3">
          
            <a href="{{route('home')}}" class="navbar-brand">
              <img src="{{asset('frontend/img/logofooter.png')}}" class="w-127" alt="Logo">
            </a>
         
          <p>Discover a city with a local.</p>
          <h6 class="text-white text-uppercase mt-4 mb-3" style="letter-spacing: 5px;">Follow Us</h6>
          <div class="d-flex justify-content-start foot">
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->twitter}}"><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->facebook}}"><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
            <a class="btn btn-outline-primary btn-square" href="{{$social_media->instagram}}"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5 mb3">
          <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Our Services</h5>
          <div class="d-flex flex-column justify-content-start">
            <a class="text-white-50 mb-2" href="{{route('home')}}"><i class="fa fa-angle-right mr-2"></i>Home</a>
            <!-- <a class="text-white-50 mb-2" href="{{route('tours')}}"><i class="fa fa-angle-right mr-2"></i>Tours</a> -->
            <a class="text-white-50 mb-2" href="{{route('guides')}}"><i class="fa fa-angle-right mr-2"></i>Guides</a>
            <a class="text-white-50" href="{{route('contact')}}"><i class="fa fa-angle-right mr-2"></i>Contact</a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5 mb3">
          <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Links</h5>
          <div class="d-flex flex-column justify-content-start">
            <a class="text-white-50 mb-2" href="{{route('terms.of.use')}}"><i class="fa fa-angle-right mr-2"></i>Terms of Use</a>
            <a class="text-white-50 mb-2" href="{{route('privacy.policy')}}"><i class="fa fa-angle-right mr-2"></i>Privacy Policy</a>
            <a class="text-white-50 mb-2" href="{{route('cookies')}}"><i class="fa fa-angle-right mr-2"></i>Cookies</a>
            <a class="text-white-50 mb-2" href="{{route('security')}}"><i class="fa fa-angle-right mr-2"></i>Security</a>    
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5 mb3">
          <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Contact Us</h5>
          <p><i class="fa fa-map-marker-alt mr-2"></i>{{$company_settings->company_address}}</p>
          <p><i class="fa fa-phone-alt mr-2"></i>{{$company_settings->company_phone}}</p>
          <p><i class="fa fa-envelope mr-2"></i>{{$company_settings->company_email}}</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid bg-dark p-3 copyright" style="border-top: 1px solid rgba(256, 256, 256, .1) !important;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center mb-3 mb-md-0">
          <p class="m-0 text-white-50">{{$site_settings->copyright}}</p>
        </div>
      </div>
    </div>
  </div>
</div>
    