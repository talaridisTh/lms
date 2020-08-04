{{--@if($userIs =="instructor")--}}
{{--    @foreach($allMaterials as $key =>   $materials )--}}
{{--        @if ($loop->parent->index ==$key)--}}
{{--            @foreach($materials as $material)--}}
{{--                <div class="card-body">--}}
{{--                    <div--}}
{{--                        class="badge badge-success float-right">--}}
{{--                        Completed--}}
{{--                    </div>--}}

{{--                    <h5><a href="#"--}}
{{--                           class="text-dark">{{$material->name}}</a>--}}
{{--                        <p class="text-muted mb-2">{{$material->small_description}}--}}
{{--                    </h5>--}}
{{--                    </p>--}}

{{--                    <div>--}}
{{--                        <a href="javascript: void(0);">--}}
{{--                            <img--}}
{{--                                src="{{$material->cover}}"--}}
{{--                                alt=""--}}
{{--                                class="avatar-sm m-1 rounded-circle">--}}
{{--                        </a>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            @endforeach--}}
{{--        @endif--}}
{{--    @endforeach--}}
{{--@endif--}}



@php($c=0)
@if($userIs =="instructor")

    @if($InstructorCourses)
        @foreach($InstructorCourses->materials as $instructor)
         @foreach($instructor->courses as  $courses)


            <div class="accordion custom-accordion" id="custom-accordion-one">
                <div class="card mb-0">
                    <div class="card-header" id="headingFour">
                        <h5 class="m-0">
                            <a class="custom-accordion-title d-block py-1"
                               data-toggle="collapse" href="#collapse-{{$c}}"
                               aria-expanded="true" aria-controls="collapseFour">

                                <i class="mdi mdi-cards-variant mr-1"></i>
                                {{--                                                        {{$user->courses->first() == true ? $user->courses->first()->name : '' }}--}}
                               {{$courses->name}}

                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                            </a>
                        </h5>
                    </div>

                    <div id="collapse-{{$c++}}" class="collapse "
                         aria-labelledby="headingFour"
                         data-parent="#custom-accordion-one">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap mb-0">
                                    <tbody>
                                    <div class="card-body">
                                        <div
                                            class="badge badge-success float-right">
                                            Completed
                                        </div>
                                        <h5><a href="#"
                                               class="text-dark">{{$instructor->name}}</a>
                                            <p class="text-muted mb-2">{{$instructor->small_description}}
                                        </h5>
                                        </p>
                                        <div>
                                            <a href="javascript: void(0);">
                                                <img
                                                    src="{{$instructor->cover}}"
                                                    alt=""
                                                    class="avatar-sm m-1 rounded-circle">
                                            </a>
                                        </div>
                                    </div>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
        @endforeach
    @endif
@endif
