@extends('frontend.main_master')
@section('main')


<div class="container">
  <div class="row h-100">
		<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100 " style="min-height:60vh;">
			<div class="d-table-cell "  style="padding-top:54px;">
        <div class="cerceve">
					<div class="text-center mt-4">
						<h1 class="h2">Forgot Password</h1>
						<p class="lead">Enter your email to reset your password.</p>
					</div>
          @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
              {{ Session::get('message') }}
            </div>
          @endif
					<div class="card" >
						<div class="card-body">
							<div class="m-sm-4">
								<form action="{{route('forgot.password.post')}}" method="POST">
                  @csrf
									<div class="form-group" >
										<label>Email</label>
										<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" required>
                    @if ($errors->has('email'))
                      <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
									</div>
									<div class="text-center mt-3">
										<button type="submit" class="btn  buttons">Reset password</button>
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

@endsection