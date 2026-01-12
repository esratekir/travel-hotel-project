<div class="container-fluid bg-registration py-2 my-5">
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="mb-4">
          <p class="text-white" style="font-size:1.3rem;">{{$home_kayit->title}}</p>
        </div>
        <p class="text-white" style="font-size:1.3rem;">{{$home_kayit->subtitle}}</p>
        <ul class="list-inline text-white m-0">
          <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Create a trip</li>
          <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Get offers from locals</li>
          <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Pick the one you like</li>
        </ul>
      </div>
      <div class="col-lg-4">
        <div class="card border-0">
          <div class="card-header bg-primary text-center p-4">
            <h4 class="text-white m-0">Sign Up Now</h4>
          </div>
          <div class="card-body rounded-bottom bg-white  home-kayit">
            <form method="post" action="{{ route('guide.register')}}">
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
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-1">
                    <i class="fas fa-user "></i>
                  </div>
                  <div class="col-lg-11">
                    <input type="text" name="name" value="{{ $guide_reg->name ?? '' }}" class="form-control" placeholder="Your name" required="required">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-1">
                    <i class="fas fa-envelope "></i>
                  </div>
                  <div class="col-lg-11">
                    <input type="email" name="email" value="{{ $guide_reg->email ?? '' }}" class="form-control" placeholder="Your email" required="required">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-1">
                    <i class="fas fa-phone-alt "></i>
                  </div>
                  <div class="col-lg-11">
                    <input type="text" name="phone" value="{{ $guide_reg->phone ?? '' }}" class="form-control" placeholder="+01234567890" required="required" maxlength="15" onkeypress="validate(event)">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center">
                  <div class="col-lg-1"></div>
                  <div class="col-lg-11">
                    <button class="btn buttons btn-block but-kayit" type="submit" style="padding:7px;">Register</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Rehber kayıt işleminin ilk adımındaki telefon numarasının yalnızca 0-9 arası rakam ve + değerlerini içerebileceği kuralının yazıldığı javascript kodu -->
<script>
  function validate(evt) {
    var theEvent = evt || window.event;
    // Handle paste
    if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
    } else {
      // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\+/;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }
</script>