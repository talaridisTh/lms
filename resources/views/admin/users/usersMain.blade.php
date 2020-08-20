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
                    <div class="btn-group mb-2">
                        <button type="button" class="btn btn-warning dropdown-toggle " data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Bulk action
                        </button>

                        <div class="dropdown-menu dropdown-menu-animated">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item js-multiple-delete" href="#">Διαγραφη επιλεγμενων</a>
                            <div class="dropdown-divider"></div>
                            <div class="btn-group dropleft">
                            <div class="dropdown-divider"></div>
                                <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Mετακίνηση σε course
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($activeCourses as $courses)
                                    <a class="dropdown-item js-multiple-update cursor-pointer" data-courses-id="{{$courses->id}}">{{$courses->name}}</a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Print</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Excel</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">CVS </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <select id="fullNameFilter">
            <option value="">Καθαρισμος</option>
            @foreach(App\User::all() as $user)
                <option value="{{$user->first_name}}">{{$user->fullName}}</option>
            @endforeach
        </select>

        <select id="rolesFilter">
            <option value="">Καθαρισμος</option>
            @foreach(App\Role::all() as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
            @endforeach
        </select>

        <select id="activeFilter">
            <option value="">Καθαρισμος</option>
            <option value="1">Ενεργοι</option>
            <option value="0">Μη ενεργοι</option>
        </select>
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table js-remove-table-classes">
            <thead>
            <tr>
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
            </tr>
            </thead>
            <tbody class="tables-hover-effect">
            </tbody>
            <tfoot>
            <tr>
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
                text: '',
                placeholder: "Χρηστες",
                allowClear: true,
                minimumInputLength: 2,

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

    </script>

@endsection
