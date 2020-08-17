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
            destroyMultipleDatatable: "{{ route("destroyMultiple.datatable") }}",
            courseModaDatatable: "{{ route("courseModal.datatable") }}"
        },
        headers:{
            csrf: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        },
        datatable:{
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: "_MENU_ Αποτελέσματα ανα σελίδα",
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
