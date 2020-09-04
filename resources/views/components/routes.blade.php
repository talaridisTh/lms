<script>
    // global app configuration object
    const config = {
        routes: {
            //simple routes
            userIndex: "{{ route("user.index") }}",
            //datatable routes
            indexDatatable: "{{ route("index.datatable") }}",
            showDatatable: "{{ route("show.datatable") }}",
            coursesInsideUsersDatatable: "{{ route("coursesInsideUsers.datatable") }}",
            destroyDatatable: "{{ route("destroy.datatable") }}",
            //ajax user routes
            changeStatusDatatable: "{{ route("changeStatus.datatable") }}",
            changeStatusMultipleDatatable: "{{ route("changeStatusMultiple.datatable") }}",
            changeStatusDatatable: "{{ route("changeStatus.datatable") }}",
            addcoursesDatatable: "{{ route("addcourses.datatable") }}",
            destroyMultipleCoursesDatatable: "{{ route("destroyMultipleCourses.datatable") }}",
            destroyMultipleUsersDatatable: "{{ route("destroyMultipleUsers.datatable") }}",
            courseModaDatatable: "{{ route("courseModal.datatable") }}",
            addCoursesMultipleUsersDatatable: "{{ route("addCoursesMultipleUsers.datatable") }}",
            AddMultipleUserCourseDatatable: "{{ route("AddMultipleUserCourse.datatable") }}",
            //ajax material routes
            destroyMultipleMaterialDatatable : "{{ route("destroyMultipleMaterials.datatable") }}",
            addMaterialMultipleDatatable : "{{ route("addMaterialMultiple.datatable") }}",
            materialCoursesDatatable : "{{ route("material-courses-datatable") }}",

            //material
            changeStatusMultipleMaterialDatatable: "{{ route("changeStatusMultipleMaterial.datatable") }}",

        },
        headers:{
            csrf: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        },
        datatable:{
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: "_MENU_",
                loadingRecords: "Φόρτωση ...",
                processing: "Επεξεργασία ...",
                search: "Αναζήτηση: ",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },


        }
    };
</script>
