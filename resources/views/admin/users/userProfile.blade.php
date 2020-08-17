@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@php
    $isActive = count( $errors )>0? "" : "active";
    $isnotActive = count( $errors )>0? "active" : "";

@endphp


@section('content')
    <x-alertMsg :msg="'update'"></x-alertMsg>
    <div class="container" style="max-width:1400px">
        <div class="content">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{$user->avatar}}"
                                 class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
                            <div class="text-left mt-5">
                                <p class="text-muted mb-2 font-13"><strong>Όνομα :</strong> <span class="ml-2">
                                        {{$user->first_name}}
                                    </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Επώνυμο :</strong> <span class="ml-2">
                                        {{$user->last_name}}
                                    </span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ml-2 ">{{$user->email}}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Active :</strong> <span
                                        class="ml-2">{{$user->active == 1 ? 'Ενεργος' : "Ανενεργος"}}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Ρολος :</strong> <span
                                        class="ml-2">    {{$userIs }}</span></p>


                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <div>
                                        <form method="POST" id="alertSumbit"
                                              action="{{route('user.destroy',$user->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Διαγραφη {{$user->fullName}}"
                                                   data-id="{{ $user->id }}"
                                                   class=" js-delete btn btn-danger "/>
                                        </form>
                                    </div>


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
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light modal-dismiss"
                                                            data-dismiss="modal">
                                                        Κλείσιμο
                                                    </button>
                                                    <button type="button" onClick="window.location.reload();"
                                                            class="btn btn-primary modal-save">Προσθήκη
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->


                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->


                </div> <!-- end col-->

                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group mb-2 ">
                                <a id="material-modal-shown-btn" type="button" class="btn btn-secondary mr-2 text-light"
                                   data-toggle="modal"
                                   data-target="#primary-header-modal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Προσθήκη COURSES
                                </a>
                                </div>
                                <div class="btn-group mb-2 ">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Επιλογές
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item js-chexbox-delete" href="#">Διαγραφή επιλεγμένων</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Export</a>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#courses" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0  {{$isActive}} ">
                                        Courses
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0 {{$isnotActive}} ">
                                        Επεξεργασία χρήστη
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane {{$isActive}} "  id="courses">
                                    @include("components.FindUserMaterial")
                                </div>
                                <div class="tab-pane {{$isnotActive}} " id="settings">
                                    @include("components.tabsEdit")
                                </div>
                            </div>
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
    <x-routes></x-routes>
    <script src="{{ mix('js/dashboard/users/userProfil.js') }}"></script>

@endsection
