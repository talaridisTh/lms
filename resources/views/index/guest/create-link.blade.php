@extends("layouts.app")

@section("style")
@endsection

@section("content")

    <div class="card w-100">
        <div class="card-body ">

            <div class="row">
                <!-- start projects-->
                <div class="col-xl-4">
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
                                                                <div class="media bg-list-hover p-2">
                                                                    <div class="avatar-sm">
                                                                        <img src="{{$partner->cover}}" height="30" alt="">
                                                                    </div>
                                                                    <div class="media-body ml-2">

                                                                        <h5 class="mt-0 mb-0 js-instructor-link"
                                                                            data-user-slug="{{\Str::slug($partner->first_name.$partner->last_name, '-')}}"
                                                                            data-user-id={{$partner->id}} >
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
                <div class="col-xl-4 component-course"></div>
                <div class="col-xl-4 col-lg-5 order-lg-1 order-xl-2 component-instructor"></div>

{{--                background: #E9EAEB !important;--}}

                <!-- end projects -->


                <!-- end gantt view -->
            </div>

        </div>
    </div>




@endsection



@section("script")

    <script src="/assets/js/pages/demo.form-wizard.js"></script>
    <script src="{{ mix('js/index/guest/guest.js') }}"></script>
@endsection




