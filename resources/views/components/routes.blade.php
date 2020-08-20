<script>
    // global app configuration object
    const config = {
        routes: {
            //simple routes
            userIndex: "{{ route("user.index") }}",
            //datatable routes
            indexDatatable: "{{ route("index.datatable") }}",
            showDatatable: "{{ route("show.datatable") }}",
            destroyDatatable: "{{ route("destroy.datatable") }}",
            //ajax routes
            changeStatusDatatable: "{{ route("changeStatus.datatable") }}",
            addcoursesDatatable: "{{ route("addcourses.datatable") }}",
            destroyMultipleCoursesDatatable: "{{ route("destroyMultipleCourses.datatable") }}",
            destroyMultipleUsersDatatable: "{{ route("destroyMultipleUsers.datatable") }}",
            courseModaDatatable: "{{ route("courseModal.datatable") }}",
            addCoursesMultipleUsersDatatable: "{{ route("addCoursesMultipleUsers.datatable") }}"
        },
        headers:{
            csrf: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        },
        datatable:{
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                @if (\Request::path() == "dashboard/users")
                lengthMenu: "_MENU_",
                @else
                lengthMenu: "_MENU_ Αποτελέσματα ανα σελίδα",
                @endif
                loadingRecords: "Φόρτωση ...",
                processing: "Επεξεργασία ...",
                search: "Αναζήτηση: ",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            buttons:
                    [
                        {
                            extend: 'collection',
                            className: 'btn btn-primary dropdown-toggle',
                            text: 'Ρόλος',
                            autoClose: true,
                            buttons: [
                                {
                                    className: 'dropdown-item',
                                    titleAttr: 'admin',
                                    text: 'admin',
                                    action: function (e, dt, node, config) {
                                        var table = $('#scroll-horizontal-datatable').DataTable();
                                        dt.columns(3).search("admin", true, false, true).draw();
                                        $('#pref').parent().addClass("active");
                                    }
                                },
                                {
                                    className: 'dropdown-item',
                                    titleAttr: 'instructor',
                                    text: 'instructor',
                                    action: function (e, dt, node, config) {
                                        var table = $('#scroll-horizontal-datatable').DataTable();
                                        dt.columns(3).search("instructor", true, false, true).draw();
                                        $('#pref').parent().addClass("active");
                                    }
                                },
                                {
                                    className: 'dropdown-item',
                                    titleAttr: 'partner',
                                    text: 'partner',
                                    action: function (e, dt, node, config) {
                                        var table = $('#scroll-horizontal-datatable').DataTable();
                                        dt.columns(3).search("partner", true, false, true).draw();
                                        $('#pref').parent().addClass("active");
                                    }
                                },
                                {
                                    className: 'dropdown-item',
                                    titleAttr: 'student',
                                    text: 'student',
                                    action: function (e, dt, node, config) {
                                        var table = $('#scroll-horizontal-datatable').DataTable();
                                        dt.columns(3).search("student", true, false, true).draw();
                                        $('#pref').parent().addClass("active");

                                    }
                                }
                            ],
                        },
                        {
                                    className: 'btn-primary px-2 ml-2 border-0',
                                    titleAttr: 'active',
                                    text: 'Ενεργοι',
                                    action: function ( e, dt, node, config ) {
                                        if (dt.column(7).search() === '1') {
                                            this.text('Ενεργοι');
                                            dt.column(7).search(0).draw(true);
                                        } else {
                                            this.text('Μη ενεργοι');
                                            dt.column(7).search(1).draw(true);
                                        }
                                    }
                                },

                            ],

        }
    };
</script>
