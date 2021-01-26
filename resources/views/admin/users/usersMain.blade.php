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
							<li class="breadcrumb-item active">Χρήστες</li>
						</ol>
					</div>
					<h4 class="page-title">Χρήστες</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

    <div class="container content-width table-cnt">
        <div class="row mb-2 justify-content-end">
            <div id="containerCol" class="col-sm-12">
                <div class="text-right">
                    <a href="/dashboard/users/create" class="btn btn-primary mb-2"><i
                            class="mdi mdi-plus-circle mr-2"></i>
                        Νέος χρήστης
                    </a>
					<div class="btn-group mb-2">
						<button id="course-bulk-action-btn" disabled type="button" class="btn btn-secondary dropdown-toggle"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Επιλογές (0)
						</button>

						<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right py-0">
							<div class="btn-group dropleft dropleft-hover w-100">
								<button type="button" id="status-dropdown" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false">
									Αλλαγή κατάστασης
								</button>
								<div class="dropdown-menu py-0" aria-labelledby="status-dropdown">
									<a class="dropdown-item js-multiple-change cursor-pointer py-2" data-courses-change="on">Ενεργά</a>
									<a class="dropdown-item js-multiple-change cursor-pointer py-2" data-courses-change="off">Μη ενεργά</a>
								</div>
							</div>

							<div class="dropdown-divider m-0"></div>

							<div class="btn-group dropleft dropleft-hover w-100">
								<button type="button" id="export-dropdown" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false">
									Export
								</button>
								<div class="dropdown-menu py-0" aria-labelledby="export-dropdown">
									<a href="#" id="excel-btn" class="dropdown-item py-2">Excel</a>
								</div>
							</div>
						</div>
					</div>

                </div>
            </div>
        </div>
       @include("components.filterDatatableUser")
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table js-remove-table-classes ">
            <thead>
            <tr>
                <th id='all-user-checkbox' class="text-left ">
                    <div class='icheck-primary d-inline'>
                        <input type='checkbox' id='select-all-courses' autocomplete='off'>
                        <label for='select-all-courses'></label>
                    </div>
                </th>
                <th class="text-center">Ονοματεπώνυμο</th>
                <th class="text-center">Courses</th>
                <th class="text-center">Όνομα</th>
                <th class="text-center">Ρόλος</th>
                <th class="text-center">Τηλέφωνο</th>
                <th class="text-center">Email</th>
                <th class="text-center">Κατάσταση</th>
                <th class="text-center">Ημ.Εγγραφής</th>
                <th class="text-center">Δραστηριότητα</th>
            </tr>
            </thead>
            <tbody class="tables-hover-effect"></tbody>
            <tfoot>
            <tr>
                <th></th>
                <th class="text-center">Ονοματεπώνυμο</th>
                <th class="text-center">Courses</th>
                <th class="text-center">Όνομα</th>
                <th class="text-center">Ρόλος</th>
                <th class="text-center">Τηλέφωνο</th>
                <th class="text-center">Email</th>
                <th class="text-center">Κατάσταση</th>
                <th class="text-center">Ημ.Εγγραφής</th>
                <th class="text-center">Δραστηριότητα</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')

    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
    <x-routes></x-routes>
    <script src="{{ mix('js/dashboard/users/userMain.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#course-filter").select2({
                // placeholder: "Όλα τα Courses ",

                // minimumInputLength: 2,
            });

            $("#rolesFilter").select2({
                // placeholder: "Όλοι οι ρόλοι",
                minimumResultsForSearch: -1,

            });

            $("#activeFilter").select2({
                minimumResultsForSearch: -1,
                // placeholder: "Κατάσταση",

            });
            $(".custom-select").select2({
                minimumResultsForSearch: -1,


            });
        })
    </script>

    <script>


    </script>.

@endsection
