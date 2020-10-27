@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
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
							<li class="breadcrumb-item active">Bundles</li>
						</ol>
					</div>
					<h4 class="page-title">Bundles</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

<div class="container table-cnt content-width">
	<div class="row mb-2">
		<div class="col-sm-4"></div>
		<div class="col-sm-8">
			<div class="text-sm-right">
				<a href="/dashboard/bundles/create" class="btn btn-primary mb-2" {{-- data-toggle="modal" data-target="#new-bundle-modal" --}}>
					<i class="mdi mdi-plus-circle mr-2"></i>
					Νέο Bundle
				</a>
				<div class="btn-group mb-2">
					<button id="bundle-bult-btn" type="button" class="btn btn-secondary dropdown-toggle"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
						Επιλογές (0)
					</button>
					<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right">
						<a id="delete-bundles-btn" class="dropdown-item" href="#">Διαγραφή</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<table id="bundle-table" class="table w-100 nowrap js-remove-table-classes center-not-second">
		<thead>
			<tr>
				<th class="text-center option-column">
					<div class='icheck-primary d-inline'>
						<input type='checkbox' id='select-all-bundles' autocomplete='off'>
						<label for='select-all-bundles'></label>
					</div>
				</th>
				<th class="text-center">Τίτλος</th>
				<th class="text-center">Κατάσταση</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Publish</th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th class="text-center"></th>
				<th class="text-center">Τίτλος</th>
				<th class="text-center">Κατάσταση</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Publish</th>
			</tr>
		</tfoot>
	</table>
</div>
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

	<script src="{{ mix('js/dashboard/bundles/bundlesMain.js') }}"></script>

	@if ( count($errors) > 0 )
		<script>
			$('#new-bundle-modal').modal('show')
		</script>
	@endif
@endsection
