import utilities from '../../index/main';
import utilitiesDashboard from "../../dashboard/main"


// const historyTable = $("#history-datatable").DataTable({
//     // caseInsensitive: false,
//     order: [2, "desc"],
//     pageLength : 5,
//     lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Ολα']],
//     processing: true,
//     serverSide: true,
//     ajax: {
//         url: "/history-datatable",
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         type: "post",
//     },
//     columns: [
//
//         {data: "checkbox", name: "checkbox", orderable: false},
//         {data: "cover", name: "cover", orderable: false,},
//         {data: "title", name: "title", className: "cursor-pointer"},
//         {data: "user_id", name: "user_id", className: "cursor-pointer"},
//         {data: "created_at", name: "created_at"},
//         {data: "action", name: "action",orderable: false},
//
//     ],
//     language: utilitiesDashboard.tableLocale,
//
//
//     drawCallback: () => {
//         $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
//         // $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
//         // $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
//         $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td").addClass("align-middle");
//         $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td:first-child").addClass("dt-checkboxes-cell");
//         $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #history-datatable >thead > tr > #all-user-checkbox").addClass("all dt-checkboxes-cell dt-checkboxes-select-all");
//         $(".dataTables_wrapper >  .row:nth-child(1) >div:first-child> div  > label").addClass("w-10");
//
//
//     }
//     //
//
// })

const historyMaterialTable = $("#history-material-datatable").DataTable({
    // caseInsensitive: false,
    order: [2, "desc"],
    pageLength: 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Ολα']],
    processing: true,
    serverSide: true,
    ajax: {
        url: "/history-datatable/material",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
    },
    columns: [

        {data: "checkbox", name: "checkbox", orderable: false, className: "cursor-pointer align-middle"},
        {data: "cover", name: "cover", orderable: false, className: "cursor-pointer align-middle"},
        {data: "title", name: "title", className: "cursor-pointer align-middle"},
        {data: "type", name: "type", className: "cursor-pointer align-middle"},
        {data: "created_at", name: "created_at", className: "cursor-pointer align-middle"},
        {data: "action", name: "action", className: "cursor-pointer align-middle", orderable: false},

    ],
    language: utilitiesDashboard.tableLocale,


    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        // $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        // $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td").addClass("align-middle");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td:first-child").addClass("dt-checkboxes-cell");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >thead > tr > #all-user-checkbox").addClass("all dt-checkboxes-cell dt-checkboxes-select-all");
        $(".dataTables_wrapper>  .row:nth-child(1) >div:first-child> div  > label").addClass("w-10");


    }
    //

})

$('.history-datatable').DataTable({
    searching: false,
    lengthChange: false,
    pageLength: 5,
    order: [4, "desc"],
    language: utilitiesDashboard.tableLocale,

            drawCallback: () => {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");

        }

    })





// $(".js-collapse").on("click", function () {
//
//
//     this.findParent(1).children[1].findChild(1).innerHTML = subTable(this.dataset.courseSlug);
//
//     $(`#${this.dataset.courseSlug}-table`).DataTable();
//     // const historyMaterialTable =  $(`#${this.dataset.courseSlug}-table`).DataTable({
//     //     order: [2, "desc"],
//     //     pageLength: 5,
//     //     searching: false,
//     //     lengthChange: false,
//     //     processing: true,
//     //     serverSide: true,
//     //     ajax: {
//     //         url: "/history-datatable/material",
//     //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//     //         type: "post",
//     //     },
//     //     columns: [
//     //
//     //         {data: "checkbox", name: "checkbox", orderable: false, className: "cursor-pointer align-middle"},
//     //         {data: "cover", name: "cover", orderable: false, className: "cursor-pointer align-middle"},
//     //         {data: "title", name: "title", className: "cursor-pointer align-middle"},
//     //         {data: "type", name: "type", className: "cursor-pointer align-middle"},
//     //         {data: "created_at", name: "created_at", className: "cursor-pointer align-middle"},
//     //         {data: "action", name: "action", className: "cursor-pointer align-middle", orderable: false},
//     //
//     //     ],
//     //     language: utilitiesDashboard.tableLocale,
//     //
//     //
//     //     drawCallback: () => {
//     //         $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
//     //         // $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
//     //         // $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
//     //         $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td").addClass("align-middle");
//     //         $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >tbody > tr > td:first-child").addClass("dt-checkboxes-cell");
//     //         $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #history-datatable >thead > tr > #all-user-checkbox").addClass("all dt-checkboxes-cell dt-checkboxes-select-all");
//     //         $(".dataTables_wrapper>  .row:nth-child(1) >div:first-child> div  > label").addClass("w-10");
//     //
//     //
//     //     }
//     //     //
//     //
//     // })
// });

const subTable = (id) => {
    return (
        `
        <table id="${id}-table" class="table mb-0 ">
            <thead>
                <tr>
                    <th class="text-center align-middle" scope="col">
                        <div class='icheck-primary d-inline'>
                            <input id='{{ $course->slug }}-main-checkbox' class="js-section-main-checkbox"
                                               type='checkbox' autocomplete='off'>
                            <label for='{{ $course->slug }}-main-checkbox'></label>
                        </div>
                    </th>
                    <th class="text-left">Cover</th>
                    <th class="text-left">Course</th>
                    <th class="text-left">Εἰσηγητής</th>
                    <th class="text-left">Hμερομηνία</th>
                    <th class="text-left">Action</th>
                </tr>
            </thead>

            <tbody>
             <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
            </tbody>
        </table>
`
    )
}

$('#history-datatable_length').css("width", "100%");

$(".custom-select").select2({
    minimumResultsForSearch: -1,

});

$(".container-material").hide();

$("#toogle-switch").on("change", function () {
    if (this.checked) {
        $(".container-course").show();
        $(".container-material").hide();

    } else {
        $(".container-course").hide();
        $(".container-material").show();
    }
})
