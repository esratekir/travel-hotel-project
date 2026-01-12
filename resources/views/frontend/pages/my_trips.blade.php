@extends('frontend.main_master')
@section('main')

@section('title')
My Trips | TRAVELER
@endsection


<!-- Header Start -->
<div class="container-fluid page-header">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center trip-img">
      <!-- <h3 class="display-4 text-white">My Trips</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
        <i class="fa fa-angle-double-right pt-1 px-3"></i>
        <p class="m-0">My Trips</p>
      </div> -->
    </div>
  </div>
</div>
<!-- Header End -->

<div class="container-fluid packages-wrap py-5 pb-5 my-trips">
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <div class="margin-bottom-20"> </div>
        <div class="col-md-12">
          <div class="utf-user-profile-item ">
            <div class="utf-submit-page-inner-box">
              <h3 class="text-center">Create A Trip</h3>
              <div class="content with-padding">
                <form method="post" action="{{route('update.trips')}}"  class="frm">
                  @csrf
                  @if($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  <div class="form-row">
                    <div class="control-group col-sm-12">
                      <label>Where are you going?  </label>
                      <select id="select-state" name="destination" placeholder=" Where next? ">
                        <option></option>
                        @foreach($city as $citi)
                          <option value="{{$citi->id}}">{{$citi->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="control-group col-sm-6">
                      <label>Date from:</label>
                      <input type="date" name="date_from" id="datepicker" class="form-control" value="" required/>
                    </div>
                    <div class="control-group col-sm-6 mb-3">
                      <label>Date to:</label>
                      <input type="date" name="date_to" class="form-control" value="" required/>
                    </div> 
                  </div>
                  <div class="form-row mt-2">
                    <div class="control-group col-sm-6">
                      <label>Number of people:</label>
                    </div>
                    <div class="control-group col-sm-6">
                      <select class="form-control form-select" name="number_of" required>
                        <option value="Just me" >Just me</option>
                        <option value="Two people" >Two people</option>
                        <option value="Three people" >Three people</option>
                        <option value="More than three" >More than three</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row mt-2 mb-4">
                    <div class="control-group col-sm-6">
                      <label>Looking for a local:</label>
                    </div>
                    <div class="control-group col-sm-6">
                      <div class="row">
                        <div class="control-group col-lg-6 col-md-4 col-sm-6 col-6 mb-2">
                          <input class="form-check-input ml-1" name="local_type[]" type="checkbox" value="Woman" id="flexCheckDefault1" >
                          <label class="form-check-label mt-0 ml-4" for="flexCheckDefault1"> Woman</label>
                        </div>
                        <div class="control-group col-lg-6 col-md-4 col-sm-6 col-6 mb-2">
                          <input class="form-check-input ml-1" name="local_type[]" type="checkbox" value="Man" id="flexCheckDefault2" >
                          <label class="form-check-label mt-0 ml-4" for="flexCheckDefault2"> Man</label>
                        </div>
                      </div>              
                    </div>
                  </div> <hr>    
                  <div class="row">
                    <div class="col-md-12 text-center">  
                      <button type="submit" class="btn buttons margin-top-0 margin-bottom-20">CREATE NEW TRIP</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>				
          </div>
         </div>          
      </div>
    </div>
  </div>
</div>

<div class="container-fluid packages-wrap  pb-5 create-trip">
  <div class="container">        
    <h3 class="text-center mb-5">Current Trips</h3>         
    <div class="row">
      @foreach($userData as $item)
        <div class="col-lg-4 col-md-4 mb-4">
          <div class="package-item bg-white mb-2">   
            <img class="img-fluid trip-img" src="{{ asset($item->citi->country->image) }}" alt="">
            <div class="p-4">
              <div class="d-flex justify-content-normal mb-3 norml">
                <small class=""><i class="fa fa-calendar-alt text-primary mr-2"></i>{{date('d F,Y', strtotime($item->date_from))}} -  {{date('d F,Y', strtotime($item->date_to))}}</small>
                <small style="float:right;margin-right:inherit;"><a class="" onclick="return confirm('Are you sure want to delete this trip?')" href="{{route('delete.trips', $item->id)}}" >Delete</a>
              </small>
              </div>
              <p class=""><i class="fa fa-user text-primary mr-2"></i>{{$item->number_of}}</p><hr>
              <a class="h5 text-decoration-none">Trip to {{$item['citi']['name']}}, {{ $item->citi->country->country }}</a>
            </div>
          </div>
        </div>
      @endforeach       
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('select').selectize({
      sortField: 'text'
    });
  });
</script>

@endsection