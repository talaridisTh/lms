import utilities from '../main';

    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd',
        autoclose:true
    });

    load_data();

    function load_data(from_date = '', to_date = '') {
        var tables = $("#scroll-horizontal-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: config.routes.indexDatatable,
                headers: config.headers.csrf,
                type: "post",
                data: {from_date: from_date, to_date: to_date}
            },
            columnDefs: [
                {orderable: false, "targets": [0]},
                {className: "js-link cursor-pointer", "targets": [1, 2, 3, 4, 5, 7]},
                {targets: 8, visible: false}
            ],
            columns: [
                {data: "chexbox", name: "chexbox"},
                {data: "avatar", name: "avatar"},
                {data: "first_name", name: "first_name"},
                {data: "last_name", name: "last_name"},
                {data: "action", name: "action"},
                {data: "email", name: "email"},
                {data: 'active', name: 'active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'activeNum', name: 'activeNum'},
            ],
            language: config.datatable.language,


            drawCallback: () => {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
                $("thead >tr> th").removeClass("js-link cursor-pointer");
                $("tfoot > tr > th").removeClass("js-link cursor-pointer");
                filter();
                refresh();
                toogleInput();
                routeLink();
                selectMultipleCheckboxDelete();
                selectMultipleCheckboxUpdate();
            },


        })

        utilities.selectAndDeselectCheckbox(".js-user-checkbox")
        utilities.filterButton('#fullNameFilter',2,tables)
        utilities.filterButton('#rolesFilter',4,tables)
        utilities.filterButton('#activeFilter',8,tables)

        const filter =() => {
            $('#filter').click(function () {
                $('#filter').unbind();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                if (from_date != '' && to_date != '') {
                    $('#scroll-horizontal-datatable').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Both Date is required');
                }
            });
        }

        const refresh =() => {
            $('#refresh').click(function () {
                $('#refresh').unbind();
                $('#from_date').val('');
                $('#to_date').val('');
                $('#scroll-horizontal-datatable').DataTable().destroy();
                load_data();
            });
        }

        const toogleInput =() => {
            $('.toggle-class').unbind();

            $('.toggle-class').change(async function () {
                const status = $(this).prop('checked') == true ? 1 : 0;
                const user_id = $(this).data('id');
                try {
                    const {data} = await axios.patch(config.routes.changeStatusDatatable, {
                        'active': status,
                        'id': user_id
                    })
                    tables.ajax.reload()
                    utilities.toastAlert('success',this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε" )
                } catch (err) {
                    utilities.toastAlert('error',"Παρουσιάστηκε κάποιο πρόβλημα" )
                }
            })
        }

        const routeLink = () =>{
            $('.js-link').click(function () {
                $('.js-link').unbind();

                let user = this.parentElement.dataset.userId;


                window.location = `/dashboard/users/${user}`;
            });
        }

        const selectMultipleCheckboxDelete = () => {
            $('.js-multiple-delete').unbind();
            $(".js-multiple-delete").click(() => {
                let checkboxes = $(".js-user-checkbox:checked")

                let ids = [];

                for (let i = 0; i < checkboxes.length; i++) {
                    ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
                }

                axiosMultipleDelete(ids)

            })
        }

        const axiosMultipleDelete = async (ids) =>{

            try {
                const {status} = await axios.delete(config.routes.destroyMultipleUsersDatatable,{
                    data:{
                        'user_id':ids,
                    }

                })
                if(status == 200){
                    utilities.toastAlert("success",`${ids.length} Διαγράφικαν`)
                    tables.ajax.reload()
                }
            }catch (e) {
                utilities.toastAlert('error',"Παρουσιάστηκε κάποιο πρόβλημα" )
            }
        }

        const selectMultipleCheckboxUpdate = () => {
            $('.js-multiple-update').unbind();
            $(".js-multiple-update").click(function (){
                let checkboxes = $(".js-user-checkbox:checked")

                let ids = [];

                for (let i = 0; i < checkboxes.length; i++) {
                    ids.push(checkboxes[i].parentElement.parentElement.parentElement.dataset.userId);
                }

                axiosMultipleUpdate(ids,this.dataset.coursesId)

            })
        }

        const axiosMultipleUpdate = async (ids,courseId) =>{

            try {
                const {status} = await axios.patch(config.routes.addCoursesMultipleUsersDatatable,{
                    'user_id':ids,
                    "course_id":courseId
                })

                if(status == 200){
                    utilities.toastAlert("success",`${ids.length} μαθητές προστέθηκαν`)
                    console.log(status)
                }
            }catch (e) {
                console.log(e)
                utilities.toastAlert('error',"Παρουσιάστηκε κάποιο πρόβλημα" )
            }
        }

    }















