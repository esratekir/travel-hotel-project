<div class="container-fluid pb-5">
  <div class="container pt-0 yorums">
    <div class="text-center mb-3 pb-3">
      <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Testimonial</h6>
      <h1>What Say Our Clients</h1>
    </div> 
    <div class="owl-carousel testimonial-carousel">
      @foreach($clients as $item)
        <div class="text-center pb-4">
          <img class="img-fluid mx-auto" src="{{asset($item->image)}}" style="width: 100px; height: 100px;" alt="clients_image">
          <div class="testimonial-text bg-white p-4 mt-n5">
            <p class="mt-5">{!! $item->message !!}</p>
            <h5 class="text-truncate">{{$item->name}}</h5>
            <span>{{$item->job}}</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>