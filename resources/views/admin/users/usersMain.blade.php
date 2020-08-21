@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

    <style>
        .dropleft:hover>.dropdown-menu {
            display: block;
        }
    </style>
@endsection

@section('content')
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container" style="max-width:1370px">
        <div class="row mb-2 justify-content-end">
            <div id="containerCol" class="col-sm-12">
                <div class="text-right">
                    <a href="{{route('user.create')}}" class="btn btn-secondary mb-2"><i
                            class="mdi mdi-plus-circle mr-2"></i>
                        Νέος χρήστης
                    </a>
                @include("components.bulkActionDatatable")
                </div>
            </div>
        </div>
       @include("components.filterDatatable")
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table js-remove-table-classes">
            <thead>
            <tr>
                <th class="text-left"></th>
                <th id='all-user-checkbox' class="text-left js-user-checkbox">
                    <i class="h3 mdi mdi-checkbox-marked-outline"></i>
                </th>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">test</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">courses</th>
            </tr>
            </thead>
            <tbody class="tables-hover-effect">
            </tbody>
            <tfoot>
            <tr>
                <th class="text-left"></th>
                <th id='all-user-checkbox' class="text-left js-user-checkbox">
                    <i class="h3 mdi mdi-checkbox-marked-outline"></i>
                </th>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">test</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">courses</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')

    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <x-routes></x-routes>
    <script src="{{ asset('js/dashboard/users/userMain.js') }}"></script>







    <script>
        $(document).ready(function () {
            $("#fullNameFilter").select2({
                text: '',
                placeholder: "Courses",
                allowClear: true,
                // minimumInputLength: 2,

            });

            $("#rolesFilter").select2({
                placeholder: "Ρολος",
                minimumResultsForSearch: -1,
                allowClear: true,
            });

            $("#activeFilter").select2({
                minimumResultsForSearch: -1,
                placeholder: "Active",
                allowClear: true,
            });
        })


    </script>

    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'YY/MM/DD '
                },
                startDate: moment().startOf('hour'),
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });


        $(".ragneButton").detach().prependTo('#containerCol')
    </script>.

@endsection
