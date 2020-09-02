@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container" style="max-width:1370px">
        <div class="row mb-2 justify-content-end">
            <div id="containerCol" class="col-sm-12">
                <div class="text-right">
                    <a href="{{route('user.create')}}" class="btn btn-primary mb-2"><i
                            class="mdi mdi-plus-circle mr-2"></i>
                        Νέος χρήστης
                    </a>
                @include("components.bulkActionDatatable")
                </div>
            </div>
        </div>
       @include("components.filterDatatableUser")
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table js-remove-table-classes">
            <thead>
            <tr>
                <th class="text-left"></th>
                <th id='all-user-checkbox' class="text-left ">
                    <div class='icheck-primary d-inline'>
                        <input type='checkbox' id='select-all-courses' autocomplete='off'>
                        <label for='select-all-courses'></label>
                    </div>
                </th>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρόλος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">test</th>
                <th class="text-left">Ημ. Εγγραφής</th>
                <th class="text-left">courses</th>
            </tr>
            </thead>
            <tbody class="">
            </tbody>
            <tfoot>
            <tr>
                <th class="text-left"></th>
                <th id='all-user-checkbox' class="text-left ">
                    <div class='icheck-primary d-inline'>
                        <input type='checkbox' id='select-all-courses' autocomplete='off'>
                        <label for='select-all-courses'></label>
                    </div>
                </th>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρόλος</th>
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
    <x-routes></x-routes>
    <script src="{{ asset('js/dashboard/users/userMain.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#fullNameFilter").select2({
                // placeholder: "Όλα τα Courses ",

                // minimumInputLength: 2,
            });

            $("#rolesFilter").select2({
                // placeholder: "Όλοι οι ρόλοι",
                minimumResultsForSearch: -1,

            });

            $("#activeFilter").select2({
                minimumResultsForSearch: -1,
                // placeholder: "Κατάσταση",

            });
            $(".custom-select").select2({
                minimumResultsForSearch: -1,


            });
        })


    </script>

    <script>


    </script>.

@endsection
