@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

	<div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h4 class="modal-title" id="primary-header-modalLabel">Νέο Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body table-cnt">
					<form class="px-3">
						<div class="form-group">
							<label for="name">Όνομα</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Δώστε όνομα">
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="course-cover">Cover</label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="cover" id="course-cover">
											<label class="custom-file-label file-search-label-primary" for="course-cover">"Εισάγετε αρχείο"</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="example-select">Κατάσταση</label>
									<select class="form-control" id="active">
										<option value="1">Ενεργό</option>
										<option value="0" selected>Ανενεργό</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="description">Περιγραφή</label>
							<textarea class="form-control" id="description" name="description" rows="4" placeholder="Write something..."></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					{{-- <button id="add-remaingings-btn" type="button" class="btn btn-primary">Προσθήκη Επιλογών</button> --}}
					<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save mr-1"></i>Αποθήκευση</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

    <div class="container table-cnt" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
                <div class="text-sm-right">
					<a href="courses/create" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#primary-header-modal"><i class="mdi mdi-plus-circle mr-2"></i>
						Νέο Course
					</a>
					<div class="btn-group mb-2">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Επιλογές</button>
						<div class="dropdown-menu">
							<a id="delete-courses-btn" class="dropdown-item" href="#">Διαγραφή</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Προσθήκη σε Bundle</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Export</a>
						</div>
					</div>
				</div>
            </div>
        </div>

        <table id="courses-datatable" class="table w-100 nowrap custom-center-table center-not-second js-remove-table-classes">
            <thead>
            	<tr>
            	    <th class="text-center option-column">Επιλογή</th>
            	    <th class="text-center">Όνομα</th>
            	    <th class="text-center">Ενεργό</th>
            	    <th class="text-center">Τελ. Ενημέρωση</th>
            	    <th class="text-center">Ημ. Δημιουργίας</th>
            	</tr>
            </thead>
            <tbody class="tables-hover-effect"></tbody>
            <tfoot>
            	<tr>
            	    <th class="text-center">Επιλογή</th>
            	    <th class="text-center">Όνομα</th>
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

<script src="{{ mix('js/dashboard/courses/coursesMain.js') }}"></script>

@endsection
