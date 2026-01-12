@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Tripler</h4>
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
                  <th>İsim</th>
                  <th>Hedef</th>
                  <th>Gidiş Tarihi</th>
                  <th>Dönüş Tarihi</th>
                  <th>Kişi Sayısı</th>
                  <th data-priority="1" style="min-width: 10px;width: 10px;max-width: 10px;"></th>
                </tr>
              </thead>

              <tbody>
                @php($i = 1)
                @foreach($trips as $item)
                  <tr>
                    <td>{{$item['user']['name'] ?? null}}</td>
                    <td>{{$item['citi']['name']}}, {{$item->citi->country->country}}</td>
                    <td>{{$item->date_from}}</td>
                    <td>{{$item->date_to}}</td>
                    <td>{{$item->number_of}}</td>
                    <td>
                      <a href="{{ route('delete.admin.trips', $item->id) }}" class="btn btn-danger btn-sm" id="delete" title="Sil"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div> <!-- end col -->
    </div> <!-- end row -->
  </div>
</div>

@endsection
