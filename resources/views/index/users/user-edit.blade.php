@extends("layouts.app")


@section("content")
    <article class="container lg:min-h-screen	 mx-auto">

        <div class="-intro-x breadcrumb mr-auto hidden sm:flex my-4 p-1"><!-- BEGIN: breadcrumb -->
            <a href="{{route('home')}}" class="">Home</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="" class="breadcrumb--active">Profile</a>
        </div><!-- END: breadcrumb -->

        <section class="flex flex-wrap space-x-10"><!-- BEGIN: container user-profil -->

            <aside class="flex-1 flex flex-col space-y-6 p-6  bg-card-color rounded-lg">
                <!-- BEGIN: left sidebar user profil -->

                <figure class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="user-avatar" class="rounded-full" src="https://placeimg.com/200/200/any">
                    <div
                        class="absolute mb-1 mr-1 flex items-center justify-center top-0 right-0 bg-theme-1 rounded-full p-2">
                        <i class="w-4 h-4 text-white" data-feather="camera"></i>
                    </div>
                </figure>

                <section class="capitalize">
                    <h2 class="text-black text-xl font-bold">{{$user->fullname}}</h2>
                    <p class="text-gray-500 text-sm ">{{$user->getRoleNames()[0]}}</p>
                </section>

                <div>
                    <p class="text-black text-base font-semibold capitalize">Bio</p>
                    <p>{{$user->profil}}
                        <span class="text-blue-800 cursor-pointer">More...</span>
                    </p>
                </div>

                <hr class="my-4 ">

                @if($existSocials)
                    <section class="space-y-4">
                        <h4 class="text-black text-base font-semibold capitalize">social</h4>

                        @isset($user->facebook_link)
                            <div class="flex space-x-10">
                                <div class="flex items-center p-2 rounded-full"
                                     style="background-color: rgba(40, 92, 247, 0.2) !important;">
                                    <i class="font-2xl text-blue-700" data-feather="facebook"></i>
                                </div>
                                <div class="">
                                    <p class="text-sm text-gray-500">Facebook</p>
                                    <p class="text-sm text-gray-500 font-bold">{{$user->facebook_link}}</p>
                                </div>
                            </div>
                        @endisset

                        @isset($user->instagram_link)
                            <div class="flex space-x-10">
                                <div class="flex items-center p-2 rounded-full"
                                     style="background: rgba(243, 161, 161, 0.3) !important;">
                                    <i class="font-2xl text-pink-600" data-feather="instagram"></i>
                                </div>
                                <div class="">
                                    <p class="text-sm text-gray-500">Instagram</p>
                                    <p class="text-sm text-gray-500 font-bold">{{$user->instagram_link}}</p>
                                </div>
                            </div>
                        @endisset
                        @isset($user->linkedin_link)
                            <div class="flex space-x-10">
                                <div class="flex items-center p-2 rounded-full"
                                     style="background-color: rgba(57, 175, 209, 0.13) !important;">
                                    <i class="font-2xl text-teal-900" data-feather="linkedin"></i>
                                </div>
                                <div class="">
                                    <p class="text-sm text-gray-500">linkedin</p>
                                    <p class="text-sm text-gray-500 font-bold">{{$user->linkedin_link}}</p>
                                </div>
                            </div>
                        @endisset
                        @isset($user->youtube_link)
                            <div class="flex space-x-10">
                                <div class="flex items-center p-2 rounded-full"
                                     style="background-color: rgba(255, 0, 0, 0.3) !important;">
                                    <i class="font-2xl text-red-700" data-feather="youtube"></i>
                                </div>
                                <div class="">
                                    <p class="text-sm text-gray-500">youtube</p>
                                    <p class="text-sm text-gray-500 font-bold">{{$user->youtube_link}}</p>
                                </div>
                            </div>
                        @endisset
                    </section>
                    <hr class="my-4">
                @endif

                <div class="space-y-4">
                    <h4 class="text-black text-base font-semibold capitalize">Μαθήματα</h4>

                    <div class="space-y-2">
                        <span>Javascript</span>
                        <div class="w-full h-3 bg-gray-400 dark:bg-dark-1 rounded-full">
                            <div class="w-1/2 h-full bg-theme-1 rounded-full"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <span>Php</span>
                        <div class="w-full h-3  bg-gray-400 dark:bg-dark-1 rounded mt-3">
                            <div class="w-2/3 h-full bg-theme-9 rounded"></div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <span>Laravel</span>
                        <div class="w-full h-3  bg-gray-400 dark:bg-dark-1 rounded mt-3">
                            <div class="w-3/4 h-full bg-theme-12 rounded"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <span>React</span>
                        <div class="w-full h-3  bg-gray-400 dark:bg-dark-1 rounded mt-3">
                            <div class="w-3/4 h-full bg-theme-6 rounded"></div>
                        </div>
                    </div>
                </div>
            </aside><!-- END: left sidebar user-profile -->

            <section class="flex-2 space-y-6"> <!-- BEGIN: header right sidebar -->

                <header class="flex flex-wrap space-x-5 capitalize"><!-- BEGIN: top right sidebar count materelials -->
                    <div class="bg-card-color rounded-lg flex-1 flex justify-between px-4 py-6 items-center">
                        <div class="p-4 rounded-full" style="background-color: rgba(0, 255, 0, 0.2) !important;">
                            <i class="text-green-700 p-0 m-0" data-feather="book"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-semibold">courses</p>
                            <p class="text-lg font-semibold">{{$sumCourses}}</p>
                        </div>
                    </div>
                    <div class="bg-card-color rounded-lg flex-1 flex justify-between px-4 py-6 items-center">
                        <div class="p-4 rounded-full" style="background-color: rgba(75,0,130, 0.2) !important;">
                            <i class="text-indigo-700 p-0 m-0" data-feather="book-open"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-semibold">Μαθήματα</p>
                            <p class="text-lg font-semibold">{{$sumMaterials}}</p>
                        </div>
                    </div>
                    <div class="bg-card-color rounded-lg flex-1 flex justify-between px-4 py-6 items-center">
                        <div class="p-4 rounded-full" style="background-color: rgba(255, 255, 0, 0.2) !important;">
                            <i class="text-yellow-700 p-0 m-0" data-feather="bookmark"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-semibold">Bundles</p>
                            <p class="text-lg font-semibold">{{$sumBundles}}</p>
                        </div>
                    </div>
                </header><!-- END: top right sidebar count materelials -->

                <section>
                    <!-- BEGIN: tabs -->
                    <div class="col-span-12 lg:col-span-4">
                        <div class="intro-y pr-1 w-4/12">
                            <div class="box ">
                                <div class="pos__tabs nav-tabs justify-center flex space-x-2">
                                    <a data-toggle="tab" data-target="#settings-user" href="javascript:;"
                                       class="flex-1 py-2 rounded-md text-center border border-b-0 border-gray-300 active rounded-b-none text-lg">Στοιχεία</a>
                                    <a data-toggle="tab" data-target="#social-link" href="javascript:;"
                                       class="flex-1 py-2 rounded-md border border-b-0 border-gray-300  text-center text-lg rounded-b-none">Social</a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" style="padding:0;"><!-- BEGIN: tab content -->
                            <div class="tab-content__pane active border pt-0 px-6 py-4" id="settings-user">
                                <div class="intro-y box lg:mt-5 capitalize space-y-4">
                                    <div>
                                        <label>όνομα</label>
                                        <input type="text" class="input w-full border mt-2"
                                               placeholder="Eισάγετε όνομα">
                                    </div>

                                    <div>
                                        <label>επιθετο</label>
                                        <input type="text" class="input w-full border mt-2"
                                               placeholder="Eισάγετε όνομα">
                                    </div>

                                    <div>
                                        <label class="">Email</label>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                @
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε email">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="">Τηλέφωνο</label>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                <i class="" data-feather="phone"></i>
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε Τηλέφωνο">
                                        </div>
                                    </div>

                                    <div>
                                        <label>password</label>
                                        <input type="text"
                                               class="input w-full border mt-2"
                                               placeholder="6-15 χαρακτήρες">
                                        <div class="w-full grid grid-cols-12 gap-4 h-1 mt-3">
                                            <div class="col-span-3 hidden h-full rounded bg-theme-9"></div>
                                            <div class="col-span-3 hidden h-full rounded bg-theme-9"></div>
                                            <div class="col-span-3 hidden h-full rounded bg-theme-9"></div>
                                            <div
                                                class="col-span-3  hidden h-full rounded bg-gray-200 dark:bg-dark-1"></div>
                                        </div>
                                        <div class="text-theme-9 hidden mt-2">Strong password</div>
                                    </div>

                                    <div class="mt-3">
                                        <label>re password</label>
                                        <input type="text"
                                               class="input w-full border  mt-2"
                                               placeholder="6-15 χαρακτήρες">
                                        <div class="text-theme-12 hidden mt-2">Attempting to reconnect to server...
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-content__pane border px-6 py-4" id="social-link">
                                <div class="intro-y box lg:mt-5 capitalize space-y-4 ">

                                    <div>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                <i data-feather="facebook"></i>
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε link">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                <i data-feather="instagram"></i>
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε link">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                <i data-feather="linkedin"></i>
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε link">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mt-2 relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center
                                             justify-center bg-gray-100 dark:bg-dark-1 dark:border-dark-4 border text-gray-600">
                                                <i data-feather="youtube"></i>
                                            </div>
                                            <input type="text" class="input pl-12 w-full border col-span-4"
                                                   placeholder="Eισάγετε link">
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <button
                                class="inline-block mt-3 px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-blue-700 rounded shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none"
                            >
                                Primary
                            </button>
                        </div><!-- END: tab content -->
                    </div>
                    <!-- END: tabs -->
                </section>

            </section>

        </section><!-- END: container user-profil -->


    </article>
@endsection


@section("script")
    <script src="{{ mix('js/index/user/user-edit.js') }}"></script>
@endsection

