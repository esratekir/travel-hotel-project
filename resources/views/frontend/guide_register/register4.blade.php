@extends('frontend.main_master')
@section('main')

<div class="container-fluid py-5">
  <div class="container view-trip">
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"></div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.register.step1')}}"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.register.step2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.register.step3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.register.step4')}}"  class="current"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.register.step5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.register.step6')}}"><i class="fas fa-image"></i> Photos</a></li>
            </ul>            
          </div>
        </div>        
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Activities</h3>
            <div class="content with-padding">
              <form method="post" action="{{route('update.guide.register.step4')}}" id="contactForm">
                @csrf 
                <div class="row ml-1 mr-0">
                  @foreach($activities as $item)
                    <div class="control-group col-md-6 col-sm-12 col-12 mb-2">
                      <input class="form-check-input" name="activity[]" type="checkbox" style="filter:hue-rotate(hue(#f38630));" value="{{$item->id}}" id="flexCheck{{$item->id}}" @if(is_array($guide_reg->activity_select) && in_array($item->id, $guide_reg->activity_select)) checked @endif >
                      <label class="form-check-label mt-0" for="flexCheck{{$item->id}}">{{$item->activity_name}}</label>
                    </div>
                  @endforeach                    
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

<!-- Checkbox'lardan en az birinin seçilmesi gerektiği uyarısını veren javascript kodum -->
<script>
$(document).ready(function() {
  $('#contactForm').on('submit', function(e) {
    if (!$('input[name="activity[]"]:checked').length) {
      alert('Please select at least one!');
      e.preventDefault();
      return false;
    }
  });
});
</script>

@endsection