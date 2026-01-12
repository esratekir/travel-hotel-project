@extends('frontend.main_master')
@section('main')

@section('title')
Tour Details | TRAVELER
@endsection

<!-- Header Start -->
<div class="container-fluid page-header">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
      <h3 class="display-4 text-white text-uppercase">Tour Details</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text-uppercase"><a class="text-white" href="{{route('home')}}">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text-uppercase">Tour Details</p>
      </div>
    </div>
  </div>
</div>
<!-- Header End -->

<!-- Blog Start -->
<div class="container-fluid tur-detay-wrap py-5">
  <div class="container">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-lg-8 content-wrap">
        <!-- Blog Detail Start -->
        <div class="pb-3">
          <h3 class="mt-4" >{{$tours->tour_title}}</h3>
          <div class="blog-item">
            <div class="position-relative"> 
              <img class="img-fluid br-5 w-100" src="{{asset($tours->image)}}" alt="">
            </div>
          </div>
          <h5 class="mt-4" >Tur Programı</h5>
          <section id="faqs">
            <div class="accordion mb-2" id="accordionExample">
              <?php $a = 1; ?>
                @foreach($tour_program as $country)
                  <div class="card">
                    <div class="card-header" id="headingOne{{$a}}">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne{{$a}}" aria-expanded="true" aria-controls="collapseOne">
                          <span class="d-count mr-2">{{$a}}. Gün </span> {{$country->tour_day}}  <i class="fa fa-angle-down"></i>
                        </button>
                      </h2>
                    </div>
                    <div id="collapseOne{{$a}}" class="collapse {{$a == '1' ? 'show' : ''}}" aria-labelledby="headingOne{{$a}}" data-parent="#accordionExample">
                      <div class="card-body">
                        {!! $country->tour_detail !!}
                      </div>
                    </div>
                  <?php $a++; ?>
               @endforeach
          </section>

          <h5 class="mt-4" >Fiyata Dahil Olan Hizmetler</h5>
          <ol class="list-group mb-4">
            <?php
            $text = trim($tours->fiyat_dahil);
            $textAr = explode("\n", $text);
            $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
            
            foreach ($textAr as $line) {
              echo '<li class="list-group-item">';
              echo '<i class="fa fa-check" aria-hidden="true" style="color:green;"></i> '.$line. "<br>";
              echo "</li>";
            } 
            ?>
          </ol>
          <h3 style="font-size: 18px; font-weight:bold;">Fiyata Dahil Olmayan Hizmetler</h3>
            <ol class="list-group mb-3">
              <?php
                $text = trim($tours->fiyat_dahil_degil);
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                
                foreach ($textAr as $line) {
                  echo '<li class="list-group-item">';
                  echo '<i class="fa fa-times" aria-hidden="true" style="color:red;"></i> '.$line. "<br>";
                  echo '</li>';
                } 
              ?>              
            </ol>
          </div>
          <!-- Blog Detail End -->
        </div>
        <div class="col-lg-4 sidebar-wrap mt-5 mt-lg-0">
          <div class="rezervasyon-wrap d-flex flex-column text-center bg-white br-5 mb-4 py-4 px-4">
            <h3 class="text-primary mb-3">Rezervasyon Yap</h3>
            <p>Hemen rezervasyon yapabilir veya tur ile ilgili sorularınız için whatsapptan bize yazabilirsiniz.</p>
            <div class="d-flex justify-content-center">
              <div class="call-to" style="width: 100%;">
                <button class="btn btn-danger btn-block mb-3"><i class="fas fa-check"></i> Rezervasyon Yap</button>
                <button class="btn btn-primary btn-block"><i class="fab fa-whatsapp"></i> Whatsapp</button>
              </div>
            </div>
          </div>
          <div class="row turDetaySidebar">
            <div class="col-12 mb-3">
              <div class="service-item bg-white mb-0 py-4">
                <i class="fa fa-2x fas fa-user"></i>
              <div class="text">
                <h5 class="mb-2">Kişi Başı</h5>
                <p class="m-0"><strong>{{$tours->kisi_basi}}$</strong></p>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="service-item bg-white mb-0 py-4">
              <i class="fa fa-2x fas fa-calendar-alt"></i>
              <div class="text">
                <h5 class="mb-2">Tur Tarihi</h5>
                <p class="m-0"><strong>{{$tours->tur_tarihi}}</strong></p>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="service-item bg-white mb-0 py-4">
              <i class="fa fa-2x fa-hotel"></i>
              <div class="text">
                <h5 class="mb-2">Çift Kişilik Oda</h5>
                <p class="m-0">Kişibaşı <strong>{{$tours->cift_kisilik_oda}}$</strong></p>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="service-item bg-white mb-0 py-4">
              <i class="fa fa-2x fa-bed"></i>
              <div class="text">
                <h5 class="mb-2">İlave Yatak</h5>
                <p class="m-0">Kişibaşı <strong>{{$tours->ilave_yatak}}$</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Blog End -->
@endsection