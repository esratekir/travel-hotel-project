<div class="container-fluid pb-5">
  <div class="container pt-3 conti">
    <div class="text-center mb-3 pb-3">
      <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Services</h6>
      <h1>Tours & Travel Services</h1>
    </div>
    <div class="row">
      @foreach($home_card as $item)
        <div class="col-lg-4 col-md-6 mb-3">
          <div class="service-item bg-white text-center mb-2 py-4">
            <i class="fa fa-2x {{$item->card_icon}} mx-auto mb-4"></i>
            <h5 class="mb-2">{{$item->card_title}}</h5>
            <p class="m-0">{{$item->card_subtitle}}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

