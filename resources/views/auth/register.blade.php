@extends('layout')

@section('content')
	<main>
		<div class="container">
			<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
							<div class="d-flex justify-content-center py-4">
								<a class="logo d-flex align-items-center w-auto"
									href="index.html">
									<img alt=""
										src="assets/img/logo.png" />
									<span class="d-none d-lg-block">Entrepôt</span>
								</a>
							</div>
							<!-- End Logo -->

							<div class="card mb-3">
								<div class="card-body">
									<div class="pt-4 pb-2">
										<h5 class="card-title text-center pb-0 fs-4">
											Créer un compte
										</h5>
										<p class="text-center small">
											Entrez vos informations personnelles pour créer un compte
										</p>
									</div>

									<form action="{{ route('user.register') }}"
										class="row g-3 needs-validation"
										method="POST">
										@csrf
										<div class="col-12">
											<label class="form-label"
												for="yourName">nom et prénom</label>
											<input class="form-control"
												id="yourName"
												name="name"
												required
												type="text" />
											<div class="invalid-feedback">
												Please, enter your name!
											</div>
										</div>

										<div class="col-12">
											<label class="form-label"
												for="yourEmail">Numéro de téléphone</label>
											<input class="form-control"
												id="yourphone"
												name="phone_number"
												required
												type="number" />
											<div class="invalid-feedback">
												Please enter a valid Email adddress!
											</div>
										</div>

										<div class="col-12">
											<label class="form-label"
												for="yourUsername">Votre e-mail</label>
											<div class="input-group has-validation">
												<span class="input-group-text"
													id="inputGroupPrepend">@</span>
												<input class="form-control"
													id="yourEmail"
													name="email"
													required
													type="email" />
												<div class="invalid-feedback">
													Please choose a username.
												</div>
											</div>
										</div>

										<div class="col-12">
											<label class="form-label"
												for="yourPassword">Mot de passe</label>
											<input class="form-control"
												id="yourPassword"
												name="password"
												required
												type="password" />
											<div class="invalid-feedback">
												Please enter your password!
											</div>
										</div>

										<div class="col-12">
											<div class="form-check">
												<input class="form-check-input"
													id="acceptTerms"
													name="terms"
													required
													type="checkbox"
													value="" />
												<label class="form-check-label"
													for="acceptTerms">Je suis d'accord et j'accepte les
													<a href="#">termes et conditions</a></label>
												<div class="invalid-feedback">
													You must agree before submitting.
												</div>
											</div>
										</div>
										<div class="col-12">
											<button class="btn btn-primary w-100"
												type="submit">
												Créer un compte
											</button>
										</div>
										<div class="col-12">
											<p class="small mb-0">
												Vous avez déjà un compte?
												<a href="/login">Connexion</a>
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
