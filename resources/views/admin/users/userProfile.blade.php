@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

	<style>
		.input-icon {
			padding: 0 0.6rem;
			border: solid #536de6;
			border-width: 1px 1px 0;
		}
	</style>

@endsection

@section('content')

	<div class="modal fade" id="view-homework-modal" tabindex="-1" role="dialog"
		aria-labelledby="view-homework-modalLabel" aria-hidden="true"><!-- View Homework Modal @s-->
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<div id="homework-content" class="modal-body p-0"><!-- Modal-Body @s-->

					<div class="d-flex justify-content-center py-4">
						<div class="spinner-border avatar-md text-primary" role="status"></div>
					</div>

				</div><!-- ./Modal-Body @e-->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./View Homework Modal @e-->

    <div class="container-fruid">
		@include("components.admin.users.coursesModal")
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/users" class="custom-link-primary">Χρήστες</a></li>
							<li class="breadcrumb-item active">{{ $user->last_name }} {{ $user->first_name }}</li>
						</ol>
					</div>

					<h4 id="user-name" class="page-title" data-user-id="{{ $user->id }}">
						{{ $user->last_name }} {{ $user->first_name }}
					</h4>
				</div>
			</div>
		</div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" aria-expanded="false"
                               class="nav-link active">
                                Επεξεργασία
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#courses" data-toggle="tab" aria-expanded="false"
                               class="nav-link">
                                Courses
                            </a>
						</li>
						@if ($userRole === "student")
							<li class="nav-item">
								<a href="#homeworks" data-toggle="tab" aria-expanded="false"
								class="nav-link">
									Εργασίες
								</a>
							</li>
						@endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            @include("components.admin.users.userSettings")
                        </div>
                        <div class="tab-pane"  id="courses">
                            @include("components.admin.users.userCoursesTable")
                        </div>
                        <div class="tab-pane"  id="homeworks">

                            <table id="homeworks-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
								<thead>
									<tr>
										<th class="text-center">Θέμα</th>
										<th class="text-center">Course</th>
										<th class="text-center">Ημ. Καταχώρισης</th>
									</tr>
								</thead>
								<tbody class="tables-hover-effect"></tbody>
								<tfoot>
									<tr>
										<th class="text-center">Θέμα</th>
										<th class="text-center">Course</th>
										<th class="text-center">Ημ. Καταχώρισης</th>
									</tr>
								</tfoot>
							</table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row-->
        </div> <!-- End Content -->
    </div> <!-- content-page -->

@endsection


@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

    <script src="{{ mix('js/dashboard/users/userProfil.js') }}"></script>

@endsection
