@extends('frontend.main_master')
@section('main')

@section('title')
Cookies | TRAVELER
@endsection

<!-- Header Start -->
<div class="container-fluid page-header page-header-search">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 250px">
      <h3 class="display-4 text-white text-uppercase">Cookies</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0 text-uppercase"><a class="text-white" href="{{route('home')}}">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0 text-uppercase">Cookies</p>
      </div>
    </div>
  </div>
</div>
<!-- Header End -->

<div class="container-fluid py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 style="font-size: 24px;">Cookies</h1>
        <p style="font-size: 14px;"></p>
        <p>Cookies are small pieces of data that are stored by a user’s web browser on the User’s hard drive for a period of time. Cookies may record information a user accesses on one webpage to simplify subsequent interactions with that website by the same user, or to use the information to streamline the User's transactions on related webpages. Cookies make it easier for a user to move from webpage to webpage and to complete transactions over the Internet.</p>
        <p>We use “cookies” to make the Site and Application easier for you to use and to make our advertising better.</p>
        <p>The Site and Application also uses “cookies” to store and sometimes track information to make your online experience easier and more personalized.</p>
        <p>Most major web browsers are set up so that they will initially accept cookies, but you may modify your computer's preferences to issue you an alert when a cookie is downloaded, or to disable the ability of third parties to download a cookie to you. If you choose to reject all cookies, there might be areas of the Site and Application that may not function properly.</p>
        <p>Should you have questions regarding cookies employed in the Site or Application, please contact us using email support@tourguidefind.com.</p>
      </div>
    </div>
  </div>
<div>

@endsection