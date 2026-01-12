@extends('backend.admin_master')
@section('admin')

@php 
$contact = App\Models\Contact::get();
@endphp

@php 
$guides = App\Models\User::whereHas("roles", function($q){ $q->where("name", "guide"); })->get();
@endphp

@php 
$comments = App\Models\HomeCard::get();
@endphp

@php 
$slider = App\Models\HomeSlide::get();
@endphp

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-3 col-md-6">
        <div class="card">
          <a href="{{ route('contact.message')}}" class="card-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="text-truncate font-size-14 text-body mb-2">Mesajlar</p>
                <h4 class="mb-0">{{count($contact)}}</h4>
              </div>
              <div class="avatar-sm mt-1">
                <span class="avatar-title bg-light text-primary rounded-3">
                  <i class="ri-mail-open-line font-size-24"></i>
                </span>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card">
          <a href="{{ route('all.guides')}}" class="card-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="text-truncate font-size-14 text-body mb-2">Rehberler</p>
                <h4 class="mb-0">{{count($guides)}}</h4>
              </div>
              <div class="avatar-sm mt-1">
                <span class="avatar-title bg-light text-primary rounded-3">
                  <i class="ri-team-line font-size-24"></i>
                </span>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card">
          <a href="{{ route('home.image')}}" class="card-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="text-truncate font-size-14 text-body mb-2">Slider</p>
                <h4 class="mb-0">{{count($slider)}}</h4>
              </div>
              <div class="avatar-sm mt-1">
                <span class="avatar-title bg-light text-primary rounded-3">
                  <i class="ri-pencil-line font-size-24"></i>
                </span>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card">
          <a href="{{ route('all.home.card')}}" class="card-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="text-truncate font-size-14 text-body mb-2">Hizmetlerimiz</p>
                <h4 class="mb-0">{{count($comments)}}</h4>
              </div>
              <div class="avatar-sm mt-1">
                <span class="avatar-title bg-light text-primary rounded-3">
                  <i class="ri-message-3-line font-size-24"></i>
                </span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
