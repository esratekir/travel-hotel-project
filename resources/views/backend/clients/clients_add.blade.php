@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Müşteri Yorumu Ekle</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('store.client')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Müşteri Adı:</label>
                <div class="col-sm-10">
                  <input name="name" class="form-control" type="text" id="example-text-input" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Müşteri Mesleği:</label>
                <div class="col-sm-10">
                  <input name="job" class="form-control" type="text" id="example-text-input" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Müşteri Mesajı:</label>
                <div class="col-sm-10">
                  <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Müşteri Resmi:</label>
                <div class="col-sm-10">
                  <input class="form-control" name="image" type="file" id="image" required>
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
                  <img class="img-thumbnail" id="showImage" width="200" src="{{ url('upload/no_image.jpg') }}" data-holder-rendered="true">
                </div>
              </div>
              <!-- end row -->

              <div class="row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <input type="submit" class="btn btn-info waves-effect waves-light" value="Gönder">
                </div>
              </div>
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
