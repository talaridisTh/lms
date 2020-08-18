import utilities from '../main';


$(document).ready(function() {


    const tables = $("#scroll-horizontal-datatable").DataTable({

        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-warning dropdown-toggle stars',
                text: '<span class="btn-label"><i class="fa fa-star" >  Preferiti</i></span>',
                buttons: [
                    {
                        className: 'btn btn-outline-warning',
                        titleAttr: 'Preferiti',
                        text: '<span class="btn-label"><i class="fa fa-star" > admin</i></span>',
                        action: function (e,dt,node,config) {
                            var table = $('#scroll-horizontal-datatable').DataTable();
                            console.log(dt)
                            dt.columns(2).search("admin", true, false, true).draw();
                            $('#pref').parent().addClass("active");
                        }
                    },
                    {
                        className: 'btn btn-outline-warning',
                        titleAttr: 'Tutti',
                        text: '<span class="btn-label"><i class="fa fa-star-half-o" >instructor</i></span>',
                        action: function (e,dt,node,config) {
                            var table = $('#scroll-horizontal-datatable').DataTable();
                            console.log(dt)
                            dt.columns(2).search("instructor", true, false, true).draw();
                            $('#pref').parent().addClass("active");
                        }
                    },
                    {
                        className: 'btn btn-outline-warning',
                        titleAttr: 'Non Preferiti',
                        text: '<span class="btn-label"><i class="fa fa-star-o" >partner</i></span>',
                        action: function (e,dt,node,config) {
                            var table = $('#scroll-horizontal-datatable').DataTable();
                            console.log(dt)
                            dt.columns(3).search("partner", true, false, true).draw();
                            $('#pref').parent().addClass("active");
                        }
                    },
                    {
                        className: 'btn btn-outline-warning',
                        titleAttr: 'Non Preferiti',
                        text: '<span class="btn-label"><i class="fa fa-star-o" > student</i></span>',
                        action: function (e,dt,node,config) {
                            var table = $('#scroll-horizontal-datatable').DataTable();
                            console.log(dt)
                            dt.columns(4).search("student", true, false, true).draw();
                            $('#pref').parent().addClass("active");
                        }
                    }
                ],
            }],
        initComplete: function () {
            this.api().columns([2,3, 5]).every(function () {
                var column = this;
                var select = $('<select class="mr-2 btn btn-primary btn-sm "><option ></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });

            });
        },
        ajax: {
            url: config.routes.indexDatatable,
            headers: config.headers.csrf,
            type: "post"
        },
        columnDefs: [
            {orderable: false, "targets": [0]},
            {className: "js-link cursor-pointer", "targets": [0, 1, 2, 3, 4, 6]}
        ],
        columns: [
            {data: "avatar", name: "avatar"},
            {data: "first_name", name: "first_name"},
            {data: "last_name", name: "last_name"},
            {data: "action", name: "action"},
            {data: "email", name: "email"},
            {data: 'active', name: 'active'},
            {data: 'created_at', name: 'created_at'},
        ],
        language: config.datatable.language,
        drawCallback: () => {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            $(".dataTables_scrollHeadInner table > thead > tr > th").removeClass("js-link cursor-pointer");
            $(".tabletr2 th").removeClass("js-link cursor-pointer");
            $("tfoot > tr > th").removeClass("js-link cursor-pointer");

            toogleInput();
            routeLink();
        },

    })




})



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


