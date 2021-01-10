<header id="header" class="lg:px-16 z-50 sticky top-0 px-8 bg-white py-4 shadow-md relative " style="">

    <div class="container mx-auto max-w-1xl flex flex-wrap items-center px-1 intro-x">
        <div class="flex-1 flex justify-between items-center">
            <a href="/tailwind" class="text-xl">
                <img class="{{$logo}}" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
            </a>
        </div>

        <div class="hidden md:flex md:items-center md:w-auto w-full" id="menu">
            <!-- BEGIN: Top Menu -->
            <nav class="top-nav">
                <ul class="p-0">
                    @hasanyrole("admin|super-admin")
                    <li class="orange-line intro-x">
                        <a href="{{route('dashboard')}}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="tool"></i></div>
                            <div class="top-menu__title ">Dashboard</div>
                        </a>
                    </li>

                    @if(\Request::route()->getName()== "index.userCourse")
                        <li>
                            <a href="#" class="top-menu">
                                <div class="top-menu__icon"><i data-feather="home"></i></div>
                                <div class="top-menu__title"> edit this course</div>
                            </a>
                        </li>
                        <li class="orange-line">>
                            <a href="#" class="top-menu">
                                <div class="top-menu__icon"><i data-feather="home"></i></div>
                                <div class="top-menu__title"> Edit this material</div>
                            </a>
                        </li>
                    @endif
                    @endhasanyrole
                    <li class="orange-line intro-x">
                        <a href="{{route('index.userCourses',auth()->id())}}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="home"></i></div>
                            <div class="top-menu__title"> Μαθήματα</div>
                        </a>
                    </li>

                    <li class=" orange-line intro-x">
                        <a href="{{route('discussion.index')}}" class="top-menu relative js-task-seen">

                            <div class="top-menu__icon">
                                @if($options->seen->seen_task)
                                    <span class=" absolute -left-2 inline-flex items-center justify-center px-2
                                     py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                        {{$options->seen->seen_task}}
                                    </span>
                                @else
                                    <i data-feather="home"></i>
                                @endif
                            </div>
                            <div class="top-menu__title "> Discussions

                            </div>

                        </a>
                    </li>


                    <li class="bg-login rounded-xl intro-x">
                        <a href="javascript:;" class="top-menu" style="color: white!important;">
                            <div class="top-menu__icon"><i data-feather="hard-drive"></i></div>
                            <div class="top-menu__title"> Ο λογαριασμος μου <i data-feather="chevron-down"
                                                                               class="top-menu__sub-icon"></i></div>
                        </a>
                        <ul class="py-2">
                            <li class="orange-line">
                                <a href="{{route('index.account',auth()->user()->slug)}}" class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="user"></i></div>
                                    <div class="top-menu__title"> My account</div>
                                </a>
                            </li>
                            <li class="orange-line">
                                <a href="/message" class="top-menu js-message-seen">
                                    <div class="top-menu__icon"><i data-feather="activity"></i></div>
                                    <div class="top-menu__title justify-between"> Μηνύματα
                                        <span class="{{$options->seen->seen_message==0?"hidden":"inline-flex"}} js-message-badge  items-center justify-center px-2 py-1 text-xs
                                            font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$options->seen->seen_message}}</span>
                                    </div>
                                </a>
                            </li>
                            <li id="logout-btn" class="orange-line">
                                <a href="top-menu-light-image-zoom.html" class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="log-out"></i></div>
                                    <div class="top-menu__title"> Έξοδος</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- END: Top Menu -->
        </div>
    </div>
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto"></a>
            <a href="#" id="mobile-menu-toggler" class="absolute right-8 top-12">
                <i data-feather="bar-chart-2"
                   class="w-8 h-8 text-black transform -rotate-90"></i>
            </a>
        </div>
        <ul class="burger-menu py-5 hidden">
            @hasanyrole("admin|super-admin")
            <li>
                <a href="{{route('dashboard')}}" class="menu">
                    <div class="menu__icon"><i data-feather="home"></i></div>
                    <div class="menu__title"> Dashboard</div>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard')}}" class="menu">
                    <div class="menu__icon"><i data-feather="home"></i></div>
                    <div class="menu__title"> edit this course</div>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard')}}" class="menu">
                    <div class="menu__icon"><i data-feather="home"></i></div>
                    <div class="menu__title"> Edit this material</div>
                </a>
            </li>

            @endhasanyrole
            <li>
                <a href="{{route('dashboard')}}" class="menu">
                    <div class="menu__icon"><i data-feather="home"></i></div>
                    <div class="menu__title"> Discussions</div>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center

                    </a>
                </li>

                <li>
                    <a href=" javascript:;" class="menu">
                    <div class="menu__icon"><i data-feather="box"></i></div>
                    <div class="menu__title"> Ο λογαριασμος μου <i data-feather="chevron-down"
                                                                   class="menu__sub-icon"></i></div>
                </a>
                <ul class="">
                    <li>
                        <a href="index.html" class="menu">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title"> Side Menu</div>
                        </a>
                    </li>
                    <li>
                        <a href="simple-menu-light-dashboard.html" class="menu">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title"> Simple Menu</div>
                        </a>
                    </li>
                    <li id="logout-btn">
                        <a href="top-menu-light-dashboard.html" class="menu">
                            <div class="menu__icon"><i data-feather="activity"></i></div>
                            <div class="menu__title"> Έξοδος</div>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
    <!-- END: Mobile Menu -->
</header>