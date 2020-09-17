@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>


@endsection

@section('content')
    <x-alertMsg :msg="'update'"></x-alertMsg>
    <div class="container-fruid">

		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/users" class="custom-link-primary">Χρήστες</a></li>
							<li class="breadcrumb-item active">Προφίλ χρήστη</li>
						</ol>
					</div>
                    @if(isset($user))
					<h4 class="page-title">{{ $user->last_name }} {{ $user->first_name }}</h4>
                    @endif
				</div>
			</div>
		</div>


        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs mb-3 d-flex">
                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0 active">
                                        Επεξεργασία χρήστη
                                    </a>
                                </li>


                                    <li class="nav-item">
                                        <a href="#courses" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0  {{ !isset($user) ? 'tab-link text-muted' : '' }}  ">
                                            Courses
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="#timeline" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0  {{ !isset($user) ? 'tab-link text-muted' : '' }} ">
                                            Timeline
                                        </a>
                                    </li>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane  active" id="settings">
                                    @include("components.tabsEdit")
                                </div>

                                <div class="tab-pane  "  id="courses">
                                    @include("components.findUserMaterial")
                                </div>
                                <div class="tab-pane  " id="timeline">
                                    @include("components.timelineUser")
                                </div>

                            </div>
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


                </div> <!-- end col-->

            </div>
            <!-- end row-->
        </div> <!-- End Content -->

t
    </div> <!-- content-page -->

@endsection


@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <x-routes></x-routes>


    <script src="{{ asset('js/dashboard/users/userProfil.js') }}"></script>

@endsection
