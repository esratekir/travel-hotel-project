@extends('backend.admin_master')
@section('admin')

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-2">
          <h4 class="mb-sm-0">{{$user_name->name}} Resimleri</h4>
        </div>
        <a href="{{ route('add.images', $user_name->user_id)}}" class="btn btn-info mb-3 btn-sm">Rehber Resmi Ekle</a>
      </div>
    </div>

    <div class="foto">
      <div class="row">
        @foreach($user_images as $item)
          <div class="col-xl-2 col-sm-4 mb-3 imgWrap">
            <div class="card text-white  o-hidden h-100">
              <img src="{{asset($item->image) }}" >
              <div class="row1 mt-1">
                <span class="col-sm-12 mb-2"></span>
                <span class="col-sm-6">
                  <a href="{{ route('delete.images', $item->id)}}" class="btn btn-danger btn-sm mb-1" id="delete"><i class="fas fa-trash-alt"></i></a>
                </span>
                <span class="col-sm-6">
                  <a href="{{ route('edit.images', $item->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                </span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection