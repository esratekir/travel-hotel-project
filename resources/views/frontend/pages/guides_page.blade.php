@extends('frontend.main_master')
@section('main')

@section('title')
Guides | TRAVELER
@endsection

<!-- Header Start -->
<div class="container-fluid page-header page-header-search">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center photo-min">
      <!-- <h3 class="display-4 text-white text-uppercase">Guides</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text-uppercase"><a class="text-white" href="{{route('home')}}">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text-uppercase">Guides</p>
      </div> -->
    </div>
  </div>
</div>
<!-- Header End -->

<!-- Booking Start -->
<div class="container-fluid booking2 mt-5 pb-0">
  <div class="container pb-5">
    <form method="get" action="{{route('guides')}}"> 
      <div class="bg-light shadow">
        <div class="row align-items-center ktu2">
          <div class="col-md-3 mabu">
            <input class="nosubmit form-control" type="text" name="city" id="txtSearch" value="{{ request('city') }}" placeholder="Where next?" autocomplete="off">                    
          </div>
          <div class="col-md-2 ">
            <input type="range" name="price" class="form-range" min="0" max="250" value="{{ request('price', 250) }}" step="1" id="customRange3" style="">
            <p id="selectedRange">Price Range: ${{ request('price', 250) }}</p>
          </div>
          <div class="col-md-2 mabu">
            <select class="form-control form-select" name="language">
              <option value="{{null}}">Languages</option>
              @foreach($languages as $item)
                <option value="{{$item->id}}" {{ request()->get('language') == $item->id ? 'selected' : ''}}>{{$item->language}} ({{$item->guide_langu_count}})</option>
              @endforeach
            </select>         
          </div>
          <div class="col-md-2 mabu">
            <select class="form-control form-select" name="gender">
              <option value="{{null}}" >Gender</option>
              <option value="male" {{ request()->get('gender') == 'male' ? 'selected' : ''}}>Male</option>
              <option value="female" {{ request()->get('gender') == 'female' ? 'selected' : ''}}>Female</option>
            </select>
          </div>
          @if(Auth::check())
            <div class="col-md-1 male">
              <input class="form-check-input " name="online_only" type="checkbox" value="online" style="filter: hue-rotate(170deg);"  id="flexCheck" {{ request()->get('online_only') == 'online' ? 'checked' : '' }}>
              <label class="form-check-label mt-0 " for="flexCheck">Online</label>
            </div>
            <div class="col-md-2 mabu2">
              <button class="btn buttons btn-block btn-sm" type="submit"><i class="fas fa-search-location mr-1"></i> Search</button>
            </div>
          @else
            <div class="col-md-3 mabu">
              <button class="btn buttons btn-sm" type="submit"><i class="fas fa-search-location mr-1"></i> Search</button>
            </div>
          @endif
          <ul class="list-group" id="cityList">
            @foreach($cities as $item)
              <li id="1" class="list-group-item city-item" style="display: none;">
                <a href="#" class="city-link">{{ $item->name }}</a>
              </li>
            @endforeach
          </ul> 
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Booking End -->

<!-- Team Start -->
<div class="container-fluid teams-wrap pb-5">
  <div class="container pt-0" style="transition:padding-top 0.3s ease;">
    @if(count($guides) > 0)
      <div class="text-center mb-3 pb-3 pt-5">
        <h1>Our Travel Guides</h1>
      </div>
      <div class="row">
        @foreach($guides as $item)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="package-item bg-white mb-4">
              @if(Auth::check())
                <a href="{{route('guides.details', $item->username)}}">
                  <img class="img-fluid" src="{{asset($item->image)}}" alt="guide_image">
                </a>
              @else
                <a href="#" data-toggle="modal" data-target= "#girisModal">
                  <img class="img-fluid" src="{{asset($item->image)}}" alt="guide_image">
                </a>
              @endif
              <div class="p-3">
                <div class="d-flex mb-2">
                  @foreach($item->Language as $lang)
                    <img class="mr-2" src="{{asset($lang->flag)}}" title="{{$lang->language}}" alt="flags" width="16" height="16">
                  @endforeach
                  @if(Auth::check())
                    @if($item->last_seen >= now()->subMinutes(5))
                      <small style="margin-left:auto;margin-right:0;color:#7AB730;"><span class="noti-online"></span> Online</small>
                    @else
                      <small style="margin-left:auto;margin-right:0;color:#d72c1f;"><span class="noti-offline"></span> Offline</small>
                    @endif
                  @endif
                </div>
                @if(Auth::check())
                  <a class="h5 text-decoration-none mb-2" href="{{route('guides.details', $item->username)}}">{{$item->name}}</a>
                @else
                  <a class="h5 text-decoration-none mb-2" href="#" data-toggle="modal" data-target="#girisModal">{{$item->name}}</a>
                @endif
                <div class="d-flex justify-content-between mt-2">
                  <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i>{{$item['citi']['name']}} / {{$item['Country']['country']}}</small>
                </div>
                <div class="border-top mt-3 pt-3">
                  <div class="d-flex align-items-center justify-content-between">
                    <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i> {{count($item->comments)}} <small> Reviews</small></h6>
                    <h5 class="m-0">${{$item->price}}<small style="font-size: 13px;">/h</small></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
    @else
      <section id="pageForGuides" >       
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <div class="title-h2 mt-4">Become a local guide <br> </div>
                <ul>
                  <li>
                    <span>Create your profile</span>
                    <p>Meet local people and get insider tips from a local who is passionate about the country and its culture, cuisine and history.</p>
                  </li>
                  <li>
                    <span>Come up with recommendations</span>
                    <p>Find unique places to visit and things to do in Turkiye.</p>
                  </li>
                  <li>
                    <span>Became popular</span>
                    <p>Get in-depth knowledge about Turkiye culture, traditions, history, cuisine, and nature from a local expert.</p>
                  </li>
                </ul>
              </div>
              <div class="col-lg-5 mt-4 mb-5">
                <div class="card border-0">
                  <div class="card-header bg-primary text-center p-4">
                    <h4 class="text-white m-0">Sign Up Now</h4>
                  </div>
                  <div class="card-body rounded-bottom bg-white  home-kayit">
                    <form method="post" action="{{ route('guide.register')}}">
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
                      <div class="form-group">
                        <div class="d-flex align-items-center">
                          <div class="col-lg-1">
                            <i class="fas fa-user "></i>
                          </div>
                          <div class="col-lg-11">
                            <input type="text" name="name" value="{{ $guide_reg->name ?? '' }}" class="form-control" placeholder="Your name" required="required">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex align-items-center">
                          <div class="col-lg-1">
                            <i class="fas fa-envelope "></i>
                          </div>
                          <div class="col-lg-11">
                            <input type="email" name="email" value="{{ $guide_reg->email ?? '' }}" class="form-control" placeholder="Your email" required="required">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex align-items-center">
                          <div class="col-lg-1">
                            <i class="fas fa-phone-alt "></i>
                          </div>
                          <div class="col-lg-11">
                            <input type="text" name="phone" value="{{ $guide_reg->phone ?? '' }}" class="form-control" placeholder="+01234567890" required="required" maxlength="15" onkeypress="validate(event)">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex align-items-center">
                          <div class="col-lg-1"></div>
                          <div class="col-lg-11">
                            <button class="btn buttons btn-block but-kayit" type="submit" style="padding:7px;">Register</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>   
    @endif
    </div>
    <div class="row">
      <div class="col-12"></div>
    </div>
  </div>
</div>

<!-- Range Input 'un çalışmasını sağlayan javascript kodu. Başlangıç ve bitiş değerlerini gösterip. range'i kaydırdığımızda göstermeyi sağlıyor -->
<script>
  const priceRange = document.getElementById("customRange3");
  const selectedRange = document.getElementById("selectedRange");
  priceRange.addEventListener("input", function() {
    const minPrice = 0;
    const maxPrice = 250;
    const selectedMin = parseFloat(priceRange.value);
    const selectedMax = selectedMin + parseFloat(priceRange.step); 
    selectedRange.textContent = `Price Range: $${selectedMin}`;
  });
</script>

<!-- Booking işleminde inputta arama gerçekleştirebilmemizi sağlayan script kodu -->
<script>
  function compareStrings(str1, str2) {
    return str1.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
               .toLowerCase()
               .includes(str2.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase());
  };

  $(document).ready(function() {
    $(".city-link").click(function() {
        var cityName = $(this).text();
        $("#txtSearch").val(cityName);
        $("#cityList").hide();
    });

    $("#txtSearch").on('keyup', function() {
        var search = $(this).val().trim();
        var cityList = $("#cityList");
        if (search === "") {
          cityList.hide();
          return;
        }
        cityList.show();
        cityList.find(".city-item").each(function() {
          var cityName = $(this).find(".city-link").text();
          var listItem = $(this);
          if (compareStrings(cityName, search)) {
            listItem.show();
          } else {
            listItem.hide();
          }
        });
        cityList.find(".city-item:visible").css("border-radius", "0");
        cityList.find(".city-item:visible:first").css("border-top-left-radius", "0");
        cityList.find(".city-item:visible:last").css("border-bottom-left-radius", "0");
        cityList.find(".city-item:visible:last").css("border-bottom-right-radius", "0");
    });
  });


$(document).ready(function() {
    $(".city-link").click(function() {
        var cityName = $(this).text();  
        $("#txtSearch").val(cityName); 
        $("#cityList").hide();  
    });
});
</script>

@endsection