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
                            <div class="text-sm-right">
                                <div class="btn-group mb-2 ">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Επιλογές
                                    </button>
                                    <div class="dropdown-menu">
                                        <a id="material-modal-shown-btn" type="button" class="dropdown-item"
                                           data-toggle="modal"
                                           data-target="#primary-header-modal">Προσθήκη COURSES
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item js-chexbox-delete" href="#">Διαγραφή επιλεγμένων</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Export</a>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#courses" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0  active">
                                        Courses
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0">
                                        Επεξεργασία χρήστη
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active show" id="courses">
                                    @include("components.FindUserMaterial")
                                </div>
                                <div class="tab-pane" id="settings">
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
    <script>


        const userId = $(".course-materials-list")[0].dataset.id
        const courses = $(".course-materials-list").DataTable({
            scrollX: !0,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route("show.datatable")}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                data: {
                    userId: userId
                }

            },
            columns: [
                {data: 'chexbox', name: 'chexbox'},
                {data: 'name', name: 'name'},
                {data: 'students', name: 'students'},
                {data: 'action', name: 'action'},
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
                deleteMultipleCourse()
            },

        });
        const addCourse = $("#datatableAddCourse").DataTable({
            scrollX: !0,
            processing: true,
            serverSide: true,

            ajax: {
                url: "{{route("courseModal.datatable")}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                data: {
                    userId: userId
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},

            ],
            columnDefs: [
                {"width": "5%", "targets": 1},

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
                addCourseToUser()
                deleteCourse()


            }


        });

        function deleteCourse() {
            $('.js-button-delete').unbind();
            $(".js-button-delete").click(async function () {
                try {
                    let {status} = await axios.delete("{{route('destroy.datatable')}}", {
                        data: {
                            'course_id': this.dataset.courseId,
                            'user_id': userId
                        }
                    })
                    if (status == 200) {
                        sweetAlert(`${this.dataset.courseName}  Διεγραφη`, 'error')
                        courses.ajax.reload();
                        addCourse.ajax.reload();
                    }
                } catch (e) {
                    sweetAlert("Παρουσιάστηκε κάποιο πρόβλημα", 'error')
                }


                console.log(this)
            })
        }

        function addCourseToUser() {
            $('.js-button').unbind();
            let ids = [];


            let jsButton = $(".js-button").click(async function () {
                const parent = this.parentElement.parentElement
                if (parent.dataset.exist) {
                    sweetAlert(`${this.dataset.courseName}  αφαιρεθηκε`, 'warning')
                    ids = ids.filter(val => val !== this.dataset.courseId);
                    this.value = 'Επιλογη'
                    this.classList.remove("btn-danger")
                    this.classList.add("btn-primary")
                    delete parent.dataset.exist
                } else {
                    if (!ids.includes(this.dataset.courseId)) {
                        ids.push(this.dataset.courseId)
                    }
                    sweetAlert(`${this.dataset.courseName} Επιλέχθηκε`, 'success')
                    this.classList.remove("btn-primary")
                    this.classList.add("btn-danger")
                    this.value = 'Αφαιρεση'
                    parent.dataset.exist = true
                }


            })


            $(".modal-save").click(async function () {
                await sweetAlert(`${ids.length} COURSES Προσθεθηκαν`, 'success')
                const parent = this.parentElement.parentElement
                let id = [];

                const courseName = [...ids];
                console.log(ids)

                // if (id.indexOf(ids[0]) === -1) {
                //     id.push(ids[0])
                //     ids.shift();
                // }
                try {
                    const res = await axios.patch('{{route("addcourses.datatable")}}', {
                        "course_id": ids,
                        "user_id": userId,
                    })

                    courses.ajax.reload();

                } catch (e) {
                    console.log(e)
                }

            })


        }

        function deleteMultipleCourse() {
            $('.js-chexbox-delete').unbind();
            $('.js-chexbox-delete').click(async function () {

                let checkedBoxes = $('.js-checkbox:checked');

                // if ( checkedBoxes.length == 0 ) {
                //     Swal.fire('Δεν έχετε επιλέξει τίποτα');
                //     return;
                // }

                let ids = [];

                for (let i = 0; i < checkedBoxes.length; i++) {
                    ids.push(checkedBoxes[i].dataset.courseId);
                }

                try {
                    let {status} = await axios.delete("{{route('destroyMultiple.datatable')}}", {
                        data: {
                            'course_id': ids,
                            'user_id': userId
                        }

                    })
                    if (status == 200) {
                        sweetAlert(`${ids.length}  Διεγραφηκαν`, 'error')
                        courses.ajax.reload();
                        addCourse.ajax.reload();
                    }

                } catch (e) {
                    sweetAlert("Παρουσιάστηκε κάποιο πρόβλημα", 'error')
                }

                //
                // console.log(res);


            })
        }


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
                    const res = await axios.post(`/dashboard/users/${user}`, {_method: 'DELETE'})
                    sweetAlert("Διεγράφη", 'success')
                    window.location = `http://127.0.0.1:8000/dashboard/users`;
                }
            } catch (e) {
                sweetAlert("Παρουσιάστηκε κάποιο πρόβλημα", 'error')
            }


        });

        $(".modal-dismiss").click(() => {
            addCourse.ajax.reload();
        })

        $(".close").click(() => {
            addCourse.ajax.reload();
        })

        $('#material-modal-shown-btn').click(function () {
            setTimeout(function () {
                addCourse.columns.adjust();
            }, 200)
        });

        let sweetAlert = (title, icon) => {
            Swal.fire({
                toast: 'true',
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

        }

    </script>
@endsection
