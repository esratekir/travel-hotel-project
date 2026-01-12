@extends('backend.admin_master')
@section('admin')


<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Rehber Düzenle</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.guides')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="id" value="{{ $guides_id->user_id }}">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Adı:</label>
                <div class="col-sm-10">
                  <input name="name" class="form-control" value="{{$guides_id->name}}" type="text" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Kullanıcı Adı:</label>
                <div class="col-sm-10">
                  <input name="username" class="form-control" value="{{$guides_id->username}}" type="text" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Şifresi:</label>
                <div class="col-sm-10">
                  <input name="password" class="form-control" type="password" autocomplete="new-password">
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Email:</label>
                <div class="col-sm-10">
                  <input name="email" class="form-control" type="email" value="{{$guides_id->email}}" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Telefon:</label>
                <div class="col-sm-10">
                  <input name="phone" class="form-control" type="text" value="{{$guides_id->phone}}" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Rehber Motto:</label>
                <div class="col-sm-10">
                  <input name="motto" class="form-control" type="text" value="{{$guides_id->motto}}" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Açıklama:</label>
                <div class="col-sm-10">
                  <textarea name="description" type="text" class="form-control" rows="5" required>{{$guides_id->description}}</textarea>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Cinsiyet: </label>
                <div class="col-sm-10">
                  <select name="gender" class="form-select" required>
                    <option value="{{$guides_id->gender}}">-Seçiniz-</option>
                    <option value="female" {{ $guides_id->gender == "female" ? 'selected' : ''}}>Female</option>
                    <option value="male" {{ $guides_id->gender == "male" ? 'selected' : ''}}>Male</option>
                  </select>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Ülke: </label>
                <div class="col-sm-10">
                  <select name="country" class="form-select"  required>
                    <option value="">-Seçiniz-</option>
                    @foreach($countries as $count)
                      <option value="{{ $count->id }}" {{ $count->id == $guides_id->country ? 'selected' : ''}}>{{ $count->country}}</option>
                    @endforeach
                  </select>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Şehir: </label>
                <div class="col-sm-10">
                  <select name="city" class="form-select"  required>
                    <option value="">-Seçiniz-</option>
                    @foreach($cities as $citi)
                      <option value="{{ $citi->id}}" {{ $citi->id == $guides_id->city ? 'selected' : ''}}>{{ $citi->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Dil: </label>
                <div class="col-sm-10">
                  <select class="select2 form-control select2-multiple" name="languages[]" multiple="multiple" data-placeholder="-Seçiniz-" required>
                    @foreach($languages as $lang)
                      <option value="{{ $lang->id }}" {{ (in_array($lang->id, $guide_lang)) ? 'selected' : '' }}>{{ $lang->language }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback language-feedback">
                    Lütfen en az bir dil seçin!
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Aktiviteler: </label>
                <div class="col-sm-10">
                  <select class="select2 form-control select2-multiple" name="activities[]" multiple="multiple" data-placeholder="-Seçiniz-" required>
                    @foreach($activiti as $act)
                      <option value="{{ $act->id }}" {{ (in_array($act->id, $guide_act)) ? 'selected' : '' }}>{{ $act->activity_name }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback language-feedback">
                    Lütfen en az bir dil seçin!
                  </div>
                </div>
              </div>

              

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tüm Gün Tur:</label>
                <div class="col-sm-10">
                  <input name="fullday_tour" class="form-control" value="{{$guides_id->fullday_tour}}" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Sabah Şehir Turu:</label>
                <div class="col-sm-10">
                  <input name="morning_city_tour" class="form-control" value="{{$guides_id->morning_city_tour}}" type="number">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Şehir Turu:</label>
                <div class="col-sm-10">
                  <input name="city_tour" class="form-control" type="number" value="{{$guides_id->city_tour}}">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Gece Turu:</label>
                <div class="col-sm-10">
                  <input name="night_tour" class="form-control" type="number" value="{{$guides_id->night_tour}}">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Havaalanı Transfer Ücreti:</label>
                <div class="col-sm-10">
                  <input name="airport_transfer_price" class="form-control" type="number" value="{{$guides_id->airport_transfer_price}}">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Saatlik Ücret:</label>
                <div class="col-sm-10">
                  <input name="price" class="form-control" type="number" value="{{$guides_id->price}}">
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Resim:</label>
                <div class="col-sm-10">
                  <input class="form-control" name="image" type="file" id="image" >
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
                  <img class="img-thumbnail" id="showImage" width="200" src="{{asset($guides_id->image) }}" data-holder-rendered="true">
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
