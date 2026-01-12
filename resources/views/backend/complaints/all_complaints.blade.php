@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-2">
          <h4 class="mb-sm-0">Şikayetler</h4>
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
                  <th>Şikayet Eden Kulanıcı</th>
                  <th>Şikayet Edilen Kullanıcı</th>
                  <th>Şikayet Nedeni</th>
                  <th>Şikayet Durumu</th>
                  <!-- <th data-priority="1" style="min-width: 50px;width: 50px;max-width: 50px;"></th> -->
                </tr>
              </thead>

              <tbody>
               
                @foreach($all_complaints as $item)
                  @if(isset($item))
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->user->name}}</td>
                      <td>{{$item->reported_user->name}}</td>
                      <td>{{Str::limit($item->message, 150)}}</td>
                      @if($item->status == 0)
                        <td>
                          <span style="color:red;margin-right:10px;"><a href="{{route('complaint.processed', $item->id)}}" class="" style="color:green;"><i class="fas fa-check" style="color:green;"></i> İşleme Al</a></span>
                          <span style="color:red;"><a href="{{route('complaint.notprocessed', $item->id)}}" style="color:red;"><i class="fas fa-times" style="color:red;"></i> İşleme Alma</a></span>
                        </td>
                      @else
                        <td><span style="color:black;">Şikayet işleme alındı.</span></td>
                      @endif
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
