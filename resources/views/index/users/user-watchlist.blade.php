@extends("layouts.app")

@section("style")
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
    <style>
        .wrapper{
            flex-direction: column;
            height: 73vh;
        }
        input[data-switch]:checked+label:after {
            left: 66px;


        }
        input[data-switch]+label:before {

        }
        input[data-switch]+label {
            width: 89px;


        }
    </style>
@endsection

@section("content")


    <div class="d-flex justify-content-center mt-2">
        <input type="checkbox" id="toogle-switch" checked data-switch="bool"/>
        <label for="toogle-switch" data-on-label="Courses" data-off-label="Material"></label>
    </div>
    <div class="container mt-3 container-course" style="max-width: 1500px">
            <table id="watchlist-datatable" class="table w-100 nowrap data-table">
                <thead class="thead-light">
                <tr>
                    <th id='all-user-checkbox' class="text-left ">
                        <div class='custom-control custom-checkbox'>
                            <input type='checkbox' class='custom-control-input dt-checkboxes'>
                            <label class='custom-control-label'> </label>
                        </div>
                    </th>
                    <th class="text-left">Cover</th>
                    <th class="text-left">Course</th>
                    <th class="text-left">Εἰσηγητής</th>
                    <th class="text-left">Hμερομηνία</th>
                    <th class="text-left">Action</th>
                </tr>
                </thead>
                <tbody class="tables-hover-effect"></tbody>
            </table>

    </div>

    <div class="container mt-3 container-material" style="max-width: 1500px">
        <table id="watchlist-material-datatable" class="table w-100 nowrap data-table">
            <thead class="thead-light">
            <tr>
                <th id='all-user-checkbox' class="text-left ">
                    <div class='custom-control custom-checkbox'>
                        <input type='checkbox' class='custom-control-input dt-checkboxes'>
                        <label class='custom-control-label'> </label>
                    </div>
                </th>
                <th class="text-left">Cover</th>
                <th class="text-left">Μάθημα</th>
                <th class="text-left">Type</th>
                <th class="text-left">Hμερομηνία</th>
                <th class="text-left">Action</th>
            </tr>
            </thead>
            <tbody class="tables-hover-effect"></tbody>
        </table>

    </div>


@endsection


@section("script")


    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="/assets/js/vendor/dataTables.checkboxes.min.js"></script>

    <script src="{{ mix('js/index/account/account.js') }}"></script>

    </script>

@endsection
