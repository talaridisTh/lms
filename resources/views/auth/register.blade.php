@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<!-- Logo -->
				<h4 class="card-header bg-primary text-white">
					Register
				</h4>
			
				<div class="card-body p-4">
				<form method="POST" action="{{ route('register') }}">

						@csrf

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="first-name" class="text-white">Όνομα</label>
								<input type="text" class="form-control" id="first-name" name="firstName" placeholder="Όνομα">
							</div>
							<div class="form-group col-md-6">
								<label for="last-name" class="text-white">Επώνυμο</label>
								<input type="text" class="form-control" id="last-name" name="lastName" placeholder="Επώνυμο">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="text-white">Email</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="Email">
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="password" class="text-white">Κωδικός</label>
								<div class="input-group input-group-merge">
								    <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
								    <div class="input-group-append" data-password="false">
								        <div class="input-group-text">
								            <span class="password-eye"></span>
								        </div>
								    </div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="confirm-password" class="text-white">Επιβεβαίωση Κωδικού</label>
								<div class="input-group input-group-merge">
								    <input type="password" id="confirm-password" class="form-control" name="password_confirmation" placeholder="Enter your password">
								    <div class="input-group-append" data-password="false">
								        <div class="input-group-text">
								            <span class="password-eye"></span>
								        </div>
								    </div>
								</div>
							</div>
						</div>
						<div class="form-group mt-2 mb-0 text-center">
							<button class="btn btn-primary" type="submit">Εγγραφή</button>
						</div>
						
					</form>
				</div> <!-- end card-body-->

			</div>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
@endsection
