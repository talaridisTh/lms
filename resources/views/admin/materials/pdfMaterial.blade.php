@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')

	<div class="modal fade" id="remainings-pdf-modal" tabindex="-1" role="dialog"
		aria-labelledby="remainings-pdf-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="remainings-pdf-modalLabel">PDF Library</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				
					<table id="remaining-pdf-datatable"
						class="table w-100 nowrap center-not-second modal-table js-remove-table-classes">
						<thead>
							<tr>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Μέγεθος</th>
								<th class="text-center w-5"></th>
							</tr>
						</thead>
						<tbody class="tables-hover-effect"></tbody>
						<tfoot>
							<tr>
								<th class="text-center">Όνομα</th>
								<th class="text-center">Μέγεθος</th>
								<th class="text-center"></th>
							</tr>
						</tfoot>
					</table>
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div>

	<!-- start page title -->
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/materials" class="custom-link-primary">Υλικό</a></li>
							<li class="breadcrumb-item active">{{ $material->title }}</li>
						</ol>
					</div>
					<h4 id="material-title" class="page-title" data-material-id="{{ $material->id }}">{{ $material->title }}</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="wrapper">
		<div class="content">

			<ul class="nav nav-tabs nav-bordered mb-3">
				<li class="nav-item">
					<a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link active">
						<i class="mdi mdi-home-variant d-md-none d-block"></i>
						<span class="d-none d-md-block">Ρυθμίσεις</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="#pdf-viewer" data-toggle="tab" aria-expanded="false" class="nav-link">
						<i class="mdi mdi-home-variant d-md-none d-block"></i>
						<span class="d-none d-md-block">PDF Viewer</span>
					</a>
				</li>
			</ul><!-- ./nav-tabs -->

			<div class="tab-content">
				<div class="tab-pane show active" id="settings">
					<div class="row">
						<div class="col-xl-9 col-lg-8 col-md-12">

							<form id="edit-pdf-material" action="/dashboard/materials/update/{{ $material->slug }}" method="post" autocomplete="off">
								
								@csrf
								@method('PATCH')
								<input type="text" name="type" value="PDF" hidden />
								<div class="form-group">
									<label for="title">Τίτλος <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="title" name="title" value="{{ $material->title }}" placeholder="Εισάγετε τίτλο...">
								</div>
								<div class="form-group">
									<label for="subtitle">Υπότιτλος</label>
									<input type="text" class="form-control" name="subtitle" value="{{ $material->subtitle }}" placeholder="Εισάγετε υποτίτλο...">
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between">

										<label for="description">Περιγραφή</label>
										<input id="description-toggle" class="js-editors-toggle"
											data-field="description" type="checkbox" data-switch="success"
											@if ( isset($fields->description) && $fields->description == 1)
												checked
											@endif
										/>
										<label class="mb-0" for="description-toggle" data-on-label="On" data-off-label="Off"></label>

									</div>
									<textarea id="description" type="text" class="form-control" name="description" rows="5"
										placeholder="Εισάγετε περιγραφή..." >{{ $material->description }}</textarea>
								</div>
							</form>
						</div>
						<div class="col-xl-3 col-lg-4 col-md-12">
							<div class="sticky py-3 mt-1">
								<button form="edit-pdf-material" class="btn btn-info btn-block" type="submit">
									Update
								</button>
							</div>

							<div class="card">
								<div class="card-body">

									<div class="form-group mb-1">
										<div class="d-flex justify-content-between">
											<label class="mb-0" for="material-status">Κατάσταση</label>
											<input id="material-status" name="status" type="checkbox" data-switch="success" {{ $material->status === 1 ? "checked" : "" }}>
											<label for="material-status" data-on-label="On" class="mb-0" data-off-label="Off"></label>
										</div>
									</div>

									<hr>
                                	<div class="form-group mb-0">
                                	    <label for="instructorMaterial">
                                	        Εισηγητές
                                	    </label>
                                	    <select form="edit-pdf-material" name="instructors[]" multiple id="instructorMaterial"
                                	        class="form-control" data-toggle="select2"
                                	        data-placeholder="Επιλέξτε instructor...">
                                	        @php
												foreach ( $instructors as $instructor ) {
													if ( old("instructors") != "" && in_array($instructor->id, old("instructors")) ) {

														echo "<option value='$instructor->id' selected>$instructor->last_name $instructor->first_name</option>";
														continue;

													}
													elseif ( old("instructors") == "" && isset($material) &&
														in_array($instructor->id, $activeInstructors) ) {

														echo "<option value='$instructor->id' selected>$instructor->last_name $instructor->first_name</option>";
														continue;
													}
													
													echo "<option value='$instructor->id'>$instructor->last_name $instructor->first_name</option>";
												}
                                	        @endphp
                                	    </select>
                                	</div>

								</div>
							</div>

							<div class="card d-block">
								<div class="card-header">
									<h5 class="card-title mb-0">Αρχείο Μαθήματος</h5>
								</div>
								<div class="card-body pt-1 text-center">
									<i class="mdi mdi-file-pdf-outline text-danger" style="font-size: 60px;"></i>
									<h5 id="pdf-title" class="card-title text-center mb-0">
										{{ is_null($pdf->mediaDetails) ? $pdf->original_name : $pdf->mediaDetails->title }}
									</h5>
									<p id="pdf-name" class="card-text text-center">{{ $pdf->name }}.{{ $pdf->ext }}</p>
									<button class="btn btn-primary btn-block" data-toggle="modal"
										data-target="#remainings-pdf-modal">Αλλαγή</button>
								</div> <!-- end card-body-->
							</div>
						</div>
					</div>
				</div><!-- ./settings-tab -->
				<div class="tab-pane" id="pdf-viewer">

					<embed id="pdf-embed" src="{{ $pdf->rel_path }}" type="application/pdf" width="100%" height="100%" style="height: 100vh" />

				</div><!-- ./pdf-viewer-tab -->

			</div><!-- ./tab-content -->


		</div><!-- ./content -->
	</div><!-- ./wrapper -->
@endsection

@section('scripts')
	<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
	<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
	<script src="/assets/js/vendor/dataTables.buttons.min.js"></script>

	<script src="{{ mix("js/dashboard/materials/pdfMaterial.js") }}"></script>
@endsection
