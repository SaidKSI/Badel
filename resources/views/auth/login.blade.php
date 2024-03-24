@extends('app.layout')

@section('content')
<main>
	<div class="container">

		<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

						<div class="d-flex justify-content-center py-4">
							<a href="index.html" class="logo d-flex align-items-center w-auto">
							<span class="d-none d-lg-block">Badel Portal</span>
							</a>
						</div><!-- End Logo -->

						<div class="card mb-3">

							<div class="card-body">

								<div class="pt-4 pb-2">
									<h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
									<p class="text-center small">Enter your username & password to login</p>
								</div>

								<form action="{{route('admin_login')}}" class="row g-3 needs-validation" method="POST">
									@csrf
									<div class="col-12">
										<label class="form-label" for="yourUsername">Email</label>
										<div class="input-group has-validation">
											<span class="input-group-text" id="inputGroupPrepend">@</span>
											<input class="form-control" id="yourUsername" name="email" required type="text" />

											<div class="invalid-feedback">
												Please enter your username.
											</div>
										</div>
									</div>

									<div class="col-12">
										<label class="form-label" for="yourPassword">Password</label>
										<input class="form-control" id="yourPassword" name="password" required type="password" />

										<div class="invalid-feedback">
											Please enter your password!
										</div>
									</div>

									
									<div class="col-12">
										@if ($errors->any())
										<div class="alert alert-danger">
											<ul>
												@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
										@endif
									</div>
									<div class="col-12">
										<button class="btn btn-primary w-100" type="submit">
											Connexion
										</button>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>

		</section>

	</div>
</main>
@endsection