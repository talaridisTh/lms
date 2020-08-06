@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <x-alertMsg :msg="'update'"></x-alertMsg>
    <div class="container" style="max-width:1400px">
        <div class="content">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src=" https://robohash.org/set_set3/bgset_bg1/3.14159?size=500x500"
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

                                <div class="d-flex justify-content-between align-items-center mt-3">
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

                                    <button id="material-modal-shown-btn"  type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#primary-header-modal">Primary Header
                                    </button>
                                    <div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog"
                                         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header modal-colored-header bg-primary">
                                                    <h4 class="modal-title" id="primary-header-modalLabel">Προσθήκη
                                                        Μαθημάτων</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true">×
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @include("components.addCourses")
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-primary">Save changes</button>
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
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#courses" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0  active">
                                        Μαθήματα
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0">
                                        Επεξεργασία χρήστη
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#addCourses" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0">
                                        Προσθήκη σε <b>COURSES</b>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active show" id="courses">
                                    @include("components.FindUserMaterial")
                                    @include("components.findInstructorMaterial")
                                </div>
                                <div class="tab-pane" id="settings">
                                    @include("components.tabsEdit")
                                </div>
                                <div class="tab-pane" id="addCourses">
                                    @include("components.addCourses")
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
    <script>
        $('#alertSumbit').submit(async function (e) {
            e.preventDefault()
            let buttonDelete = $('.js-delete');
            const user = buttonDelete[0].dataset.id;
            try {
                const {value} = await Swal.fire({
                    title: 'Είστε σίγουρος;',
                    text: "αρχεία θα διαγραφούν",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ναί, διαγραφή!',
                    cancelButtonText: 'Άκυρο'
                });
                if (value) {
                    const res = await axios.post(`/dashboard/users/${user}`)
                    Swal.fire({
                        toast: 'true',
                        position: 'top-end',
                        icon: 'success',
                        title: "Διαγράφηκαν",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    window.location = `http://127.0.0.1:8000/dashboard/users`;
                }
            } catch (e) {
                Swal.fire({
                    toast: 'true',
                    position: 'top-end',
                    icon: 'error',
                    title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }


        });

        $(".course-materials-list").DataTable({
            "columnDefs": [
                {"width": "5%", "targets": 0}
            ],
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: "Αποτελέσματα ανα σελίδα: _MENU_",
                loadingRecords: "Φόρτωση ...",
                processing: "Επεξεργασία ...",
                search: "Αναζήτηση: ",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
                $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
            },

        });

        const addCourse = $("#datatableAddCourse").DataTable({
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            scrollX: !0,
            "columnDefs": [
                {"width": "5%", "targets": 1}
            ],
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: "Αποτελέσματα ανα σελίδα: _MENU_",
                loadingRecords: "Φόρτωση ...",
                processing: "Επεξεργασία ...",
                search: "Αναζήτηση: ",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
                $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
            },

        });


        $('#material-modal-shown-btn').click(function () {
            setTimeout(function () {
                addCourse.columns.adjust();
            }, 200)
        });

        $(".js-button").click(function() {
           const parent =  this.parentElement.parentElement
            console.log(parent);


            const test = this.dataset.exist;

            // console.log(test=="")

        })



        $(".js-button").click(async function () {

            try {
                // const res = await axios.patch('/addCourses', {
                //     "course_id": this.dataset.courseId,
                //     "user_id": this.dataset.user,
                //
                // })
                // console.log(this.dataset)

            } catch (e) {
                console.log(e)
            }


        })


    </script>
@endsection
