@extends('frontend.main_master')
@section('main') 

<!-- Header Start -->
<div class="container-fluid page-header">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
      <h3 class="display-4 text-white textase">Payment</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text"><a class="text-white" href="">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text">Payment</p>
      </div>
    </div>
  </div>
</div><!-- Header End -->

<div class="container-fluid myprofile-wrap py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Pay with Card <img class="img-fluid pay-img" src="{{asset('frontend/img/tekparca-logolar-1.jpg')}}"></h3>
            <div class="content with-padding">
              <form method="post" action="" id="contactForm" enctype="multipart/form-data">
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
                  <div class="control-group col-lg-12">
                    <label>Cardholder Name:</label>
                    <input type="text" name="name" class="form-control p-4" required="required" placeholder="Cardholder Name"/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="control-group col-lg-12">
                    <label>Card Number:</label>
                    <input type="email" name="card_number" class="form-control p-4" required="required" placeholder=".... .... .... ...."/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Expiration Date:</label>
                    <input type="tel" name="expi_date" class="form-control p-4" placeholder="MM/YY" required="required"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>CVC:</label>
                    <input type="text" name="cvc" class="form-control p-4" required="required" placeholder="..."/>
                  </div>
                </div>                          
                           
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary margin-top-0 margin-bottom-20 pay-buton">Confirm</button>
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