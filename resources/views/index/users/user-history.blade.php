@extends("layouts.app")

@section("style")
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
    <style>
        .wrapper {
            flex-direction: column;
            height: 73vh;
        }

        input[data-switch]:checked + label:after {
            left: 66px;


        }

        input[data-switch] + label:before {

        }

        input[data-switch] + label {
            width: 89px;


        }

    </style>
@endsection

@section("content")

    <div class="accordion mt-3" id="course-parent">
        @foreach($courses as $key => $course)

            <div class="card mb-0 container card-5 " style="max-width: 1500px">
                <div class="card-header js-collapse" data-course-slug="{{$course->slug}}" id="{{$course->slug}}">
                    <h5 class="m-0">
                        <a class="custom-accordion-title d-block pt-2 pb-2"
                           data-toggle="collapse" href="#{{$course->slug}}-collapse"
                           aria-expanded="true" aria-controls="{{$course->slug}}-collapse">
                            {{$course->title}}
                        </a>
                    </h5>
                </div>

                <div id="{{$course->slug}}-collapse" class="collapse"
                     aria-labelledby="headingOne" data-parent="#course-parent">
                    <div class="card-body overflow-x-auto js-subtable table-cnt ">
                        <table  class="history-datatable table dt-responsive nowrap w-100">

                            <thead>
                            <tr>
                                <th class="text-left align-middle" scope="col">
                                    <div class='icheck-primary d-inline'>
                                        <input id='{{ $course->slug }}-main-checkbox' class="js-section-main-checkbox"
                                               type='checkbox' autocomplete='off'>
                                        <label for='{{ $course->slug }}-main-checkbox'></label>
                                    </div>
                                </th>
                                <th class="text-left">Cover</th>
                                <th class="text-left">Μάθημα</th>
                                <th class="text-left">Type</th>
                                <th class="text-left">Hμερομηνία</th>
                                <th class="text-left">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $data = auth()->user()->witchlist;

                              $materialIds = $data->map(function ($material){
                                  return [$material->pivot->course_id=>$material->pivot->material_id];
                              });

                              $materials = $materialIds->unique()->map(function ($material){


                                  return App\Material::findOrFaIL(array_values($material));
                              });


                            @endphp


                            @forelse($materials->flatten() as $material)

                                @if($material->witchlist->first()->title == $course->title)
                                    <tr>

                                        <td class="align-middle text-left">
                                            <div class='icheck-primary d-inline'>
                                                <input id='{{ $material->slug }}-main-checkbox'
                                                       class="js-section-main-checkbox"
                                                       type='checkbox' autocomplete='off'>
                                                <label for='{{ $material->slug }}-main-checkbox'></label>
                                            </div>
                                        </td>

                                        <td class="align-middle text-left">
                                            <img src="{{$material->cover}}" height='40' class='avatar-sm rounded-circle'
                                                 alt="{{ $material->slug }}">
                                        </td>

                                        <td class="align-middle text-left">
                                            {{$material->title}}
                                        </td>

                                        <td class="align-middle text-left">
                                            {{$material->type}}
                                        </td>

                                        <td class="align-middle text-left">
                                            {{$material->created_at}}
                                        </td>
                                        <td class="align-middle text-left">
                                            <a href='javascript:void(0);' class='action-icon'> <i
                                                    class='mdi mdi-eye'></i></a>
                                            <a href='javascript:void(0);' class='action-icon'> <i
                                                    class='mdi mdi-square-edit-outline'></i></a>
                                            <a href='javascript:void(0);' class='action-icon'> <i
                                                    class='mdi mdi-delete'></i></a>

                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <h2>s</h2>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        @endforeach
    </div>


    {{--    <div class="d-flex justify-content-center mt-2">--}}
    {{--        <input type="checkbox" id="toogle-switch" checked data-switch="bool"/>--}}
    {{--        <label for="toogle-switch" data-on-label="Courses" data-off-label="Material"></label>--}}
    {{--    </div>--}}
    {{--    <div class="container mt-3 container-course" style="max-width: 1500px">--}}
    {{--        <table id="history-datatable" class="table w-100 nowrap data-table">--}}
    {{--            <thead class="thead-light">--}}
    {{--            <tr>--}}
    {{--                <th id='all-user-checkbox' class="text-left ">--}}
    {{--                    <div class='custom-control custom-checkbox'>--}}
    {{--                        <input type='checkbox' class='custom-control-input dt-checkboxes'>--}}
    {{--                        <label class='custom-control-label'> </label>--}}
    {{--                    </div>--}}
    {{--                </th>--}}
    {{--                <th class="text-left">Cover</th>--}}
    {{--                <th class="text-left">Course</th>--}}
    {{--                <th class="text-left">Εἰσηγητής</th>--}}
    {{--                <th class="text-left">Hμερομηνία</th>--}}
    {{--                <th class="text-left">Action</th>--}}
    {{--            </tr>--}}
    {{--            </thead>--}}
    {{--            <tbody class="tables-hover-effect"></tbody>--}}
    {{--        </table>--}}

    {{--    </div>--}}

    {{--    <div class="container mt-3 container-material" style="max-width: 1500px">--}}
    {{--        <table id="history-material-datatable" class="table w-100 nowrap data-table">--}}
    {{--            <thead class="thead-light">--}}
    {{--            <tr>--}}
    {{--                <th id='all-user-checkbox' class="text-left ">--}}
    {{--                    <div class='custom-control custom-checkbox'>--}}
    {{--                        <input type='checkbox' class='custom-control-input dt-checkboxes'>--}}
    {{--                        <label class='custom-control-label'> </label>--}}
    {{--                    </div>--}}
    {{--                </th>--}}
    {{--                <th class="text-left">Cover</th>--}}
    {{--                <th class="text-left">Μάθημα</th>--}}
    {{--                <th class="text-left">Type</th>--}}
    {{--                <th class="text-left">Hμερομηνία</th>--}}
    {{--                <th class="text-left">Action</th>--}}
    {{--            </tr>--}}
    {{--            </thead>--}}
    {{--            <tbody class="tables-hover-effect"></tbody>--}}
    {{--        </table>--}}

    {{--    </div>--}}


@endsection


@section("script")


    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

    <script src="{{ mix('js/index/history/history.js') }}"></script>

    </script>

@endsection
