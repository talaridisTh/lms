@if($userIs =="student")
    @if($userCourses)
    @foreach($userCourses as $users)
        <div class="accordion custom-accordion" id="custom-accordion-one">
            <div class="card mb-0">
                <div class="card-header" id="headingFour">
                    <h5 class="m-0">
                        <a class="custom-accordion-title d-block py-1"
                           data-toggle="collapse" href="#collapseFour"
                           aria-expanded="true" aria-controls="collapseFour">

                            <i class="mdi mdi-cards-variant mr-1"></i>
                            {{--                                                        {{$user->courses->first() == true ? $user->courses->first()->name : '' }}--}}
                            {{$users->name}}

                            <i class="mdi mdi-chevron-down accordion-arrow"></i>
                        </a>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse show"
                     aria-labelledby="headingFour"
                     data-parent="#custom-accordion-one">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap mb-0">
                                <tbody>
                                @foreach($allMaterials as $key =>   $materials )
                                    @if ($loop->parent->index ==$key)
                                        @foreach($materials as $material)
                                            <div class="card-body">
                                                <div
                                                    class="badge badge-success float-right">
                                                    Completed
                                                </div>
                                                <h5><a href="#"
                                                       class="text-dark">{{$material->name}}</a>
                                                    <p class="text-muted mb-2">{{$material->small_description}}
                                                </h5>
                                                </p>
                                                <div>
                                                    <a href="javascript: void(0);">
                                                        <img
                                                            src="{{$material->cover}}"
                                                            alt=""
                                                            class="avatar-sm m-1 rounded-circle">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@endif
@endif
