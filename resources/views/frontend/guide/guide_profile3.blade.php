@extends('frontend.main_master')
@section('main')

<div class="container-fluid py-5">
  <div class="container profil-con view-trip">
    <div class="text-center mb-3 pb-3">
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
              <li><a href="{{route('guide.profile3')}}" class="current"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.profile4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.profile5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.profile6')}}"><i class="fas fa-image"></i> Photos</a></li>
              <li><a href="{{route('guide.profile7')}}" data-target="password"><i class="fas fa-lock"></i>Change Password</a></li>
            </ul>            
          </div>
        </div>
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Languages</h3>
            <div class="content with-padding" id="checkboxes2">
              <form method="post" action="{{route('guide.update.profile3')}}" id="contactForm">
                @csrf 
                <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                <div class="control-group">
                  <label>Search:</label>
                  <input type="search" class="form-control" id="searchInput" />
                </div>
                <div class="row ml-1 mr-0">
                  @foreach($language as $item)
                    <div class="control-group col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
                      <input class="form-check-input" name="language[]" type="checkbox" style="filter:hue-rotate(170deg);" value="{{$item->id}}" id="flexCheck{{$item->id}}" {{ (in_array($item->id, $guide_lang)) ? 'checked' : '' }}>
                      <label class="form-check-label mt-0" for="flexCheck{{$item->id}}">
                        <img src="{{asset($item->flag)}}"> {{$item->language}}
                      </label>
                    </div>
                  @endforeach
                </div>   
                <div class="row mt-2">
                  <div class="col-md-12">
                    <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>				
        </div>
      </div>          
    </div>
  </div>
</div>

<!-- Rehber profilinde dil seçerken arama yapabilme javascripti -->
<script>
  $(document).ready(function() {
    // When the user types in the search input
    $("#searchInput").on("keyup", function() {
      var searchText = $(this).val().toLowerCase();
      // Loop through each checkbox label
      $(".form-check-label").each(function() {
        var labelText = $(this).text().toLowerCase();
        var isChecked = false;

        // Check if the label text contains the search text
        if (labelText.indexOf(searchText) !== -1) {
          isChecked = true;
        }
        // Show/hide the corresponding checkbox based on the search result
        //$(this).prev().prop("checked", isChecked);
        $(this).closest(".control-group").toggle(isChecked);
      });
    });
  });
</script>

<!-- Checkbox'ların en az birinin seçilmesi gerektiğini çalıştıran javascript -->
<script>
  document.getElementById('contactForm').onsubmit = function (e) {
    var checkbox = document.getElementsByName("language[]"),
    i,
    checked;
    for (i = 0; i < checkbox.length; i += 1) {
      checked = (checkbox[i].checked||checked===true)?true:false;
    }

    if (checked == false) {
      alert('Please select at least one!');
      e.preventDefault();
      return false;
    } else {
      return true;
    }
  }
</script>

@endsection