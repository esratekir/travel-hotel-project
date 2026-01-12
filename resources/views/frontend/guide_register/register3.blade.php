@extends('frontend.main_master')
@section('main') 

<div class="container-fluid py-5">
  <div class="container view-trip">
    <div class="row main-set"> 
      <div class="col-md-3" id="soldasabit">
        <div class="margin-bottom-20"> </div>
        <div class="sidebar margin-top-20">
          <div class="user-smt-account-menu-container">
            <ul class="user-account-nav-menu">
              <li><a href="{{route('guide.register.step1')}}"><i class="far fa-user"></i> Profile Settings</a></li>
              <li><a href="{{route('guide.register.step2')}}"><i class="fas fa-globe"></i> Location</a></li>
              <li><a href="{{route('guide.register.step3')}}" class="current"><i class="fas fa-language"></i> Languages</a></li>
              <li><a href="{{route('guide.register.step4')}}"><i class="fas fa-glass-cheers"></i> Activities</a></li>
              <li><a href="{{route('guide.register.step5')}}"><i class="fas fa-dollar-sign"></i> Hourly Rate</a></li>
              <li><a href="{{route('guide.register.step6')}}"><i class="fas fa-image"></i> Photos</a></li>
            </ul>            
          </div>
        </div>       
      </div>
      <div class="col-md-9 register-frm" id="menu-content">
        <div class="utf-user-profile-item">
          <div class="utf-submit-page-inner-box">
            <h3>Languages</h3>
            
            <div class="content with-padding">
              <form method="post" action="{{route('update.guide.register.step3')}}" id="contactForm">
                @csrf
                <div class="control-group">
                  <label>Search:</label>
                  <input type="search" class="form-control" id="searchInput" />
                </div>
                <div class="row ml-1 mr-0" >
                @foreach($language as $item)
                  <div class="control-group col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
                    <input class="form-check-input" name="language[]" type="checkbox" style="filter:hue-rotate(170deg);" value="{{$item->id}}" id="flexCheck{{$item->id}}" @if(is_array($guide_reg->language_select) && in_array($item->id, $guide_reg->language_select)) checked @endif>
                    <label class="form-check-label mt-0" for="flexCheck{{$item->id}}">
                      <img src="{{asset($item->flag)}}"> {{$item->language}}
                    </label>
                  </div>
                @endforeach                       
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">Save and Next</button>
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
</div>

<!-- Rehberin dilini işaretlerken arama yapabilmeyi sağlayan javascript kodum -->
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
        $(this).closest(".control-group").toggle(isChecked);
      });
    });
  });
</script>

<!-- Checkbox'lardan en az birinin seçilmesi gerektiği uyarısını veren javascriptim -->
<script>
$(document).ready(function() {
  $('#contactForm').on('submit', function(e) {
    if (!$('input[name="language[]"]:checked').length) {
      alert('Please select at least one!');
      e.preventDefault();
      return false;
    }
  });
});
</script>

@endsection