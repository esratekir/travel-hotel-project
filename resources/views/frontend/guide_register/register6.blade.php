@extends('frontend.main_master')
@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-5">
  <div class="container view-trip">
    <div class="row main-set"> 
      <div class="col-md-3" id="">
        <div class="margin-bottom-20"> </div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.register.step1')}}"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.register.step2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.register.step3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.register.step4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.register.step5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.register.step6')}}" class="current"><i class="fas fa-image"></i> Photos</a></li>
            </ul>            
          </div>
        </div>        
      </div>
      <div class="col-md-9 register-frm" id="">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Photos</h3>
            <div class="content with-padding">
              <label>Please upload up to 5 images!</label>
              <form method="post" action="{{route('update.guide.register.step6')}}" class="dropzone mb-5" id="dropzone" enctype='multipart/form-data'  >
                @csrf     
                <div class="fallback">
                  <input  name="file" type="file"  multiple="multiple">
                </div>
              </form>
              <div class="foto">
                @if(session()->has('success_message'))
                  <div class="alert alert-success">{{ session('success_message') }}</div>
                @endif
                <div class="row" style="justify-content:center;">
                @if(isset($guide_reg->uploaded_images))
                  @foreach($guide_reg->uploaded_images as $item)
                    <div class="col-xl-2 col-sm-4 mb-3 imgWrap">
                      <div class="card text-white  o-hidden h-100">
                        <img src="{{asset($item)}}">
                        <div class="row1 mt-3">
                          <span class="col-sm-12">
                            <button class="btn  btn-sm mb-1 rehberFotoSilBtn" data-id="{{$item}}"><i class="fas fa-trash-alt"></i></button>
                          </span>                         
                        </div>
                      </div>
                    </div>
                  @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>	
        </div>
      </div> 
      <div class="row butt" >
          <form action="{{route('guide.register.complete')}}" method="POST" id="frm">
            @csrf  
            <div class="i-agree">
              <input type="checkbox" name="checkbox" id="i-agree">
              <label for="i-agree"><span></span> <p>By clicking Complete, you agree to our <a href="{{route('terms.of.use')}}">Terms of Service</a>, <a href="{{route('privacy.policy')}}"> Policies</a> and <a href="{{route('cookies')}}"> Cookies Policy</a>.</p></label>
            </div>        
            <button disabled type="submit" id="submit_button" onclick="terms_changed(this)" class="btn buttons py-md-3 px-md-5 mt-2 butto" >Complete</button>
          </form>
        </div>          
    </div>
  </div>
  </div>
</div>

<!-- Dropzone'un çalışmasını tetikleyen javascript kodu -->
<script type="text/javascript">
  Dropzone.options.dropzone = {
    maxFileSize:1,
    dictFileTooBig: "File size is too large (maxFileSize MB). Maksimum file size: maxFileSize MB.",
    thumbnailWidth:200,
    acceptedFiles:".jpeg, .jpg, .png",
    addRemoveLinks:true,
    timeout: 5000,
    maxFiles: 5,
    init: function () {
      this.on("queuecomplete", function(file, response) {
      // Yükleme başarılıysa yapılan işlemler
      $(".dz-success-mark svg").css("color", "green");
      $(".dz-error-mark").css("display", "none");
       location.reload();
       //console.log(response);
      });
      this.on("error", function(file, errorMessage, xhr) {
        // Yükleme başarısız olduysa yapılan işlemler
        $(".dz-error-mark svg").css("background", "red");
        $(".dz-success-mark").css("display", "none");
      });
    }
  }
</script>

<!-- Dropzone ile yüklenen resimlerin silinebilmesini sağlayan AJAX kodu -->
<script>
  $(".rehberFotoSilBtn").click(function(){
    var id = $(this).attr('data-id');
    var postData = {
      id: id
    };
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var url = "{{ url('delete/guide/image') }}";
    var confirmDelete = confirm("Are you sure want to delete?");
    if (confirmDelete) {
      $.ajax({
        url: url,
        type: "POST",
        data: postData,
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        success: function(data) { 
          location.reload();
        },
        error: function() {
          alert("ERROR: Image could not be deleted.2");
        }
      });
    }
  });
</script>

<!-- Rehber kaydının son aşamasında kullanım koşulları checkbox'ının seçilmeden kayıt işleminin tamamlanamamasını sağlayan javascript kodu.checkbox seçilmeden buton aktif edilmiyor. -->
<script>
  document.getElementById("frm").addEventListener("click", function(evt) {
    let checked = 0;
    this.querySelectorAll('input[type="checkbox"]').forEach(e => {
      if (e.checked) checked++;});
    document.getElementById("submit_button").disabled = checked === 0;
  });
</script>

@endsection