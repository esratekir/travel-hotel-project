@extends('frontend.main_master')
@section('main')

@section('title')
User Details | TRAVELER
@endsection

<!-- Blog Start -->
<div class="container-fluid rehber-detay-wrap py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 "> 
        <!-- Author Bio -->
        <div class="d-flex flex-column text-center bg-white mb-4 py-4 px-4">
          <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              @php($a = 0)
              @php($a++)
              @if(isset($users->image))
                <div class="carousel-item {{ $a == 1 ? 'active' : '' }}">
                  <img src="{{asset($users->image)}}" class="img-fluid mx-auto mb-3" style="margin-top:34px;height:300px;">
                </div> 
              @else
                <div class="carousel-item {{ $a == 1 ? 'active' : '' }}">
                  <img src="{{asset('frontend/img/no-image2.jpg')}}" class="img-fluid mx-auto mb-3" style="margin-top:34px;height:300px;">
                </div> 
              @endif          
            </div>
            
            <!-- <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
              <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
              </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
              <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
              </div>
            </a> -->
           
          </div>
          <h3 class="text-primary mb-3">{{$users->name}}</h3>
          @if(isset($users['citi']['name']))
            <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i>{{$users['citi']['name']}} / {{$users['Country']['country']}}</small><br>       
          @endif
          <p class="para"></p>
          <div class="d-flex justify-content-center">
            <h5 class="m-0"><small style="font-size: 13px;"></small></h5>
          </div>
        </div>
        <div class=" d-flex flex-column bg-white text-center br-5 mb-4 py-4 px-4">          
          <div class="d-flex justify-content-center">
            <div class="call-to" style="width: 100%;">
              <a type="button" class="btn buttons btn-block" href="{{route('my.messages.details', $users->user_id)}}"> SEND MESSAGE</a>
            </div>
          </div>
        </div>
      </div> 
      <div class="col-lg-8">
        <section class="pb-7 shadow-xs-1 position-relative z-index-1 mt-n17 mb-4" data-animated-id="2">
          <div class="container pt-17">
            <div class="row">
              <div class="bg-white col-md-12" style="padding: 30px;">
                <div class="pl-md-10 pr-md-8 py-7 titl">
                  <h2 class="fs-30 text-dark font-weight-600 lh-16 mb-0"> {{$users->name}}</h2><br>
                  <p class="mb-0 m">About Me</p><hr>
                  <p >{!! $users->description !!}</p>                       
                  <div class="row titl">
                    <div class="col-sm-6 mb-4">
                      <p class="mb-0 m"></p>                           
                    </div>
                    <div class="col-sm-6 mb-4">
                      <p class="mb-0 m"></p>                          
                    </div>
                  </div>
                  <hr class="mb-4">
                  <div class="row align-items-center">
                    <div class="col-sm-6 mb-6 mb-sm-0">
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item fs-13 text-heading font-weight-500"></li>
                        <li class="list-inline-item fs-13 text-heading font-weight-500 mr-1">
                          <ul class="list-inline mb-0">
                            <li class="list-inline-item mr-0">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                            </li>
                            <li class="list-inline-item mr-0">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                            </li>
                            <li class="list-inline-item mr-0">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                            </li>
                            <li class="list-inline-item mr-0">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                            </li>
                            <li class="list-inline-item mr-0">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                            </li>
                          </ul>
                        </li>
                        <li class="list-inline-item fs-13 text-gray-light">{{count($users->comments)}} Reviews</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="bg-white mb-3" style="padding: 30px;">
          @if(Auth::check())
            <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>            
            <form method="post" action="{{route('store.comments')}}">
              @csrf
              <input type="hidden" name="guide_id" value="{{$users->user_id}}">
              <div class="form-group">
                <label for="message">Message *</label>
                <textarea name="comment" id="message" cols="30" rows="4" class="form-control" required></textarea>
              </div>
              <div class="form-group mb-0">
                <input type="submit" value="Leave a comment" class="btn buttons font-weight-semi-bold py-2 px-3">
              </div>
            </form>
          @else
            <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>
            <div class="conta">
              <div class="contitem">
                <p class="">If you want leave a comment please login.</p>
              </div>
              <div class="contitem">
                <a type="button" class="btn buttons" data-toggle="modal" data-target="#girisModal">Login</a>
              </div>
            </div>
          @endif
        </div>
        <!-- Comment Form End -->
        <!-- Comment List Start -->
        <div class="bg-white" style="padding: 30px; margin-bottom: 30px;">
          <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">{{count($users->comments)}} Comments</h4>           
          @foreach($users->comments as $comme)           
            <div class="media mb-4" >
              @if($comme->user)
                @if(is_null($comme->user->image))
                  <img src="{{asset('frontend/img/no-image2.jpg')}}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                @else
                  <img src="{{asset($comme->user->image)}}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                @endif
                <div class="media-body">
                  <h6><a href="">{{$comme->user->name}}</a> <small><i>{{$comme->created_at->diffForHumans()}}</i></small></h6>
                  <p>{!! $comme->comment !!}</p>
                  @if(Auth::check())
                    <!-- <button class="btn btn-sm btn-outline-primary" src="javascript::void(0);" onclick="reply(this)" >Reply</button> -->
                  @endif
              @endif
              @foreach($comme->replies as $reply)
                <div class="media mt-4" @if($comme->comment_id != null) style="margin-left:40px;" @endif>
                  @if($reply->user)
                    <img src="{{asset($reply->user->image)}}" alt="Image" class="img-fluid mr-3 mt-1"style="width: 45px;">
                    <div class="media-body">
                      <h6><a href="">{{$reply->user->name}}</a> <small><i>{{$reply->created_at->diffForHumans()}}</i></small></h6>
                      <p>{!! $reply->comment !!}</p>
                      <button class="btn btn-sm btn-outline-primary" src="javascript::void(0);" onclick="reply(this)" >Reply</button>
                  @endif
                  </div>
                </div>               
              @endforeach                
            </div>
            </div> 
          @endforeach
          </div>
          <!-- Comment List End -->
          
          @if(Auth::check())
            <div class="bg-white mb-3 replyDiv" style="padding: 30px; display:none;">
              <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Reply comment</h4>
              <form method="post" action="{{route('store.comments')}}">
                @csrf
                <input type="hidden" name="guide_id" value="{{$users->user_id}}">
                @foreach($users->comments as $com)
                  <input type="hidden" name="comment_id" id="comment_id" value="{{$com->id}}">
                @endforeach
                <div class="form-group">
                  <label for="message">Message *</label>
                  <textarea name="comment" id="message2" cols="15" rows="2" class="form-control" required></textarea>
                </div>
                <div class="form-group mb-0">
                  <input type="submit" value="Reply" class="btn buttons font-weight-semi-bold py-2 px-3" >
                  <a href="javascript::void(0);" class="btn btn-danger" onClick="reply_close(this)">Close</a>
                </div>
              </form>
            </div>
          @endif         
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="membershipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></br>
        <div class="container">
          <div class="row mb-5">
            <div class="col-sm-12">
              <img src="{{asset('frontend/img/membership.png')}}" alt="" width=100%/>
            </div>
          </div>
          <div class="row">
          <div class=" align-self-center"> 
            <!-- <h5 class="intro-title"> intro title </h5>
            <h3> TITLE </h3> -->
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


<script type="text/javascript">
  function reply(caller){
    $('.replyDiv').insertAfter($(caller));
    $('.replyDiv').show();
  }
  function reply_close(caller){
    $('.replyDiv').hide();
  }
</script>

@endsection