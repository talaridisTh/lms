@extends("layouts.app")

@section("style")
@endsection

@section("content")
    {{--    <div class="container">--}}
    {{--        <form action="{{route('user.linkStore')}}" method='post'>--}}
    {{--            @csrf--}}
    {{--        <div class="input-group mb-3">--}}
    {{--            <div class="input-group-prepend">--}}
    {{--                <label class="input-group-text" for="inputGroupSelect01">Καθηγητης</label>--}}
    {{--            </div>--}}
    {{--            <select name="user_id" class="custom-select" id="inputGroupSelect01">--}}
    {{--                @role("admin")--}}
    {{--                <option selected>Choose...</option>--}}
    {{--                @foreach($partners as $partner)--}}
    {{--                <option value="{{$partner->id}}">{{$partner->fullName}}</option>--}}
    {{--                @endforeach--}}
    {{--                @endrole--}}
    {{--                @hasanyrole('instructor|partner')--}}
    {{--                    <option value="{{auth()->user()->slug}}">{{auth()->user()->fullName}}</option>--}}
    {{--                @endrole--}}
    {{--            </select>--}}
    {{--        </div>--}}
    {{--        <div class="input-group mb-3">--}}
    {{--            <div class="input-group-prepend">--}}
    {{--                <label class="input-group-text" for="inputGroupSelect01">Course</label>--}}
    {{--            </div>--}}
    {{--            <select name="course_id"  class="custom-select" id="inputGroupSelect01">--}}
    {{--                <option selected>Choose...</option>--}}
    {{--                @foreach($courses as $course)--}}
    {{--                    <option value="{{$course->id}}">{{$course->title}}</option>--}}
    {{--                @endforeach--}}
    {{--            </select>--}}
    {{--        </div>--}}
    {{--            <input type="submit"  value="Δημιουργία Link" class="btn btn-primary">--}}
    {{--        </form>--}}

    {{--    </div>--}}
    <div class="card">
        <div class="card-body ">

            <div class="row">
                <!-- start projects-->
                <div class="col-xl-12">
                    <div class="pr-xl-3">
                        <h5 class="mt-0 mb-3">Projects</h5>
                        <!-- start search box -->
                        <div class="app-search">
                            <form>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control" placeholder="search by name...">
                                    <span class="mdi mdi-magnify search-icon"></span>
                                </div>
                            </form>
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
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        @foreach($partners as $partner)
                                                            <a href="javascript:void(0);" class="text-body">
                                                                <div class="media  p-2">
                                                                    <div class="avatar-sm">
                                                                        <img src="{{$partner->cover}}" height="30" alt="">
                                                                    </div>
                                                                    <div class="media-body ml-2">
                                                                        <h5 class="mt-0 mb-0">
                                                                            {{$partner->fullName}}
                                                                        </h5>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <hr class="m-0">
                                                        @endforeach
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
                </div>
                <!-- end projects -->


                <!-- end gantt view -->
            </div>

        </div>
    </div>




@endsection



@section("script")
    <script src="/assets/js/pages/demo.form-wizard.js"></script>
@endsection




