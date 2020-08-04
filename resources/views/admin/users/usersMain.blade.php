@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="container" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-4 ">


            </div>
            <div class="col-sm-8">
                <div class="text-sm-right">
                    <a href="{{route('user.create')}}" class="btn btn-secondary mb-2 display"><i class="mdi mdi-plus-circle mr-2"></i>
                        Νέο Course
                    </a>
                    <button type="button" class="btn btn-light mb-2">Export</button>
                </div>
            </div>
        </div>
        <table id="scroll-horizontal-datatable" class="table w-100 nowrap data-table">
            <thead>
            <tr>

                <th class="text-left">id</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Email</th>
                <th class="text-left">Ενεργός</th>
                <th class="text-left">Ημ. Εγγραφής</th>
            </tr>
            </thead>
            <tbody class="tables-hover-effect">

            @foreach ($users as $n =>$user)
                <tr class="text-secondary">
                    <td>{{ $user['id'] }}</td>
                    <td>
                        <a href="{{route('user.show',$user->id)}}"  style="cursor: pointer" class="ml-3 text-secondary">
                            {{ $user['first_name'] }}
                        </a>
                    </td>
                    <td>{{ $user['last_name'] }}</td>
                    <td>{{  $user->getRoleNames()[0]}}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['active'] }}</td>
                    <td>{{ $user['created_at'] }}</td>


                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th class="text-left">Ρολος</th>
                <th class="text-left">Όνομα</th>
                <th class="text-left">Επώνυμο</th>
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
            scrollX: !0,
            language: {
                emptyTable: 		"Δεν υπάρχουν εγγραφές",
                info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
                infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
                lengthMenu: 		"_MENU_ Αποτελέσματα ανα σελίδα",
                loadingRecords: 	"Φόρτωση ...",
                processing: 		"Επεξεργασία ...",
                search: 			"Αναζήτηση: ",
                zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },

            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        })









    </script>
@endsection
