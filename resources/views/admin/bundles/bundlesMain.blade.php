@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
    <h1>Bundles</h1>

    <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
        <thead>
        <tr>
            <th class="text-center">Ονομασία</th>
            <th class="text-center">Ενεργό</th>
            <th class="text-center">Τελ. Ενημέρωση</th>
            <th class="text-center">Ημ. Δημιουργίας</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($bundles as $bundle)
            <tr>
                <td>{{ $bundle['name'] }}</td>
                <td>{{ $bundle['active'] }}</td>
                <td>{{ $bundle['updated_at'] }}</td>
                <td>{{ $bundle['created_at'] }}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th class="text-center">Ονομασία</th>
            <th class="text-center">Ενεργό</th>
            <th class="text-center">Τελ. Ενημέρωση</th>
            <th class="text-center">Ημ. Δημιουργίας</th>
        </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script>
        $("#scroll-horizontal-datatable").DataTable({
            scrollX: !0,
            language: {
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
