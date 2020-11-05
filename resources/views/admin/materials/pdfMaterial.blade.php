@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<!-- start page title -->
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">Υλικό</li>
						</ol>
					</div>
					<h4 class="page-title">Υλικό</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<object data="{{ $pdf->rel_path }}" type="application/pdf" width="100%" height="100%" style="height: 100vh"></object>

@endsection

@section('scripts')

@endsection
