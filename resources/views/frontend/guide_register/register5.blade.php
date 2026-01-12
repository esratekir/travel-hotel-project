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
                <li><a href="{{route('guide.register.step4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
                <li><a href="{{route('guide.register.step5')}}" class="current"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
                <li><a href="{{route('guide.register.step6')}}"><i class="fas fa-image"></i> Photos</a></li>
              </ul>            
            </div>
          </div>        
        </div>
        <div class="col-md-9 register-frm" id="menu-content">
          <div class="utf-user-profile-item">
            <div class="utf-submit-page-inner-box">
              <h3>Hourly Rate</h3>
              <div class="content with-padding">
                <form method="post" action="{{ route('update.guide.register.step5')}}" id="contactForm">
                  @csrf 
                  <div class="control-group mb-3">
                    <span>Write prices only in dollars. Just type the price you will earn at the end of the tour. We will add a commission to the prices you have written.</span>
                  </div>
                  <div class="control-group mb-3">
                    <label>Full day tour ($):</label>
                    <input type="number" name="fullday_tour" class="form-control" required="required" value="{{$guide_reg->fullday_tour}}"/>
                    <span style="font-size:14px;margin-top: 0;display: block;">Between 14:00 and 04:00</span>
                  </div>
                  <div class="control-group mb-3">
                    <label>Morning city tour ($):</label>
                    <input type="number" name="morning_city_tour" class="form-control" required="required" value="{{$guide_reg->morning_city_tour}}"/>
                    <span style="font-size:14px;margin-top: 0;display: block;">Between 09:00 and 14:00</span>
                  </div>
                  <div class="control-group mb-3">
                    <label>City tour ($):</label>
                    <input type="number" name="city_tour" class="form-control" required="required" value="{{$guide_reg->city_tour}}"/>
                    <span style="font-size:14px;margin-top: 0;display: block;">Between 12:00 and 20:00</span>
                  </div>
                  <div class="control-group mb-3">
                    <label>Night tour ($) :</label>
                    <input type="number" name="night_tour" class="form-control" required="required" value="{{$guide_reg->night_tour}}"/>
                    <span style="font-size:14px;margin-top: 0;display: block;">Between 20:00 and 04:00</span>
                  </div>
                  <div class="control-group mb-3">
                    <label>Hourly rate($) :</label>
                    <input type="number" name="price" class="form-control" required="required" value="{{$guide_reg->price}}"/>
                    <span style="font-size:14px;margin-top: 0;display: block;"></span>
                  </div>
                  <div class="control-group">
                    <label>Airport Transfer Prices ($):</label>
                    <input type="number" name="airport_transfer_price" class="form-control" required="required" value="{{$guide_reg->airport_transfer_price}}"/>                         
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

@endsection