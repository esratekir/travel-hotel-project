@php 
  $destination = App\Models\Destination::limit(6)->get();
@endphp

<div class="container-fluid pb-1">
  <div class="container pt-4">
    <div class="text-center mb-3 pb-3">
      <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destination</h6>
      <h1>Explore Top Destination</h1>
    </div>
    <div class="row">
      @foreach($destination as $item)
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="destination-item position-relative overflow-hidden mb-2">
            <img class="img-fluid" src="{{asset($item->image)}}" alt="">
            <a class="destination-overlay text-white text-decoration-none" href="">
              <h5 class="text-white">{{$item->name}}</h5>
              <span>100 Tours</span>
            </a>
          </div> 
        </div>
      @endforeach
    </div>
  </div>
</div>