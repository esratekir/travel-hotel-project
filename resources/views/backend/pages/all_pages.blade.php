@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-0">Sayfalar</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>Sayfa Adı</th>
                  <th style="min-width: 10px;width: 10px;max-width: 10px;"></th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <a href="{{ route('pages.home')}}"><strong>Home</strong></a>
                  </td>
                  <td class="d-flex justify-content-end">
                    <a href="{{ route('pages.home')}}" class="btn btn-info btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                  </td>
                </tr>
                <!-- <tr>
                  <td>
                    <a href="{{ route('pages.tour')}}"><strong>Tours</strong></a>
                  </td>
                  <td class="d-flex justify-content-end">
                    <a href="{{ route('pages.tour')}}" class="btn btn-info btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                  </td>
                </tr> -->

                <tr>
                  <td>
                    <a href="{{ route('pages.guide')}}"><strong>Guides</strong></a>
                  </td>
                  <td class="d-flex justify-content-end">
                    <a href="{{ route('pages.guide')}}" class="btn btn-info btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                  </td>
                </tr>

                <tr>
                  <td>
                    <a href="{{ route('pages.contact')}}"><strong>Contact</strong></a>
                  </td>
                  <td class="d-flex justify-content-end">
                    <a href="{{ route('pages.contact')}}" class="btn btn-info btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div> <!-- end col -->
    </div> <!-- end row -->
  </div>
</div>

@endsection
