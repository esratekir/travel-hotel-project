@extends('frontend.main_master')
@section('main') 

<div class="container-fluid myprofile-wrap py-5 user-profile">
  <div class="container">
    <div class="text-center mb-3 pb-3">
      <h1>Profile Settings</h1>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>My Profile</h3>
            <div class="content with-padding">
              <form method="post" action="{{route('update.user')}}" id="contactForm" enctype="multipart/form-data">
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
                    <label>Your Name:</label>
                    <input type="text" name="name" class="form-control" value="{{$userData->name}}" required="required"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{$userData->email}}" required="required" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Phone:</label>
                    <input type="text" name="phone" class="form-control" value="{{$userData->phone}}" onkeypress="validate(event)"/>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control" value="{{$userData->username}}" required="required" />
                  </div>
                </div> 
                <div class="form-row">
                  <div class="control-group col-sm-6">
                    <label>Country:</label>
                    <select name="country" id="countrySelect" class="form-control form-select" style="width:100%!important;">
                      <option value="" selected disabled>Choose a country</option>
                      @foreach($countries as $item)
                        <option value="{{ $item->id }}" {{ $userData->country == $item->id ? 'selected' : ''}}>{{ $item->country}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="control-group col-sm-6">
                    <label>City:</label>
                    <select name="city" id="citySelect" class="form-control form-select" style="width:100%!important;">
                      <option value="" selected disabled>Choose a city</option>                              
                    </select>
                  </div>
                </div>  
                <div class="control-group">
                  <label>Profile Photo:</label>
                  <input class="form-control" name="image" type="file" id="formFile">
                </div>
                <div class="control-group">
                  <label>Message:</label>
                  <textarea class="form-control py-3 px-4" name="description" rows="2" id="message"  required="required">{{$userData->description}}</textarea>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">Save Changes</button>
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
    var selectedCountryId ={{ $userData->country == '' ? '0' : $userData->country}} ;
    if(selectedCountryId){
      $.get("/get-cities/" + selectedCountryId, function(data) {
        $.each(data, function(index, city) {
          citySelect.append(new Option(city.name, city.id));
          if(city.id == {{ $userData->city == '' ? '0' : $userData->city}}){
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

@endsection