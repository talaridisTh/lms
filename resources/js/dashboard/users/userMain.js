import utilities from '../main';

$("#scroll-horizontal-datatable").DataTable({
    processing: true,
    serverSide: true,
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
    scrollX: !0,
    language:config.datatable.language,

    drawCallback:  () =>{
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        $(".js-remove-table-classes > thead > tr > th").removeClass("js-link cursor-pointer");


        toogleInput();
        routeLink();
    }
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
