<div class="pr-xl-3">
    <h5 class="mt-0 mb-3">Projects</h5>
    <!-- start search box -->
    <div class="app-search">
        <div class="row">
            <div class="form-group position-relative col-md-6">
                <form>

                    <input type="text" class="form-control" placeholder="search by name...">

                </form>
                <span class="mdi mdi-magnify search-icon"></span>
            </div>
            <div class="col-md-6 text-right">
                <div class="btn btn-primary js-submit-guest">Δημιουργία</div>
            </div>
        </div>

    </div>
    <!-- end search box -->

    <div class="row">
        <div class="col">
            <div data-simplebar="init" style="max-height: 535px;">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper"
                                 style="height: auto; overflow: hidden scroll;">
                                <div class="simplebar-content d-flex flex-column" style="padding: 0px;">
                                    <div class="accordion" id="custom-accordion-one">
                                        @foreach($courses as $course)

                                            <div class="pb-2">

                                                <div class="pretty p-icon p-round p-jelly ">
                                                    <input class="input-course" data-course-id="{{$course->id}}"
                                                           type="checkbox"/>
                                                    <div class="state p-primary ">
                                                        <i class="icon mdi font-16 mdi-check"></i>
                                                        <label class="font-16">{{$course->title}}</label>
                                                    </div>
                                                </div>

                                                <a class="custom-accordion-title"
                                                   data-toggle="collapse" href="#collapseFour-{{$course->id}}"
                                                   aria-expanded="true" aria-controls="collapseFour-{{$course->id}}">
                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>

                                            </div>

                                            <div id="collapseFour-{{$course->id}}" class="collapse "
                                                 aria-labelledby="headingFour-{{$course->id}}"
                                                 data-parent="#custom-accordion-one">
                                                <div class="card-body d-flex pt-0">
                                                    <div class="p-2">
                                                        @foreach($course->materials as $key=> $material)
                                                            @if($key<=9)
                                                                <div class="pb-1 ff">
                                                                    <div class="pretty p-icon p-round p-jelly ">
                                                                        <input class="input-materials"
                                                                               data-material-id="{{$material->id}}"
                                                                               type="checkbox"/>
                                                                        <div class="state p-info ">
                                                                            <i class="icon mdi font-16 mdi-check"></i>
                                                                            <label
                                                                                class="font-16">{{$material->title}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="p-2">
                                                        @foreach($course->materials as $key=> $material)
                                                            @if($key>=10 && $key<20)
                                                                <div class="pb-1 ff">
                                                                    <div class="pretty p-icon p-round p-jelly ">
                                                                        <input class="input-materials"
                                                                               data-material-id="{{$material->id}}"
                                                                               type="checkbox"/>
                                                                        <div class="state p-info ">
                                                                            <i class="icon font-16 mdi mdi-check"></i>
                                                                            <label
                                                                                class="font-16">{{$material->title}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="p-2">
                                                        @foreach($course->materials as $key=> $material)
                                                            @if($key>=20)
                                                                <div class="pb-1 ff">
                                                                    <div class="pretty p-icon p-round p-jelly ">
                                                                        <input class="input-materials"
                                                                               data-material-id="{{$material->id}}"
                                                                               type="checkbox"/>
                                                                        <div class="state p-info ">
                                                                            <i class="icon font-16 mdi mdi-check"></i>
                                                                            <label
                                                                                class="font-16">{{$material->title}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder"
                         style="width: auto; height: 546px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                    <div class="simplebar-scrollbar"
                         style="height: 524px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
