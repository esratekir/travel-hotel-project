@extends('frontend.main_master')
@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-5">
  <div class="container profil-con view-trip">
    <div class="text-center mb-3 pb-3 ">
      <h1>Profile Settings</h1>
    </div> 
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="clearfix"></div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.profile')}}" ><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.profile2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.profile3')}}"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.profile4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.profile5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.profile6')}}" class="current"><i class="fas fa-image"></i> Photos</a></li>
              <li><a href="{{route('guide.profile7')}}" data-target="password"><i class="fas fa-lock"></i>Change Password</a></li>
            </ul>            
          </div>
        </div>
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Photos</h3>
            <div class="content with-padding">
              <label>Please upload up to 5 images!</label>
              <form method="post" action="{{route('guide.update.profile6')}}" class="dropzone mb-5" id="dropzone" enctype='multipart/form-data'  >
                @csrf
                <div class="fallback">
                  <input  name="file" type="file"  value="{{ $data->image }}">
                </div>
                <input type="hidden" name="user_id" value="{{ $data->user_id }}">
              </form>
              <div class="foto">
                <div class="row" style="justify-content:center;">
                  @foreach($all_image as $item)
                    <div class="col-xl-2 col-sm-4 mb-3 imgWrap">
                      <div class="card text-white  o-hidden h-100">
                        <img src="{{asset($item->image) }}" >
                        <div class="row1 mt-2">
                          <span class="col-sm-12">
                            <button class="btn  btn-sm mb-1 rehberFotoSilBtn" data-id="{{$item->id}}"><i class="fas fa-trash-alt"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>	
        </div> 
      </div>
    </div>          
  </div>
</div>
   
<!-- Dropzone'u çalıştırdığım javascriptim -->
<script type="text/javascript">
  Dropzone.options.dropzone = {
    thumbnailWidth: 200,
    maxFileSize: 1,
    acceptedFiles: ".jpeg, .jpg, .png",
    addRemoveLinks: true,
    timeout: 5000,
    maxFiles: 5, // 5 resim sınırı belirlendi
    init: function () {
      this.on("success", function (file, response) {
        //$('#successModal').modal('show');
        location.reload();
      });
    },
    addedfile: function (file) {
      if (this.files.length > this.options.maxFiles) {
        // Eğer kullanıcı 5'ten fazla dosya eklemeye çalışırsa,
        // yeni dosyayı kaldırarak dosya eklemesini engelle.
        this.removeFile(file);
        alert("Sadece 5 resim yükleyebilirsiniz!");
      }
    }
  };
</script>

<!-- Dropzone ile resim yükledikten sonra kullanıcı resmini silmek isterse sil butonunu çalıştıracak javascript kodu -->
<script>
  $(".rehberFotoSilBtn").click(function(){
    var id = $(this).attr('data-id');
    var postData = {
      id: id
    };
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var url = "{{ url('delete/user/image') }}/" + id;
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
          alert("ERROR: Image could not to be deleted.");
        }
      });
    }
  });
</script>

@endsection