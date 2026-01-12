@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Dil Düzenle</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.languages')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="id" value="{{ $language_id->id }}">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Dil:</label>
                <div class="col-sm-10">
                  <input name="language" class="form-control" value="{{ $language_id->language }}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Bayrak İcon:</label>
                <div class="col-sm-10">
                  <input name="flag_icon" class="form-control" value="{{ $language_id->flag_icon }}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Bayrak:</label>
                <div class="col-sm-10">
                  <input class="form-control" name="flag" type="file"  id="image">
                  @if($errors->has('flag'))
                    <div class="error">{{ $errors->first('flag') }}</div>
                  @endif
                  <label class=" col-form-label">Not: Maksimum resim boyutu 2MB'tan fazla olmamalıdır.</label>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <img class="img-thumbnail" id="showImage" width="200" src="{{ asset($language_id->flag) }}" data-holder-rendered="true">
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
