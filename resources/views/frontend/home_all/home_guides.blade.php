<div class="mt-4 ">
  <div class="container book-top">
    <div class="text-center mb-3 pb-3">
      <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Guides</h6>
      <h1>Our Travel Guides</h1>
    </div> 
    <div class="row">
      @foreach($guides as $item)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="package-item bg-white mb-4">
            @if(Auth::check())
              <a href="{{route('guides.details', $item->username)}}">
                <img class="img-fluid" src="{{asset($item->image)}}" alt="guides_image">
              </a>
            @else
              <a  href="#" data-toggle="modal" data-target="#girisModal">
                <img class="img-fluid" src="{{asset($item->image)}}" alt="guides_image">
              </a>
            @endif             
            <div class="p-4">
              <div class="flag-img d-flex mb-2">
                @foreach($item->Language as $lang)
                  <img class=" mr-2" src="{{asset($lang->flag)}}" title = "{{$lang->language}}" alt="flag_images" width="16" height="16">
                @endforeach
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
    </div>      
  </div>
</div>