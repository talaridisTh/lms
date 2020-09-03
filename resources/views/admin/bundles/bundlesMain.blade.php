@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<div id="new-bundle-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="new-bundle-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header modal-colored-header bg-primary">
				<h4 class="modal-title" id="new-bundle-modalLabel">Νέο Bundle</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body table-cnt">
				<form id="new-bundle-form" action="bundle/store" method="POST" enctype="multipart/form-data" class="px-3" autocomplete="off">
					
					@csrf
					
					<div class="form-group">
						<label for="name">Όνομα</label>
						<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Δώστε όνομα...">
						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="bundle-cover">Cover</label>
								<div class="input-group">
									<div class="custom-file">
										<input id="bundle-cover" type="file" class="custom-file-input @error('cover') is-invalid @enderror" name="cover">
										<label class="custom-file-label file-search-label-primary" for="bundle-cover">"Εισάγετε αρχείο"</label>
									</div>
									@error('cover')
										<span class="invalid-feedback d-block" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="example-select">Κατάσταση</label>
								<select id="active" class="form-control @error('status') is-invalid @enderror" name="status">
									<option value="1" {{ old('status') == 1 ? "selected" : "" }}>Ενεργό</option>
									<option value="0" {{ old('status') == 0 ? "selected" : "" }}>Ανενεργό</option>
								</select>
								@error('status')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="description">Περιγραφή</label>
						<textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" placeholder="Περιγραφή Bundle...">{{ old('description') }}</textarea>
						@error('description')
						    <span class="invalid-feedback" role="alert">
						        <strong>{{ $message }}</strong>
						    </span>
						@enderror
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button id="submit-form-btn" class="btn btn-primary"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
				<button class="btn btn-light" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
				<a href="courses/create" class="btn btn-primary mb-2" data-toggle="modal" data-target="#new-bundle-modal">
					<i class="mdi mdi-plus-circle mr-2"></i>
					Νέο Bundle
				</a>
				<div class="btn-group mb-2">
					<button type="button" class="btn btn-secondary dropdown-toggle" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
						Επιλογές (0)
					</button>
					<div class="dropdown-menu">
						<a id="delete-bundles-btn" class="dropdown-item" href="#">Διαγραφή</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Export</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<table id="bundle-table" class="table w-100 nowrap js-remove-table-classes custom-center-table center-not-second">
		<thead>
			<tr>
				<th class="text-center option-column">Επιλογή</th>
				<th class="text-center">Ονομασία</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Ημ. Δημιουργίας</th>
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th class="text-center">Επιλογή</th>
				<th class="text-center">Ονομασία</th>
				<th class="text-center">Ενεργό</th>
				<th class="text-center">Τελ. Ενημέρωση</th>
				<th class="text-center">Ημ. Δημιουργίας</th>
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