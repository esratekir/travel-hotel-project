@extends('frontend.main_master')
@section('main')

@section('title')
My Trips | TRAVELER
@endsection
 
<div class="container-fluid teams-wrap pb-5 pt-5">
  <div class="container pt-0 view-trip">
    <div>
      <p class="text-center mb-5 pp"><strong>{{count($trips)}}</strong> People are now visiting or planning to visit 
        @if(Auth::check())
          {{Auth::user()->Citi->name}}  <!--, {{Auth::user()->Citi->country->country}} -->
        @endif
      </p>
    </div>
    <div>
      <div class="row">
        @foreach($trips as $item)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="package-item bg-white mb-4">
              @if(isset($item['user']))
                <a href="{{route('local.user.details', $item['user']['username'])}}">
                  @if(isset($item['user']['image']))
                    <img class="img-fluid" src="{{asset($item['user']['image'])}}" alt="">
                  @else
                    <img class="img-fluid" src="{{asset('frontend/img/no-image2.jpg')}}" alt="">
                  @endif
                </a>
                <div class="p-3">
                  <!-- <div class="d-flex mb-2"></div> -->
                <div>
                  <a class="h5 text-decoration-none " href="">{{$item['user']['name']}}</a>
                </div>
                @if(isset($item['user']['Citi']['name']))
                  <div class="d-flex justify-content-between mt-2">
                    <small class="m-0">{{$item['user']['Citi']['name']}} / {{$item['user']['Country']['country']}}</small>
                  </div>
                @else
                  <div class="d-flex justify-content-between mt-4">
                  </div>
                @endif
                <div class="justify-content-center border-top mt-1 pt-1">
                  <small class="m-0 pt-2"><p>Looking for a local between</p></small>
                  <small class="m-0 trip-small"><i class="fa fa-map-marker-alt text-primary mr-2" style="color:black;"></i>{{date('d F,Y', strtotime($item->date_from))}} -  {{date('d F,Y', strtotime($item->date_to))}}</small>
                </div>
                <div class="border-top mt-3 pt-3">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="call-to" style="width: 100%;">
                      <!-- <a type="button" class="btn buttons btn-block btn-sm" data-toggle="modal" data-target="#membershipModal"> SEND OFFER</a> -->
                      <a type="button" class="btn buttons btn-block btn-sm" href="{{route('my.messages.details', $item['user']['user_id'])}}"> SEND MESSAGE</a>
                    </div>            
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="row">
      <div class="col-12"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="membershipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </br>
        <div class="container">
          <div class="row mb-5">
            <div class="col-sm-12">
              <img src="{{asset('frontend/img/membership.png')}}" alt="" width=100%/>
            </div>
          </div>
          <div class="row">
            <div class=" align-self-center"> 
              <p style="text-align:center"> By purchasing a traveller’s subscription you not only get to choose a like-minded local that has the same tastes and interests as you, but you also help us provide you with high-quality service! </p>           
            </div>
          </div>
          <div class="">
            <div class="MembershipPricing MembershipPricing--Desktop row">
              <div class="col-md-4">
                <div class="box" ng-click="$ctrl.pay({price: $ctrl.membershipPrice.one, duration: '1month', p: 'p1d'})">
                  <div class="header">1 Months</div>
                  <div class="text save">&nbsp;</div>
                  <div class="price">
                    <span ng-class="$ctrl.specialCurrency ? 'special' : ''" class="ng-binding">€59.99</span>/mo.
                  </div>
                  <div class="text billed ng-binding">
                    €59.99 for 1 month
                  </div>
                  <button class="Button Button--membership simple ng-isolate-scope" loader-class="Loader--blue Loader--small" sa-button-loader="$ctrl.p.p1d">
                    Subscribe
                  </button>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box" ng-click="$ctrl.pay({price: $ctrl.membershipPrice.three, duration: '3month', p: 'p3d'})">
                  <div class="header">
                    3 Months
                  </div>
                  <div class="text save">
                    Best value. <span class="ng-binding">Save 30%</span>
                  </div>
                  <div class="price">
                    <span ng-class="$ctrl.specialCurrency ? 'special' : ''" class="ng-binding">€40.00</span>/mo.
                  </div>
                  <div class="text billed ng-binding">
                    €119.99 for 3 months
                  </div>
                  <button class="Button Button--membership simple ng-isolate-scope" loader-class="Loader--blue Loader--small" sa-button-loader="$ctrl.p.p3d">
                    Subscribe
                  </button>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box" ng-click="$ctrl.pay({price: $ctrl.membershipPrice.year, duration: '12month', p: 'p12d'})">
                  <div class="header">
                    12 Months
                  </div>
                  <div class="text save">
                    Best value. <span class="ng-binding">Save 50%</span>
                  </div>
                  <div class="price">
                    <span ng-class="$ctrl.specialCurrency ? 'special' : ''" class="ng-binding">€29.17</span>/mo.
                  </div>
                  <div class="text billed ng-binding">
                    €349.99 for one year
                  </div>
                  <button class="Button Button--membership simple ng-isolate-scope" loader-class="Loader--blue Loader--small" sa-button-loader="$ctrl.p.p12d">
                    Subscribe
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>     
      </div>
    </div>
  </div>
</div>

@endsection