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
            <div class="col-xl-3 col-lg-6 order-lg-1 order-xl-1" id="js-chat" data-auth-id="{{auth()->id()}}">
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#allUsers" data-toggle="tab" aria-expanded="false" class="nav-link active py-2">
                                    All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#favUsers" data-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Favourties
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#friendUsers" data-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Friends
                                </a>
                            </li>
                        </ul> <!-- end nav-->
                        <div class="tab-content">
                            <div class="tab-pane show active p-3" id="newpost">

                                <!-- start search box -->
                                <div class="app-search">
                                    <form >
                                        <div class="form-group position-relative">
                                            <input type="text" class="form-control"
                                                   placeholder="People, groups & messages..." />
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
                                                 <a id="{{ $instructor->id }}" href="javascript:void(0);" data-user-id="{{$instructor->id}}" class="js-message-chat text-body">
                                                <div class="media mt-1 p-2">
{{--                                                    <img src="{{ $instructor->cover}} " class="mr-2 rounded-circle" height="48" alt="{{$instructor->first_name}}" />--}}
                                                    <div class=" media-body" >

                                                        <h5 class="mt-0 mb-0 font-14">
                                                            <span class="float-right text-muted font-12">4:30am</span>
                                                            {{ App\User::find($instructor->id)->fullName}}
                                                        </h5>
                                                        <p class="mt-1 mb-0 text-muted font-14">

                                                            <span class="w-25 float-right text-right unread-container">

                                                                @if(($instructor->unread))
                                                                <span class="unread-message badge badge-danger-lighten">{{$instructor->unread}}</span>
                                                                @endif
                                                            </span>

                                                            <span class="w-75 preview-message"></span>
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
                        </div> <!-- end tab content-->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <!-- end chat users-->
            <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1 message-custom"></div>

            <div class="col-xl-3 col-lg-6 order-lg-1 order-xl-2">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">View full</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Edit Contact Info</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Remove</a>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <img src="assets/images/users/avatar-5.jpg" alt="shreyu"
                                 class="img-thumbnail avatar-lg rounded-circle" />
                            <h4>Shreyu N</h4>
                            <button class="btn btn-primary btn-sm mt-1"><i class='uil uil-envelope-add mr-1'></i>Send Email</button>
                            <p class="text-muted mt-2 font-14">Last Interacted: <strong>Few hours back</strong></p>
                        </div>

                        <div class="mt-3">
                            <hr class="" />

                            <p class="mt-4 mb-1"><strong><i class='uil uil-at'></i> Email:</strong></p>
                            <p>support@coderthemes.com</p>

                            <p class="mt-3 mb-1"><strong><i class='uil uil-phone'></i> Phone Number:</strong></p>
                            <p>+1 456 9595 9594</p>

                            <p class="mt-3 mb-1"><strong><i class='uil uil-location'></i> Location:</strong></p>
                            <p>California, USA</p>

                            <p class="mt-3 mb-1"><strong><i class='uil uil-globe'></i> Languages:</strong></p>
                            <p>English, German, Spanish</p>

                            <p class="mt-3 mb-2"><strong><i class='uil uil-users-alt'></i> Groups:</strong></p>
                            <p>
                                <span class="badge badge-success-lighten p-1 font-14">Work</span>
                                <span class="badge badge-primary-lighten p-1 font-14">Friends</span>
                            </p>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div>

        </div>

    </div> <!-- End Content -->



</div> <!-- content-page -->




@endsection

@section('script')

    <script src="{{ mix('js/index/chat/message.js') }}"></script>

    <script>

    </script>

@endsection
