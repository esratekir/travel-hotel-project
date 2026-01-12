<div class="container-fluid pb-5">
  <div class="container pt-0">
    <div class="text-center mb-3 pb-3">
      <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Packages</h6>
      <h1>Perfect Tour Packages</h1>
    </div>
    <div class="row">
      @foreach($tours as $item)
        <div class="col-lg-4 col-md-6">
          <div class="package-item bg-white mb-4">
            <img class="img-fluid" src="{{asset($item->image)}}" alt="">
            <div class="p-4">
              <div class="d-flex justify-content-between mb-3">
                <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i></small>
                <small class="m-0"><i class="fa fa-calendar-alt text-primary mr-2"></i> Day</small>
                <small class="m-0"><i class="fa fa-user text-primary mr-2"></i>{{$item->person}} Person</small>
              </div>
              <a class="h5 text-decoration-none" href="{{route('tours.details',$item->id)}}">{{$item->tour_title}}</a>
              <div class="border-top mt-4 pt-4">
                <div class="d-flex justify-content-between">
                  <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6>
                  <h5 class="m-0">{{$item->price}}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>