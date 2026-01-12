@extends('backend.admin_master')
@section('admin')


<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Şehir Düzenle</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.cities')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="id" value="{{ $city_id->id }}">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Ülke: </label>
                <div class="col-sm-10">
                  <select name="country" class="form-select"  required>
                    <option value="">-Seçiniz-</option>
                    @foreach($countries as $count)
                    <option value="{{ $count->id }}" {{ $count->id == $city_id->country_id ? 'selected' : ''}}>{{ $count->country}}</option>
                    @endforeach
                  </select>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Şehir:</label>
                <div class="col-sm-10">
                  <input name="name" class="form-control" value="{{ $city_id->name}}" type="text" required>
                </div>
              </div>

              <input type="submit" class="btn btn-info waves-effect waves-light" value="Gönder">
            </form>
          </div>
        </div>
      </div> <!-- end col -->
    </div>
  </div>
</div>

@endsection
