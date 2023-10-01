<!doctype html>
<html lang="en">
  <head>
  	<title>CutaCuti - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{asset('asetlogin/css/style.css')}}">

	</head>
	<body class="img js-fullheight" style="background-image: url(asetlogin/images/carousel-1.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">CutaCuti</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Login</h3>
		      	<form method="POST" action="{{ route('login') }}" class="signin-form">
                    @csrf
		      		<div class="form-group">
		      			<input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

                          @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
		      		</div>
	            <div class="form-group">
	              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password" required>
                  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
	            </div>
                <hr><hr>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Masuk</button>
	            </div>
                <hr>
	          </form>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{asset('asetloginjs/jquery.min.js')}}"></script>
  <script src="{{asset('asetlogin/js/popper.js')}}"></script>
  <script src="{{asset('asetlogin/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('asetlogin/js/main.js')}}"></script>

	</body>
</html>

