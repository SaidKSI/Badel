@extends('layout')

@section('content')
<main>
	<div class="container">
		<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex justify-content-center py-4">
							<a class="logo d-flex align-items-center w-auto" href="index.html">
								<img alt="" src="assets/img/logo.png" />
								<span class="d-none d-lg-block">Entrepôt</span>
							</a>
						</div>
						<!-- End Logo -->

						<div class="card mb-3">
							<div class="card-body">
								<div class="pt-4 pb-2">
									<h5 class="card-title text-center pb-0 fs-4">
										Connectez-vous à votre compte
									</h5>
									<p class="text-center small">
										Entrez votre nom d'utilisateur et votre mot de passe pour vous connecter
									</p>
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

									{{-- <div class="col-12">
										<div class="form-check">
											<input class="form-check-input" id="rememberMe" name="remember" type="checkbox" value="true" />
											<label class="form-check-label" for="rememberMe">Remember me</label>
										</div>
									</div> --}}
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
									<div class="col-12">
										<p class="small mb-0">
											Vous n'avez pas de compte ?
											<a href="/register">Créer un compte</a>
										</p>
									</div>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>
	</div>

	</section>
</main>
@endsection