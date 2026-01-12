<div class="container-fluid p-0">
  <div id="header-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      @php($a = 0)
      @foreach($slider as $item)
        @php($a++)
        <div class="carousel-item {{ $a == 1 ? 'active' : '' }}">
          <img class="w-100" src="{{asset($item->home_image)}}" alt="slider_images">
          <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <div class="p-3" style="max-width: 900px;">
              <h4 class="text-white text-uppercase mb-md-3">{{$item->sub_title}}</h4>
              <h1 class="display-3 text-white mb-md-4">{{$item->title}}</h1>
            </div>
          </div>          
        </div>
      @endforeach
    </div>
    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
      <div class="btn btn-dark" style="width: 45px; height: 45px;">
        <span class="carousel-control-prev-icon mb-n2"></span>
      </div>
    </a>
    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
      <div class="btn btn-dark" style="width: 45px; height: 45px;">
        <span class="carousel-control-next-icon mb-n2"></span>
      </div>
    </a>
  </div>
</div>
<div class=" booking">
  <form method="get" action="{{route('guides')}}" class="nosubmit">
    <div class=" ktu">           
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-8 kutu">
          <div class="mb-3 mb-md-0">
            <input class="nosubmit" type="text" name="city" id="txtSearch" placeholder="Where next?" autocomplete="off" style="width: 100%;">
          </div>
        </div>
        <div class="col-md-4">
          <button class="btn btn-block buttons book-but" type="submit" style="border-radius: 0; width: 50%;">Search</button>
        </div>
      </div>
      <ul class="list-group" id="cityList">
        @foreach($cities as $item)
          <li id="1" class="list-group-item city-item" style="display: none;">
            <a href="#" class="city-link">{{ $item->name }}</a>
          </li>
        @endforeach
      </ul>
    </div>     
  </form>
  <p class="Intro-topDestinations mt-2 d-flex  align-items-center justify-content-center">
    <a class="Link text-white mr-1"><strong>Top Destinations: </strong></a>
    <a class="Link text-white mr-1" href=""> Paris, </a>
    <a class="Link text-white mr-1" href=""> İstanbul, </a>
    <a class="Link text-white mr-1" href=""> Barcelona, </a>
    <a class="Link text-white mr-1" href=""> Tbilisi, </a>
    <a class="Link text-white" href=""> Kiev</a>
  </p>              
</div>
                        


