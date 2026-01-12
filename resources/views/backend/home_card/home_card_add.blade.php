@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Hizmet Ekle</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('store.home.card')}}" class="needs-validation" novalidate>
              @csrf
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Hizmet Icon Adı: </label>
                <div class="col-sm-10">
                  <input name="card_icon" class="form-control" type="text" required>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Mobil Icon Adı: </label>
                <div class="col-sm-10">
                  <input name="mobile_icon" class="form-control" type="text" required>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"> Hizmet Başlık: </label>
                <div class="col-sm-10">
                  <input name="card_title" class="form-control" type="text" required>
                </div>
              </div> <!--end row-->

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"> Hizmet Açıklama: </label>
                <div class="col-sm-10">
                  <input name="card_subtitle" class="form-control" type="text" required>
                </div>
              </div> <!--end row-->

              <input type="submit" class="btn btn-info waves-effect waves-light" value="Gönder">
            </form>
          </div>
        </div>
      </div> <!-- end col -->
    </div>
  </div>
</div>

@endsection
