@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-2">
          <h4 class="mb-sm-0">Diller</h4>
        </div>
        <a href="{{ route('add.languages')}}" class="btn btn-info mb-3 btn-sm">Dil Ekle</a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Diller</th>
                  <th>Flag İcon</th>
                  <th data-priority="1" style="min-width: 50px;width: 50px;max-width: 50px;"></th>
                </tr>
              </thead>

              <tbody>
                @foreach($languages as $item)
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->language}}</td>
                    <td>{{$item->flag_icon}}</td>
                    <td>
                      <a href="{{ route('edit.languages', $item->id)}}" class="btn btn-info btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                      <a href="{{ route('delete.languages', $item->id)}}" class="btn btn-danger btn-sm" id="delete" title="Sil"><i class="fas fa-trash-alt"></i></a>
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
