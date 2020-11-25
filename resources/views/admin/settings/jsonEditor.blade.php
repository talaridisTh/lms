@extends('layouts.dashboard')

@section('css')
<style type="text/css" media="screen">
    #editor {
		width: 100%;
		padding-top: 50%;
    }
</style>
@endsection

@section('content')
{{-- @dump($title) --}}
	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/options" class="custom-link-primary">Options</a></li>
							<li class="breadcrumb-item active">{{ isset($option) ? $option->name : "Νέο Json" }}</li>
						</ol>
					</div>
					<h4 id="page-title" class="page-title">{{ isset($option) ? $option->name : "Νέο Json" }}</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->

	<div class="container content-width">
		<div class="d-flex justify-content-end" style="margin-bottom: 29px">
			<button form="json-form" type="submit" class="btn btn-primary">
				Save
			</button>
		</div>
		<div class="card">
			<div class="card-body">
				<form id="json-form" action="{{ isset($option) ? "/dashboard/option/$option->id/update-json" : "/dashboard/option/store-json" }}" method="post" autocomplete="off">

					@csrf

					@if ( isset($option) )
						@method('PATCH')
					@endif

					<div class="form-group">
						<label for="name-input">Name</label>
						<input id="name-input" class="form-control @error('name') is-invalid @enderror" type="text" name="name"
							value="{{ isset($option) ? $option->name : "" }}" placeholder="Εισάγετε όνομα...">
							@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
					</div>

					<label for="name-input">Value</label>
					<div id="editor">{{ isset($option) ? $value : "" }}</div>

					<textarea id="json-area" class="@error('json') is-invalid @enderror" name="json" rows="5" hidden></textarea>
					@error('json')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</form>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ mix("js/dashboard/settings/json-editor.js") }}"></script>
@endsection