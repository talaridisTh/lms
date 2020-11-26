@extends('layouts.dashboard')

@section('css')
	<style>

		.content-page {
			overflow: initial;
		}
		.wrapper {
			overflow: initial;
		}
		.sticky-btns {
			position: sticky;
			top: 70px;
			z-index: 100;
			background-color: #343a40 !important;
		}
		.page-title {
			line-height: 55px !important;
		}

		.page-title-box .page-title-right {
			margin-top: 9px !important;
		}
		.redactor-toolbar-wrapper {
			position: sticky;
			top: 70px;
			background: #404954;
			z-index: 1000;
		}
	</style>
@endsection

@section('content')

	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/email" class="custom-link-primary">E-Mail</a></li>
							<li class="breadcrumb-item active">Compose</li>
						</ol>
					</div>
					<h4 class="page-title">Compose E-mail</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->
	
	
	<div class="container content-width">
		<div class="mt-1 mb-3 text-right">{{-- an figi to value den mporo na kano isset() sto controller --}}
			<button form="email-form" type="submit" class="btn btn-danger ml-1" name="button" value="send">
				Send
			</button>
			<button form="email-form" type="submit" class="btn btn-dark" name="button" value="draft">
				Set Draft
			</button>
		</div>
		<form id="email-form" action="/dashboard/email" method="POST" autocomplete="off">
			
			@csrf

			<div class="form-group">
				<div class="d-flex">
					<label class="mr-auto" for="recipients-selection">Προς</label>
					<div class="custom-control custom-checkbox">
						<input id="all-partners" class="js-recipients custom-control-input" data-recipients="Όλοι οι Partners" name="recipientsRoles[]" value="partner" type="checkbox">
						<label class="custom-control-label" for="all-partners">Partners</label>
					</div>
					<div class="custom-control custom-checkbox ml-4">
						<input id="all-instructors" class="js-recipients custom-control-input" data-recipients="Όλοι οι εισηγητές" name="recipientsRoles[]" value="instructor" type="checkbox">
						<label class="custom-control-label" for="all-instructors">Εισηγητές</label>
					</div>
					<div class="custom-control custom-checkbox ml-4">
						<input id="all-students" class="js-recipients custom-control-input" data-recipients="Όλοι οι μαθητές" name="recipientsRoles[]" value="student" type="checkbox">
						<label class="custom-control-label" for="all-students">Μαθητές</label>
					</div>
				</div>
				<select class="form-control" id="recipients-selection" name="recipients[]" multiple></select>
			
				@error('recipients')
					<span class="text-danger" role="alert">
						<small><strong>{{ $message }}</strong></small>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="subject">Θέμα</label>
				<input id="subject" class="form-control" type="text" value="{{ old("subject") }}" placeholder="Εισάγετε θέμα..." name="subject" />
				@error('subject')
					<span class="text-danger" role="alert">
						<small><strong>{{ $message }}</strong></small>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="editor">Περιεχόμενο</label>
				<textarea class="form-control @error('content') is-invalid @enderror" id="editor" placeholder="Εισάγετε περιεχόμενο..."
					name="content" rows="5">{{ old('content') }}</textarea>
					@error('content')
						<span class="text-danger" role="alert">
							<small><strong>{{ $message }}</strong></small>
						</span>
					@enderror
			</div>
		</form>
	</div>

@endsection

@section('scripts')
<script src="{{ mix("js/dashboard/mail/compose-email.js") }}"></script>

	
@endsection