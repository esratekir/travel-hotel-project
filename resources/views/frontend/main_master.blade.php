<!DOCTYPE html>
<html lang="en">
  @php 
  $settings = App\Models\Settings::find(1);
  @endphp
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" >
    <meta name="keywords" content="{{$settings->site_description}}" >
    <meta name="description" content="{{$settings->site_keywords}}" >

    <!-- Favicon -->
    <link href="{{asset($settings->favicon)}}" rel="icon">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/css/messages.css')}}" rel="stylesheet">
    
    <!--toastr messages css-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js" integrity="sha512-tYefFVRPVQIZMI0CqDcVLTti7ajlO/l9qk1s8eswWduldmconu2sKCdYQOTRkn/f2k3eupgRbFzf55bM2moH8Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{$settings->taghead_kod}}
  </head>
  <body class="search-kutu">

    {{$settings->tagbody_kod}}
   
    <!-- Navbar Start -->
    @include('frontend.body.header')
    <!-- Navbar End -->

    <main id="main">
      @yield('main')
    </main>

    <!-- Footer Start -->
    @include('frontend.body.footer')
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg buttons btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- girişyap modal -->
    <div class="modal fade" id="girisModal" tabindex="-1"  aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
          <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="girisTab1" data-toggle="tab" data-target="#girisBox1" type="button" role="tab" aria-controls="girisBox1" aria-selected="true">Traveller Login</button>
                <button class="nav-link" id="girisTab2" data-toggle="tab" data-target="#girisBox2" type="button" role="tab" aria-controls="girisBox2" aria-selected="false">Guide Login</button>
              </div>
            </nav>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="tab-content" id="nav-tabContent3">
            <div class="tab-pane fade show active" id="girisBox1" role="tabpanel" aria-labelledby="girisTab1">
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
                      <div class="switch"><a href="#" data-toggle="modal" data-target="#kayitModal" > Sign Up!</a></div>
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
                      <a href="{{route('vkontakte.auth')}}" type="button" class="btn button1 vkontakte-btn"><img class="vkontakte-img" src="{{asset('frontend/img/vk_logo.png')}}">  Login With VKontakte </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          
            <div class="tab-pane fade" id="girisBox2" role="tabpanel" aria-labelledby="girisTab2">
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
                      <div class="switch"><a href="#" data-toggle="modal" data-target="#kayitModal" > Sign Up!</a></div>
                    </div>          
                  </div> 
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kayıtol modal -->
    <div class="modal fade" id="kayitModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="kayitTab1" data-toggle="tab" data-target="#kayitBox1" type="button" role="tab" aria-controls="kayitBox1" aria-selected="true">Sign Up</button>
                <button class="nav-link" id="kayitTab2" data-toggle="tab" data-target="#kayitBox2" type="button" role="tab" aria-controls="kayitBox2" aria-selected="false">Sign Up As A Guide</button>
              </div>
            </nav>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="tab-content" id="nav-tabContent1">
            <div class="tab-pane fade show active" id="kayitBox1" role="tabpanel" aria-labelledby="kayitTab1">
              <div class="modal-body">
                <form method="post" action="{{route('user.register')}}">
                  @csrf 
                  <div class="form-group">
                    <div class="d-flex align-items-center">
                      <div class="col-lg-3">
                        <label class="col-form-label d-flex">Name:</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="name" class="form-control" >
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
                      <a href="{{route('google.auth')}}" type="button" class="btn button1 google-btn"><img class="google-img" src="{{asset('frontend/img/googlelogo.png')}}">  Signup With Google </a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <a href="{{route('facebook.auth')}}" type="button" class="btn button1 facebook-btn"><img class="facebook-img" src="{{asset('frontend/img/facebook.jpg')}}"> Signup With Facebook </a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <a href="{{route('vkontakte.auth')}}" type="button" class="btn button1 vkontakte-btn"><img class="vkontakte-img" src="{{asset('frontend/img/vk_logo.png')}}">  Signup With VKontakte </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="tab-pane fade  " id="kayitBox2" role="tabpanel" aria-labelledby="girisTab2">
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

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1"  aria-hidden="true" style="background-color:rgb(0 0 0 / 36%)">
      <div class="modal-dialog modal-dialog-centered justify-content-center ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center" style="margin-left:15px;font-size:20px;">Forgot Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="{{route('forgot.password.post')}}" >
              @csrf
              <div class="form-group">
                <div class="d-flex align-items-center" style="justify-content:center;">
                  <div class="col-lg-12">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" required>
                    @if ($errors->has('email'))
                      <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn buttons button1"> Reset Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="message-notification"></div>

    <!-- JavaScript Libraries -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('frontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <!-- <script src="{{asset('frontend/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('frontend/mail/contact.js')}}"></script> -->

    <!-- Template Javascript -->
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <!-- Toastr message -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','success') }}"
        switch(type){
          case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;
          case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;
          case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;
          case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break; 
        }
      @endif 
    </script>

    <script src="{{ asset('backend/assets/js/code.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        
    <li style="display:none" id="google_translate_element2"></li>
    <script type="text/javascript">
      function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>

    <script type="text/javascript">
      function GTranslateGetCurrentLang() {var keyValue = document.cookie.match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}
      function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}
      function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(GTranslateGetCurrentLang() == null && lang == lang_pair.split('|')[0])return;var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(sel[i].className=='goog-te-combo')teCombo=sel[i];if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}
      if(GTranslateGetCurrentLang() != null)jQuery(document).ready(function() {jQuery('div.switcher div.selected a').html(jQuery('div.switcher div.option').find('img[alt="'+GTranslateGetCurrentLang()+'"]').parent().html());});
    </script>
  </body>
</html>