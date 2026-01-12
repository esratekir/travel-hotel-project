@php
  $route = Route::current()->getName();
@endphp

@php 
  $menus = App\Models\Menus::orderBy('sira', 'ASC')->get();
@endphp
<div class="position-relative nav-bar p-0">
  <div class="container position-relative p-0 px-lg-3" style="z-index: 9;">
    <nav class="navbar navbar-expand-lg  navbar-light  py-lg-0  pl-lg-3 pr-0">
      <div class="logo">
        <a href="{{route('home')}}" class="navbar-brand mr-5">
          <img src="{{asset('frontend/img/logo2.png')}}" class="w-127" alt="Logo">
        </a>
      </div>
      <div class="mobileBtn">
        @if(Auth::guest())
          <button type="button" class="navbar-toggler kullanıcıGirisBtn" data-toggle="modal" data-target="#mobileGirisModal"><i class="fas fa-sign-in-alt"></i></button>
          <button type="button" class="navbar-toggler kullanıcıGirisBtn" data-toggle="modal" data-target="#mobileKayitModal"><i class="fas fa-user"></i></button>
        @endif
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>               
      </div>             
      @if(Auth::check())                     
        <div class="dropdown text-primary taction mbl ">
          <button class="btn btn-secondary dropdown-toggle profile" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(is_null(Auth::user()->image))
              <img src="{{asset('frontend/img/no-image2.jpg')}}" alt="profile_photo"></button>
            @else
              <img src="{{asset(Auth::user()->image)}}" alt="profile_photo"></button>
            @endif
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if(Auth::user()->hasRole('user'))
              <a class="dropdown-item" href="{{route('user.profile')}}"><i class="far fa-user"></i> Profile</a>
              <a class="dropdown-item" href="{{route('my.trips')}}"><i class="far fa-map"></i> My Trips</a>
            @elseif(Auth::user()->hasRole('guide'))
              <a class="dropdown-item" href="{{route('guide.profile')}}"><i class="far fa-user"></i> Profile</a>
              <a class="dropdown-item" href="{{route('view.trips')}}"><i class="far fa-star"></i> View Trips</a>
            @endif
              <a class="dropdown-item" href="{{route('user.logout')}}"><i class="fas fa-power-off"></i> Logout</a>
          </div>
        </div>
        <div>
          <a type="button" class="btn text-primary btn-message navbar-toggler" href="{{ route('my.messages') }}">
            <i class="far fa-envelope"></i>
            @php
              $newMessagesCount = app('App\Http\Controllers\Frontend\MessagesController')->countNewMessages();
            @endphp
            @if($newMessagesCount > 0)
              <span class="badge2 float-right badge-primary">{{ $newMessagesCount }}</span>
            @endif
          </a>
        </div>
      @endif
      <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
        <div class="navbar-nav  py-0">
          @foreach($menus as $item)
            <a href="{{route($item->link)}}" class="nav-item nav-link {{ ($route == $item->link)? 'active' : '' }}">{{$item->name}}</a>
          @endforeach                
        </div>
      </div>
      <div class="nomobile">
        <div class="d-inline-flex align-items-center ">
          @if(Auth::guest())
            <button type="button" class="btn text-primary" data-toggle="modal" data-target="#girisModal">Login</button> 
            <button type="button" class="btn text-primary" data-toggle="modal" data-target="#kayitModal">Sign Up</button>
          @endif
          <div class="dropdown text-primary">
            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('frontend/img/usa.png')}}"> English</button>
            <div class="dropdown-menu notranslate" aria-labelledby="dropdownMenuButton">
              <button class="dropdown-item" onclick="doGTranslate('en|en');return false;"><img src="{{asset('frontend/img/usa.png')}}" alt="flag_usa"> English</button>
              <button class="dropdown-item" onclick="doGTranslate('en|tr');return false;"><img src="{{asset('frontend/img/turkey.png')}}" alt="flag_turkiye"> Turkish</button>
              <button class="dropdown-item" onclick="doGTranslate('en|fr');return false;"><img src="{{asset('frontend/img/france.png')}}" alt="flag_france"> Français</button>
              <button class="dropdown-item" onclick="doGTranslate('en|es');return false;"><img src="{{asset('frontend/img/spain.png')}}" alt="flag_spain"> Spanish</button>
              <button class="dropdown-item" onclick="doGTranslate('en|ru');return false;"><img src="{{asset('frontend/img/ru.png')}}" alt="flag_russia"> Russian</button>
              <button class="dropdown-item" onclick="doGTranslate('en|ar');return false;"><img src="{{asset('frontend/img/arabic.png')}}" alt="flag_arabic"> Arabic</button>
            </div> 
          </div>
          <div class="dropdown text-primary" >
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('frontend/img/usa.png')}}"> USD</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class="dropdown-item" href="#"><img src="{{asset('frontend/img/usa.png')}}"> USD</button>
              <button class="dropdown-item" href="#"><img src="{{asset('frontend/img/turkey.png')}}"> TL</button>
            </div>
          </div>           
          @if(Auth::check())
            @if(Auth::user()->hasRole('user'))
              <div>
                <a class="btn buttons" href="{{route('my.trips')}}" style="padding:3px;margin-right:5px;"><span >Create a trip</span></a>
              </div>
            @endif
            <div class="dropdown text-primary taction">
              <button class="btn btn-secondary dropdown-toggle profile" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if(is_null(Auth::user()->image))
                <img src="{{asset('frontend/img/no-image2.jpg')}}"></button>
              @else
                <img src="{{asset(Auth::user()->image)}}"></button>
              @endif
              <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                @if(Auth::user()->hasRole('user'))
                  <li><a class="dropdown-item" href="{{route('user.profile')}}"><i class="far fa-user"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="{{route('my.trips')}}"><i class="far fa-map"></i> My Trips</a></li>
                @elseif(Auth::user()->hasRole('guide'))
                  <li><a class="dropdown-item" href="{{route('guide.profile')}}"><i class="far fa-user"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="{{route('view.trips')}}"><i class="far fa-star"></i> View Trips</a></li>
                @endif
                <li><a class="dropdown-item" href="{{route('user.logout')}}"><i class="fas fa-power-off"></i> Logout</a></li>
              </ul>
            </div>
            <div>
              <a type="button" class="btn text-primary btn-message" href="{{ route('my.messages') }}">
                <i class="far fa-envelope"></i>
                @php
                  $newMessagesCount = app('App\Http\Controllers\Frontend\MessagesController')->countNewMessages();
                @endphp
                @if($newMessagesCount > 0)
                  <span class="badge2 float-right badge-primary">{{ $newMessagesCount }}</span>
                @endif
              </a>
            </div>                       
          @endif
        </div>
      </div>
    </nav> 
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dilModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Language</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dropdown text-primary notranslate">
          <button class="btn btn-secondary btn-block dropdown-toggle text-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('frontend/img/usa.png')}}" alt="flag_usa"> English</button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" onclick="doGTranslate('en|en');return false;"><img src="{{asset('frontend/img/usa.png')}}" alt="flag_usa"> English</button>
            <button class="dropdown-item" onclick="doGTranslate('en|tr');return false;"><img src="{{asset('frontend/img/turkey.png')}}" alt="flag_turkiye"> Turkish</button>
            <button class="dropdown-item" onclick="doGTranslate('en|fr');return false;"><img src="{{asset('frontend/img/france.png')}}" alt="flag_france"> Français</button>
            <button class="dropdown-item" onclick="doGTranslate('en|es');return false;"><img src="{{asset('frontend/img/spain.png')}}" alt="flag_spain"> Spanish</button>
            <button class="dropdown-item" onclick="doGTranslate('en|ru');return false;"><img src="{{asset('frontend/img/ru.png')}}" alt="flag_russia"> Russian</button>
            <button class="dropdown-item" onclick="doGTranslate('en|ar');return false;"><img src="{{asset('frontend/img/arabic.png')}}" alt="flag_arabic"> Arabic</button>
          </div>
        </div>
        <div class="dropdown text-primary mt-3">
          <button class="btn btn-secondary btn-block dropdown-toggle text-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('frontend/img/turkey.png')}}"> TL</button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" href="#"><img src="{{asset('frontend/img/turkey.png')}}"> TL</button>
            <button class="dropdown-item" href="#"><img src="{{asset('frontend/img/usa.png')}}"> USD</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn buttons btn-block">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mobileGirisModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="mobilegirisTab1" data-toggle="tab" data-target="#mobilegirisBox1" type="button" role="tab" aria-controls="mobilegirisBox1" aria-selected="true">Traveller Login</button>
            <button class="nav-link" id="mobilegirisTab2" data-toggle="tab" data-target="#mobilegirisBox2" type="button" role="tab" aria-controls="mobilegirisBox2" aria-selected="false">Guide Login</button>
          </div>
        </nav>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="tab-content" id="nav-tabContent3">
        <div class="tab-pane fade show active" id="mobilegirisBox1" role="tabpanel" aria-labelledby="mobilegirisTab1">
          <div class="modal-body">     
            <form method="post" action="{{route('user.login')}}" id="addForm2">
              @csrf
              <div class="form-group">
                <div class="d-flex align-items-center" style="justify-content:center;">
                  <div class="col-lg-12">
                    <input type="text" name="email" placeholder="Email/Username" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center" style="justify-content:center;">
                  <div class="col-lg-12">
                    <input type="password" name="password" placeholder="Password" class="form-control" required autocomplete="new-password">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn buttons button1"><i class="fas fa-sign-in-alt"></i> Login</button>
              </div>
              <div class="row pb-3 border-bott">
                <div class="col-lg-6 col-6">
                  <div class="switch-left"><a href="#" data-toggle="modal" data-target="#forgotPasswordModal"> Forgot Password</a></div>
                </div>
                <div class="col-lg-6 col-6">
                  <div class="switch"><a href="#" data-toggle="modal" data-target="#mobileKayitModal" > Sign Up!</a></div>
                </div>          
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('google.auth')}}" type="button" class="btn button1 google-btn"><img class="google-img" src="{{asset('frontend/img/googlelogo.png')}}"> Login With Google </a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('facebook.auth')}}" type="button" class="btn button1 facebook-btn"><img class="facebook-img" src="{{asset('frontend/img/facebook.jpg')}}"> Login With Facebook </a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('vkontakte.auth')}}" type="button" class="btn button1 vkontakte-btn"><img class="vkontakte-img" src="{{asset('frontend/img/vk_logo.png')}}"> Login With VKontakte </a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="tab-pane fade" id="mobilegirisBox2" role="tabpanel" aria-labelledby="mobilegirisTab2">
          <div class="modal-body">
            <form method="post" action="{{route('user.login')}}">
              @csrf
              <div class="form-group">
                <div class="d-flex align-items-center" style="justify-content:center;">
                  <div class="col-lg-12">
                    <input type="text" name="email" placeholder="Email/Username" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center" style="justify-content:center;">
                  <div class="col-lg-12">
                    <input type="password" name="password" placeholder="Password" class="form-control" required autocomplete="new-password">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn buttons button1"><i class="fas fa-sign-in-alt"></i> Login</button>
              </div>
              <div class="row pb-3">
                <div class="col-lg-6 col-6">
                  <div class="switch-left"><a href="#" data-toggle="modal" data-target="#forgotPasswordModal"> Forgot Password</a></div>
                </div>
                <div class="col-lg-6 col-6">
                  <div class="switch"><a href="#" data-toggle="modal" data-target="#mobileKayitModal" > Sign Up!</a></div>
                </div>          
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mobileKayitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="mobilekayitTab1" data-toggle="tab" data-target="#mobilekayitBox1" type="button" role="tab" aria-controls="mobilekayitBox1" aria-selected="true">SignUp Traveller</button>
            <button class="nav-link" id="mobilekayitTab2" data-toggle="tab" data-target="#mobilekayitBox2" type="button" role="tab" aria-controls="mobilekayitBox2" aria-selected="false">SignUp Guide</button>
          </div>
        </nav>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="tab-content" id="nav-tabContent1">
        <div class="tab-pane fade show active" id="mobilekayitBox1" role="tabpanel" aria-labelledby="kayitTab1">
          <div class="modal-body">
            <form method="post" action="{{route('user.register')}}">
              @csrf 
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label class="col-form-label d-flex">Name:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="text" name="name" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label for="message-text" class="col-form-label d-flex">Password:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="password" name="password" class="form-control" required autocomplete="new-password">
                  </div>
                  @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label for="message-text" class="col-form-label d-flex">Email:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="email" name="email" class="form-control" required>
                  </div>
                </div>
                @if ($errors->has('email'))
                  <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label for="message-text" class="col-form-label d-flex">Username:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="text" name="username" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-bott">
                <button type="submit" class="btn buttons">Sign Up</button>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('google.auth')}}" type="button" class="btn button1 google-btn"><img class="google-img" src="{{asset('frontend/img/googlelogo.png')}}"> Signup With Google </a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('facebook.auth')}}" type="button" class="btn button1 facebook-btn"><img class="facebook-img" src="{{asset('frontend/img/facebook.jpg')}}"> Signup With Facebook </a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{route('vkontakte.auth')}}" type="button" class="btn button1 vkontakte-btn"><img class="vkontakte-img" src="{{asset('frontend/img/vk_logo.png')}}"> Signup With VKontakte </a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="tab-pane fade  " id="mobilekayitBox2" role="tabpanel" aria-labelledby="mobilegirisTab2">
          <div class="modal-body">
            <form method="post" action="{{route('guide.register')}}">
              @csrf 
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label class="col-form-label d-flex">Name:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="text" name="name" value="{{ $guide_reg->name ?? '' }}" class="form-control" required>
                  </div>
                </div>
              </div> 
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label for="message-text" class="col-form-label d-flex">Email:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="email" name="email" value="{{ $guide_reg->email ?? '' }}" class="form-control" required>
                  </div>
                </div>
                @if ($errors->has('email'))
                  <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-3">
                    <label for="message-text" class="col-form-label d-flex">Phone:</label>
                  </div>
                  <div class="col-lg-9">
                    <input type="text" name="phone" value="{{ $guide_reg->phone ?? '' }}" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn buttons">Sign Up</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





