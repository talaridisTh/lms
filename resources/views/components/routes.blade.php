<script>
    // global app configuration object
    const config = {
        routes: {
            //datatable routes
            destroyDatatable: "{{ route("destroy.datatable") }}",
            //ajax user routes
            changeStatusDatatable: "{{ route("changeStatus.datatable") }}",

			// main
            addMaterialMultipleDatatable : "{{ route("addMaterialMultiple.datatable") }}",
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
                search: "",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },


        }
    };
</script>
