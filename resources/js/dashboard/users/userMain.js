import utilities from '../main';



    var tables = $("#scroll-horizontal-datatable").DataTable({
        processing: true,
        serverSide: true,
        // dom: 'lBfrtip',
        ajax: {
            url: config.routes.indexDatatable,
            headers: config.headers.csrf,
            type: "post"
        },
        columnDefs: [
            {orderable: false, "targets": [0]},
            {className: "js-link cursor-pointer", "targets": [0, 1, 2, 3, 4, 6]},
            {  targets: 7, visible: false}
        ],
        columns: [
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

            toogleInput();
            routeLink();
        },



    })


const filterButton = function(attr,column){
    $(attr).detach().insertAfter('.dataTables_length label')


    $(attr).on('change', function () {
        tables.columns(column).search( this.value ).draw();
    } );
}


filterButton('#fullNameFilter',1,tables)
filterButton('#rolesFilter',3,tables)
filterButton('#activeFilter',7,tables)



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



