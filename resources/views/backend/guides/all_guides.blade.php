@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-2">
          <h4 class="mb-sm-0">Rehberler</h4>
        </div>
        <a href="{{ route('add.guides')}}" class="btn btn-info mb-3 btn-sm">Rehber Ekle</a>
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
                  <th>Ülke</th>
                  <th>Dil</th>
                  <th>Onayla/Reddet</th>
                  <th data-priority="1" style="min-width: 50px;width: 50px;max-width: 50px;"></th>
                </tr>
              </thead>

              <tbody>
                @php($i = 1)
                @foreach($all_guides as $item)
                  <tr>
                    <td>{{$item->user_id}}</td>
                    <td>{{$item->name}}</td>
                    @if(isset($item['Country']['country'])) 
                      <td>{{$item['Country']['country']}}</td>
                    @endif
                    <td>
                      @foreach($item->Language as $lang)
                        {{$lang->language}}
                      @endforeach
                    </td>
                    @if($item->is_approved == 0)
                      <td>
                        <a href="{{ route('admin.approve', $item->user_id) }}" class="btn btn-success btn-sm">Onayla</a>
                        <a href="{{ route('admin.decline', $item->user_id) }}" class="btn btn-danger btn-sm">Reddet</a>
                      </td>
                    @else
                      <td> <p>Guide is approved.</p></td>
                    @endif
                    <td>
                      <a href="{{ route('edit.guides', $item->user_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit" title="Düzenle"></i></a>
                      <a href="{{ route('delete.guides', $item->user_id) }}" class="btn btn-danger btn-sm" id="delete" title="Sil"><i class="fas fa-trash-alt"></i></a>
                      <a href="{{ route('comments.message', $item->user_id) }}" class="btn btn-warning btn-sm" title="Yorumlar"><i class="fas fa-comments"></i></a>
                      <a href="{{ route('all.images', $item->user_id)}}" class="btn btn-primary btn-sm" title="Galeri"><i class="fas fa-image"></i></a>
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
