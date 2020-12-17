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
    <div class="container-fruid">

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
                        <li class="nav-item">
                            <a href="#timeline" data-toggle="tab" aria-expanded="false"
                               class="nav-link">
                                Timeline
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            @include("components.admin.users.editUser")
                        </div>
                        <div class="tab-pane"  id="courses">
                            @include("components.findUserMaterial")
                        </div>
                        <div class="tab-pane" id="timeline">
                            @include("components.timelineUser")
                        </div>
                    </div>

                </div>
                <!-- modal -->
                <div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header modal-colored-header bg-primary">
                                <h4 class="modal-title" id="primary-header-modalLabel">Προσθήκη
                                    Courses</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×
                                </button>
                            </div>
                            <div class="modal-body">
                                @include("components.addCourses")
                            </div>
							@include("components.admin.users.bulkActionUserAddCourses")
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

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
