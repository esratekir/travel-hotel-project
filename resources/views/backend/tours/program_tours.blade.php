@extends('backend.admin_master')
@section('admin')
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Tur Programı</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.program.tours') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
              @csrf
              @if(count($countries)>0)
                @php($a=1)
                @foreach($countries as $country)
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">{{ $a++ }}.Gün:</label>
                    <div class="col-sm-10">
                      <input name="day[]" class="form-control" value="{{$country['tour_day']}}" type="text" required>
                    </div>
                  </div>
                  <!-- end row -->

                  <div class=" row mb-3">
                    <label class="col-sm-2 col-form-label">Açıklama:</label>
                    <div class="col-sm-10">
                      <textarea name="detail[]" class="form-control" rows="5" required>{{$country['tour_detail']}}</textarea>
                    </div>
                  </div>
                @endforeach
              @else
                @for ($i = 1; $i <= $tours_id->day; $i++)
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">{{ $i }}.Gün:</label>
                    <div class="col-sm-10">
                      <input name="day[]" class="form-control" value="" type="text" required>
                    </div>
                  </div>
                  <!-- end row -->

                  <div class=" row mb-3">
                    <label class="col-sm-2 col-form-label">Açıklama:</label>
                    <div class="col-sm-10">
                      <textarea name="detail[]" class="form-control" rows="5" required></textarea>
                    </div>
                  </div>
                @endfor
              @endif
              <div class="row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{ $tours_id->id }}">
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
  $(document).ready(function() {
    $('#image').change(function(e) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#showImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });
  });
</script>
@endsection