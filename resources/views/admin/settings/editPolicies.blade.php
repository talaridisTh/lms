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
			top: 150px;
			background: #404954;
			z-index: 1000;
		}
	</style>
@endsection

@section('content')

	@php
		switch ($option->name) {
			case "terms":
				$title = "Terms of Use";
				break;
			case "privacyPolicy":
				$title = "Privacy Policy";
				break;
			default:
				$title = "Cookie Policy";
		}
	@endphp

	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">{{ $title }}</li>
						</ol>
					</div>
					<h4 class="page-title">{{ $title }}</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->
	
	
	<div class="container content-width">
		<form action="/dashboard/options/{{$option->name}}/update" method="POST" autocomplete="off">
			
			@csrf

			<div class="form-group">
				<div class="d-flex justify-content-between  sticky-btns">
					<label for="editor" class="d-flex align-items-end">{{ $title }}</label>
					<div class="py-2">
						<button type="submit" class="btn btn-primary">
							Save
						</button>
					</div>
				</div>
				<textarea class="form-control" id="editor" placeholder="Εισάγετε {{ $title }}..."
					name="content" rows="5">{{ $option->value }}</textarea>
			</div>
		</form>
	</div>

@endsection

@section('scripts')

<script>
	$R("#editor", {
		buttons: [
			'html', 'undo', 'redo', 'format',
			'bold', 'underline', 'italic', 'deleted',
			'sup', 'sub', 'lists', 'file', 'link'
		],
		minHeight: '400px',
		toolbarFixed: false
	})
</script>
	
@endsection