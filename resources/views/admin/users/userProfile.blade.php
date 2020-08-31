@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

    <style>
        .border-material{
            background:#343A3F ;
        }
    </style>
@endsection

@php
    $isActive = count( $errors )>0? "" : "active";
    $isnotActive = count( $errors )>0? "active" : "";

@endphp


@section('content')
    <x-alertMsg :msg="'update'"></x-alertMsg>
    <div class="container-fruid">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs mb-3 d-flex">
                                    <li class="nav-item">
                                        <a href="#courses" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0   {{$isnotActive}}">
                                            Courses
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{$isActive}} ">
                                            Επεξεργασία χρήστη
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#timeline" data-toggle="tab" aria-expanded="false"
                                           class="nav-link rounded-0 {{$isnotActive}} ">
                                            Timeline
                                        </a>
                                    </li>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane {{$isnotActive}} "  id="courses">
                                    @include("components.findUserMaterial")
                                </div>
                                <div class="tab-pane  {{$isActive}}" id="settings">
                                    @include("components.tabsEdit")
                                </div>
                                <div class="tab-pane {{$isnotActive}} " id="timeline">
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


                </div> <!-- end col-->

            </div>
            <!-- end row-->
        </div> <!-- End Content -->


    </div> <!-- content-page -->

@endsection


@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <x-routes></x-routes>
    <script src="{{ asset('js/dashboard/users/userProfil.js') }}"></script>

@endsection
