@extends('frontend.main_master')
@section('main')

@section('title')
Contact | TRAVELER
@endsection

<!-- Contact Start -->
<section class="contact-info-one">
  <div class="container contact-bir">
    <div class="text-center mb-3 pb-3">
      <h1 style="font-size: 26px!important;">Contact With Us</h1>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="contact-info-one__single">
          <div class="contact-info-one__icon"> 
            <img class="img-fluid mr-3" src="{{asset('frontend/img/location-pin.png')}}" style="width: 50px;"></img>
          </div>
          <!-- /.contact-info-one__icon -->
          <div class="contact-info-one__content">
            <p><strong>Address:</strong> <br>{{$company_settings->company_address}}</p>
          </div>
          <!-- /.contact-info-one__content -->
        </div>
        <!-- /.contact-info-one__single -->
      </div>
      <div class="col-lg-4">
        <div class="contact-info-one__single">
          <div class="contact-info-one__icon">
            <img class="img-fluid mr-3" src="{{asset('frontend/img/phone.png')}}" style="width: 60px;"></img>
          </div>
          <div class="contact-info-one__content">
            <p><strong>Phone:</strong> <br> Mobile: <a href="tel:+123-456-hello">{{$company_settings->company_phone}}</a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="contact-info-one__single">
          <div class="contact-info-one__icon">
            <img class="img-fluid mr-3" src="{{asset('frontend/img/mail.png')}}" style="width: 60px;">
          </div>
          <div class="contact-info-one__content">
            <p><strong>Email:</strong> <br><a href="mailto:info@tripo.com">{{$company_settings->company_email}}</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="contact-one py-5">
  <div class="container contact-iki">
    <div class="row">
      <div class="col-lg-5">
        <div class="contact-one__content">
          <div class="block-title text-left">
            <p>Contact with us</p>
            <h3>Have any Question? Feel free to contact with us.</h3>
          </div>
          <div class="d-flex justify-content-start mb-4">
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->twitter}}"><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->facebook}}"><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="{{$social_media->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
            <a class="btn btn-outline-primary btn-square" href="{{$social_media->instagram}}"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <form method="post" action="{{route('store.message')}}" id="contactForm">
          @csrf
          @if(Session::has("success"))
            <div class="alert alert-success alert-dismissible"><button type="button" class="close">&times;</button>{{Session::get('success')}}</div>
          @elseif(Session::has("failed"))
            <div class="alert alert-danger alert-dismissible"><button type="button" class="close">&times;</button>{{Session::get('failed')}}</div>
          @endif
          <div class="form-row">
            <div class="control-group col-sm-6">
              <input type="text" name="name" class="form-control p-4" placeholder="Name Surname" required="required"/>
            </div>
            <div class="control-group col-sm-6">
              <input type="email" name="email" class="form-control p-4"placeholder="Email" required="required" />
            </div>
          </div>
          <div class="form-row">
            <div class="control-group col-sm-6">
              <input type="text" name="phone" class="form-control p-4" placeholder="Phone" required="required" />
            </div>
            <div class="control-group col-sm-6">
              <input type="text" name="subject" class="form-control p-4" placeholder="Subject" required="required" />
            </div>
          </div>
          <div class="control-group">
            <textarea class="form-control py-3 px-4" name="message" rows="5" id="message" placeholder="Message" required="required"></textarea>
          </div>
          <div class="text-center">
            <button class="btn buttons py-3 px-4" type="submit" id="sendMessageButton">Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- Contact End -->

@endsection