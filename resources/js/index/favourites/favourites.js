import utilities from '../../index/main';
import utilitiesDashboard from "../../dashboard/main"


const watchlistTable = $("#watchlist-datatable").DataTable({
    // caseInsensitive: false,
    order: [2, "desc"],
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Ολα']],
    processing: true,
    serverSide: true,
    ajax: {
        url: "/watchlist-datatable",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
    },
    columns: [

        {data: "checkbox", name: "checkbox", orderable: false},
        {data: "cover", name: "cover", orderable: false,},
        {data: "title", name: "title", className: "cursor-pointer"},
        {data: "user_id", name: "user_id", className: "cursor-pointer"},
        {data: "created_at", name: "created_at"},
        {data: "action", name: "action",orderable: false},

    ],
    language: utilitiesDashboard.tableLocale,


    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        // $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        // $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >tbody > tr > td").addClass("align-middle");
        $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >tbody > tr > td:first-child").addClass("dt-checkboxes-cell");
        $(".dataTables_wrapper >  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >thead > tr > #all-user-checkbox").addClass("all dt-checkboxes-cell dt-checkboxes-select-all");
        $(".dataTables_wrapper >  .row:nth-child(1) >div:first-child> div  > label").addClass("w-10");


    }
    //

})

const watchlistMaterialTable = $("#watchlist-material-datatable").DataTable({
    // caseInsensitive: false,
    order: [2, "desc"],
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Ολα']],
    processing: true,
    serverSide: true,
    ajax: {
        url: "/watchlist-datatable/material",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
    },
    columns: [

        {data: "checkbox", name: "checkbox", orderable: false,className: "cursor-pointer align-middle"},
        {data: "cover", name: "cover", orderable: false,className: "cursor-pointer align-middle"},
        {data: "title", name: "title", className: "cursor-pointer align-middle"},
        {data: "type", name: "type", className: "cursor-pointer align-middle"},
        {data: "created_at", name: "created_at",className: "cursor-pointer align-middle"},
        {data: "action", name: "action",className: "cursor-pointer align-middle",orderable: false},

    ],
    language: utilitiesDashboard.tableLocale,


    drawCallback: () => {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        // $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
        // $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >tbody > tr > td").addClass("align-middle");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >tbody > tr > td:first-child").addClass("dt-checkboxes-cell");
        $(".dataTables_wrapper>  .row:nth-child(2) >.col-sm-12> #watchlist-datatable >thead > tr > #all-user-checkbox").addClass("all dt-checkboxes-cell dt-checkboxes-select-all");
        $(".dataTables_wrapper>  .row:nth-child(1) >div:first-child> div  > label").addClass("w-10");


    }
    //

})


$('#watchlist-datatable_length').css("width","100%");

$(".custom-select").select2({
    minimumResultsForSearch: -1,

});

$(".container-material").hide();
$("#toogle-switch").on("change",function (){
    if(this.checked){
        $(".container-course").show();
        $(".container-material").hide();

    }else{
        $(".container-course").hide();
        $(".container-material").show();
    }
})
