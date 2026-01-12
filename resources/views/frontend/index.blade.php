@extends('frontend.main_master') @section('main') @section('title') Home | TRAVELER @endsection

<!-- Slider Start -->
@include('frontend.home_all.home_slider')
<!-- Slider End -->


<!-- Guide Start -->
@include('frontend.home_all.home_guides')
<!-- Guide End -->

<!-- Destination Start -->
<!-- @include('frontend.home_all.destination') -->
<!-- Destination Start -->

<!-- Home-Kayıt -->
@include('frontend.home_all.home_kayit')
<!-- Home Kayıt End -->

<!-- home card Start -->
@include('frontend.home_all.home_card')
<!-- Home Card End -->

<!-- Packages Start -->
<!-- @include('frontend.home_all.home_tours') -->
<!-- Packages End -->

<!-- Testimonial Start -->
@include('frontend.home_all.testimonial')
<!-- Testimonial End -->

<script>
  function compareStrings(str1, str2) {
    return str1.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .includes(str2.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase());
  };

  $(document).ready(function() {
    $(".city-link").click(function() {
      var cityName = $(this).text();
      $("#txtSearch").val(cityName);
      $("#cityList").hide();
    });

    $("#txtSearch").on('keyup', function() {
      var search = $(this).val().trim();
      var cityList = $("#cityList");
      if (search === "") {
        cityList.hide();
        return;
      }
      cityList.show();
      cityList.find(".city-item").each(function() {
        var cityName = $(this).find(".city-link").text();
        var listItem = $(this);
        if (compareStrings(cityName, search)) {
          listItem.show();
        } else {
          listItem.hide();
        }
      });

      cityList.find(".city-item:visible").css("border-radius", "0");
      cityList.find(".city-item:visible:first").css("border-top-left-radius", "0");
      cityList.find(".city-item:visible:last").css("border-bottom-left-radius", "0");
      cityList.find(".city-item:visible:last").css("border-bottom-right-radius", "0");
    });
  });

  $(document).ready(function() {
    $(".city-link").click(function() {
      var cityName = $(this).text();  // Seçilen şehir adını alın
      $("#txtSearch").val(cityName);  // Input kutusunun değerini seçilen şehir adıyla değiştirin
      $("#cityList").hide();  // Şehir listesini gizle
    });
  });
</script>

@endsection
