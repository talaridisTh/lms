@extends('layouts.app')
@section('css')


@endsection
@section('content')

    <div class="content-page">
        <div class="content">

            <!-- start page title -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                <li class="breadcrumb-item active">Chat</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Chat</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <!-- start chat users-->
                <div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1" id="js-chat" data-auth-id="{{auth()->id()}}">
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#allUsers" data-toggle="tab" aria-expanded="false"
                                       class="nav-link active py-2">
                                        All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#favUsers" data-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                        Εἰσηγητές
                                    </a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a href="#friendUsers" data-toggle="tab" aria-expanded="true" class="nav-link py-2">--}}
                                {{--                                        Friends--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                            </ul> <!-- end nav-->

                            <div class="tab-content">
                                <div class="tab-pane show active p-3" id="allUsers">

                                    <!-- start search box -->
                                    <div class="app-search">
                                        <form>
                                            <div class="form-group position-relative">
                                                <input type="text" class="form-control"
                                                       placeholder="People, groups & messages..."/>
                                                <span class="mdi mdi-magnify search-icon"></span>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end search box -->

                                    <!-- users -->

                                    <div class="row">
                                        <div class="col">
                                            <div data-simplebar style="max-height: 550px">
                                                @foreach($users as $instructor)
                                                    <a id="user-{{ $instructor->id }}" href="javascript:void(0);"
                                                       data-user-id="{{$instructor->id}}"
                                                       class="js-message-chat text-body">
                                                        <div class="media mt-1 p-2">
                                                            <img src="{{App\User::find($instructor->id)->cover}} "
                                                                 class="mr-2 rounded-circle" height="48"
                                                                 alt="{{App\User::find($instructor->id)->first_name}}"/>
                                                            <div class=" media-body">

                                                                <h5 class="mt-0 mb-0 font-14">
                                                                    <span
                                                                        class="float-right text-muted font-12 preview-hour">   {{App\User::getlastHour($instructor->id)}}</span>
                                                                    {{ App\User::find($instructor->id)->fullName}}
                                                                </h5>
                                                                <p class="mt-1 mb-0 text-muted font-14">

                                                            <span class="w-25 float-right text-right unread-container">

                                                                @if(($instructor->unread))
                                                                    <span
                                                                        class="unread-message badge badge-danger-lighten">{{$instructor->unread}}</span>
                                                                @endif
                                                            </span>

                                                                    <span class="w-75 preview-message">
                                                                {{App\User::getlastMessage($instructor->id)}}
                                                            </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach


                                            </div> <!-- end slimscroll-->
                                        </div> <!-- End col -->
                                    </div>
                                    <!-- end users -->
                                </div> <!-- end Tab Pane-->
                                <div class="tab-pane p-3" id="favUsers">

                                    <!-- start search box -->
                                    <div class="app-search">
                                        <form>
                                            <div class="form-group position-relative">
                                                <input type="text" class="form-control"
                                                       placeholder="People, groups & messages..."/>
                                                <span class="mdi mdi-magnify search-icon"></span>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end search box -->

                                    <!-- users -->

                                    <div class="row">
                                        <div class="col">
                                            <div data-simplebar style="max-height: 550px">
                                                @foreach($users as $instructor)
                                                    @if(App\User::find($instructor->id)->getRoleNames()[0] == "instructor")
                                                        <a id="user-{{ $instructor->id }}" href="javascript:void(0);"
                                                           data-user-id="{{$instructor->id}}"
                                                           class="js-message-chat text-body">
                                                            <div class="media mt-1 p-2">
                                                                <img src="{{ App\User::find($instructor->id)->cover}} "
                                                                     class="mr-2 rounded-circle" height="48"
                                                                />
                                                                <div class=" media-body">

                                                                    <h5 class="mt-0 mb-0 font-14">
                                                                    <span
                                                                        class="float-right text-muted font-12 preview-hour">   {{App\User::getlastHour($instructor->id)}}</span>
                                                                        {{ App\User::find($instructor->id)->fullName}}
                                                                    </h5>
                                                                    <p class="mt-1 mb-0 text-muted font-14">

                                                            <span class="w-25 float-right text-right unread-container">

                                                                @if(($instructor->unread))
                                                                    <span
                                                                        class="unread-message badge badge-danger-lighten">{{$instructor->unread}}</span>
                                                                @endif
                                                            </span>

                                                                        <span class="w-75 preview-message">
                                                                {{App\User::getlastMessage($instructor->id)}}
                                                            </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach


                                            </div> <!-- end slimscroll-->
                                        </div> <!-- End col -->
                                    </div>
                                    <!-- end users -->
                                </div> <!-- end Tab Pane-->

                            </div> <!-- end tab content-->
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <!-- end chat users-->
                <div class="col-xl-5 col-lg-12 order-lg-2 order-xl-1 ">
                    <div class="card ">
                        <div class="card-body">
                            <ul class="conversation-list testa" data-simplebar style="max-height: 650px">
                                <div class="message-custom">

                                </div>
                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 c ol-lg-6 order-lg-1 order-xl-2">
                    <div class="card chat-info">

                    </div> <!-- end card-->
                </div>

            </div>

        </div> <!-- End Content -->


    </div> <!-- content-page -->




@endsection

@section('script')


    <script src="{{ mix('js/index/chat/message.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"></script>


    <script>

        $(document).ready(function () {


        });


    </script>

@endsection
