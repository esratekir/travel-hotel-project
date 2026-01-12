@extends('backend.admin_master')
@section('admin')


<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Tur Düzenle</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.tours')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="id" value="{{ $tours_id->id }}">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tur Adı:</label>
                <div class="col-sm-10">
                  <input name="tour_title" class="form-control" value="{{ $tours_id->tour_title }}" type="text" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Ülke: </label>
                <div class="col-sm-10">
                  <select name="country" class="form-select" required>
                    <option selected="">-Seçiniz-</option>
                    @foreach($countries as $country)
                      <option value="{{ $country->id }}" {{ $country->id == $tours_id->country ? 'selected' : ''}}>{{ $country->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Gün:</label>
                <div class="col-sm-10">
                  <input name="day" class="form-control" value="{{ $tours_id->day}}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kişi Sayısı:</label>
                <div class="col-sm-10">
                  <input name="person" class="form-control" value="{{ $tours_id->person}}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Fiyat:</label>
                <div class="col-sm-10">
                  <input name="price" class="form-control" value="{{ $tours_id->price}}" type="number" required>
                </div>
              </div>
              <!-- end row -->

              <div class=" row mb-3">
                <label class="col-sm-2 col-form-label">Fiyata Dahil Olanlar:</label>
                <div class="col-sm-10">
                  <textarea name="fiyat_dahil" class="form-control" rows="9" type="text" required>{{ $tours_id->fiyat_dahil }}</textarea>
                </div>
              </div>
              <!-- end row -->

              <div class=" row mb-3">
                <label class="col-sm-2 col-form-label">Fiyata Dahil Olmayanlar:</label>
                <div class="col-sm-10">
                  <textarea name="fiyat_dahil_degil" class="form-control" rows="9" type="text" required>{{ $tours_id->fiyat_dahil_degil }}</textarea>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kişi Başı Fiyat:</label>
                <div class="col-sm-10">
                  <input name="kisi_basi" class="form-control" value="{{ $tours_id->kisi_basi}}" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tur Tarihi:</label>
                <div class="col-sm-10">
                  <input name="tur_tarihi" class="form-control" value="{{ $tours_id->tur_tarihi}}" type="date" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Çift Kişilik Oda Fiyatı:</label>
                <div class="col-sm-10">
                  <input name="cift_kisilik_oda" class="form-control" value="{{ $tours_id->cift_kisilik_oda}}" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">İlave Yatak:</label>
                <div class="col-sm-10">
                  <input name="ilave_yatak" class="form-control" value="{{ $tours_id->ilave_yatak}}" type="number">
                </div>
              </div>
              <!-- end row -->


              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Resim:</label>
                <div class="col-sm-10">
                  <input class="form-control" name="image" type="file"  id="image">
                  @if($errors->has('image'))
                    <div class="error">{{ $errors->first('image') }}</div>
                  @endif
                  <label class=" col-form-label">Not: Maksimum resim boyutu 2MB'tan fazla olmamalıdır.</label>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <img class="img-thumbnail" id="showImage" width="200" src="{{ asset($tours_id->image) }}" data-holder-rendered="true">
                </div>
              </div>
              <!-- end row -->

              <input type="submit" class="btn btn-info waves-effect waves-light" value="Gönder">
            </form>
          </div>
        </div>
      </div> <!-- end col -->
    </div>
  </div>
</div>

<!-- burada javascript ile seçilen resmi görüntüledik -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });
  });
</script>

@endsection
