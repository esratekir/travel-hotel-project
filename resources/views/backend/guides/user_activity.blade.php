@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-2">
          <h4 class="mb-sm-0">Online Kullanıcılar</h4>
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
                  <th style="width: 10px">ID</th>
                  <th>Rehber Adı</th>
                  <th>Son Görülme</th>
                  <th>Statü</th>
                  <!-- <th data-priority="1" style="min-width: 50px;width: 50px;max-width: 50px;"></th> -->
                </tr>
              </thead>

              <tbody>
                @php($i = 1)
                @foreach($users as $item)
                  @if(isset($item))
                    <tr>
                      <td>{{$item->user_id}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{Carbon\Carbon::parse($item->last_seen)->diffForHumans()}}</td>
                      <td><span class="waves-effect waves-light text-white bg-{{ $item->last_seen >= now()->subMinutes(2) ? 'green' : 'red'}} "> {{ $item->last_seen >= now()->subMinutes(2) ? 'Online' : 'Offline'}} </span></td>
                    </tr>
                  @endif
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
