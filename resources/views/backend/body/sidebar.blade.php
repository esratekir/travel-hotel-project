 <!-- ========== Left Sidebar Start ========== -->
@php
  $site_url = App\Models\Settings::find(1);
@endphp
<div class="vertical-menu">
  <div data-simplebar class="h-100">
    <!--- Sidebar -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <div class="title">
        <a href="{{$site_url->site_url}}" target="_blank" class="waves-effect">
          <span class="badge rounded-pill bg-success float-end"></span>
          <span>Siteyi Görüntüle</span>
        </a>
      </div>
      <ul class="metismenu list-unstyled" id="side-menu">

        <li>
          <a href="{{ route('dashboard')}}" class="waves-effect">
            <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Anasayfa</span>
          </a>
        </li>

        <li>
          <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="ri-settings-3-fill"></i>
            <span>Genel Ayarlar</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('site.settings')}}">Site Ayarları</a></li>
            <li><a href="{{ route('email.settings')}}">Email Ayarları</a></li>
            <li><a href="{{ route('google.settings')}}">Google Ayarları</a></li>
            <li><a href="{{ route('company.settings')}}">Firma Ayarları</a></li>
            <li><a href="{{ route('social.media.settings')}}">Sosyal Medya Ayarları</a></li>
            <li><a href="{{ route('all.menus')}}">Menü Ayarları</a></li>
            <li><a href="{{ route('all.destination')}}">Ülke Ayarları</a></li>
            <li><a href="{{ route('all.cities')}}">Şehir Ayarları</a></li>
            <li><a href="{{ route('all.languages')}}">Dil Ayarları</a></li>
          </ul>         
        </li>

        <li>
          <a href="{{ route('home.image')}}" class="waves-effect">
            <i class="ri-slideshow-2-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Slider</span>
          </a>
        </li>

        <li>
          <a href="{{ route('contact.message')}}" class="waves-effect">
            <i class="ri-mail-open-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Mesajlar</span>
          </a>
        </li>

        <li>
          <a href="{{ route('all.client')}}" class="waves-effect">
            <i class="ri-message-3-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Anasayfa Yorumları</span>
          </a>
        </li>

        <li>
          <a href="{{ route('pages')}}" class="waves-effect">
            <i class="ri-book-3-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Sayfalar</span>
          </a>
        </li>

        <li>
          <a href="{{ route('all.home.card')}}" class="waves-effect">
            <i class="ri-inbox-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Hizmetlerimiz</span>
          </a>
        </li>

        <li>
          <a href="{{ route('all.activity')}}" class="waves-effect">
            <i class="ri-footprint-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Etkinlikler</span>
          </a>
        </li>

        <!-- <li>
          <a href="{{ route('all.tours')}}" class="waves-effect">
            <i class="ri-guide-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Turlar</span>
          </a>
        </li> -->

        <li>
          <a href="{{ route('all.guides')}}" class="waves-effect">
            <i class="ri-team-line"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Rehberler</span>
          </a>
        </li>

        <li>
          <a href="{{ route('trips.all')}}" class="waves-effect">
          <i class="fas fa-plane"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span>Tripler</span>
          </a>
        </li>

        <li>
          <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="fas fa-user"></i>
            <span>Online Kullanıcılar</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('guide.online')}}">Online Rehberler</a></li>
            <li><a href="{{ route('user.online')}}">Online Kullanıcılar</a></li>
            
          </ul>         
        </li>

        <li>
          <a href="{{ route('all.complaints')}}" class="waves-effect">
          <i class="fas fa-user-times"></i><span class="badge rounded-pill bg-success float-end"></span>
            <span> Şikayetler</span>
          </a>
        </li>
      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->
