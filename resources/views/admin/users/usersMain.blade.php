@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="text-right">
                    <a href="{{route('user.create')}}" class="btn btn-secondary mb-2"><i
                            class="mdi mdi-plus-circle mr-2"></i>
                        Νέος χρήστης
                    </a>

                    <div class="btn-group mb-2">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Επιλογές
                        </button>
                        <div class="dropdown-menu">
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
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table">
            <thead>
            <tr>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
            </tr>
            </thead>
            {{--            <tbody class="tables-hover-effect">--}}

            {{--            @foreach ($users as $n =>$user)--}}
            {{--                <tr class="text-secondary">--}}
            {{--                    <td>{{ $user['id'] }}</td>--}}
            {{--                    <td>--}}
            {{--                        <a href="{{route('user.show',$user->id)}}" style="cursor: pointer" class="ml-3 text-secondary">--}}
            {{--                            {{ $user['first_name'] }}--}}
            {{--                        </a>--}}
            {{--                    </td>--}}
            {{--                    <td>{{ $user['last_name'] }}</td>--}}
            {{--                    <td>{{  $user->getRoleNames()[0]}}</td>--}}
            {{--                    <td>{{ $user['email'] }}</td>--}}
            {{--                    <td>--}}
            {{--                                    <input class="toggle-class" data-id="{{ $user['id'] }}" type="checkbox"--}}
            {{--                                           id="{{ $user['first_name'] }}-toggle-checkbox"--}}
            {{--                                           {{ $user['active'] == 0 ? '' : 'checked' }} data-switch="bool" autocomplete="off"/>--}}
            {{--                                    <label for="{{ $user['first_name'] }}-toggle-checkbox" data-on-label="On"--}}
            {{--                                           data-off-label="Off"></label>--}}
            {{--                    </td>--}}
            {{--                    <td>{{ $user['created_at'] }}</td>--}}


            {{--                </tr>--}}
            {{--            @endforeach--}}

            {{--            </tbody>--}}
            <tfoot>
            <tr>
                <th class="text-left">Avatar</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script>


        $("#scroll-horizontal-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route("index.datatable")}}",
                type: "post"
            },
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
            language: {
                emptyTable: "Δεν υπάρχουν εγγραφές",
                info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: "_MENU_ Αποτελέσματα ανα σελίδα",
                loadingRecords: "Φόρτωση ...",
                processing: "Επεξεργασία ...",
                search: "Αναζήτηση: ",
                zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },

            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")


                toogleInput();
            }
        })

        function toogleInput() {
            $('.toggle-class').unbind();

            $('.toggle-class').change(async function () {
                const status = $(this).prop('checked') == true ? 1 : 0;
                const user_id = $(this).data('id');
                console.log(status)

                try {
                    const {data} = await axios.patch('/changeStatus', {
                        'active': status,
                        'id': user_id
                    })
                    Swal.fire({
                        toast: 'true',
                        position: 'top-end',
                        icon: 'success',
                        title: this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } catch (err) {
                    Swal.fire({
                        toast: 'true',
                        position: 'top-end',
                        icon: 'error',
                        title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
        }


    </script>
@endsection
