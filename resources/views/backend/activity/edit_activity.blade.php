@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Etkinlik Düzenle</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('update.activity')}}" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="id" value="{{ $activity_id->id }}">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Etkinlik Adı:</label>
                <div class="col-sm-10">
                  <input name="activity_name" class="form-control" value="{{ $activity_id->activity_name }}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Etkinlik İcon:</label>
                <div class="col-sm-10">
                  <input name="icon" class="form-control" value="{{ $activity_id->icon }}" type="text" required>
                </div>
              </div>
              <!-- end row -->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Mobil İcon:</label>
                <div class="col-sm-10">
                  <input name="mobile_icon" class="form-control" type="text" value="{{ $activity_id->mobile_icon }}" required>
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
