<header id="header"
        class="lg:px-16 z-50 sticky top-0 px-8 bg-white py-4 shadow-md  "
        style="">

    <div class="container mx-auto max-w-1xl inline-flex sm:flex flex-wrap items-center px-1 intro-x">
        <div class="w-full flex-1 xl:inline-flex flex justify-between items-center">
            <a href="/tailwind"
               class="text-xl">
                <img class="{{$logo}}"
                     src="{{ $options->logo }}"
                     alt="{{ $options->title }}"
                     height="80">
            </a>
            @guest
                <a class="bg-login text-white px-4 py-3 rounded-full flex md:hidden focus:outline-none"
                   href="{{ route("login") }}">
                    <svg viewBox="0 0 24 24"
                         width="22"
                         height="22"
                         stroke="currentColor"
                         stroke-width="2"
                         fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         class="css-i6dzq1">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15"
                              y1="12"
                              x2="3"
                              y2="12"></line>
                    </svg>
                    <span class="ml-3">Σύνδεση</span>
                </a>
            @endguest
        </div>

        <div class="hidden md:flex md:items-center md:w-auto w-full"
             id="menu">
            <!-- BEGIN: Top Menu -->
            <nav class="top-nav">
                @auth
                    <ul class="p-0">
                        @hasanyrole("admin|super-admin")
                        <li class="orange-line intro-x">
                            <a href="{{route('dashboard')}}"
                               class="top-menu">
                                <div class="top-menu__icon"><i data-feather="tool"></i></div>
                                <div class="top-menu__title "
                                     style="font-size: 16px">Dashboard
                                </div>
                            </a>
                        </li>

                        @if(\Request::route()->getName()== "index.showCourse")
                            <li>
                                <a href="/dashboard/courses/{{$course->slug}}/edit"
                                   class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="edit"></i></div>
                                    <div class="top-menu__title"> Eπεξεργασία course</div>
                                </a>
                            </li>
                            <li class="orange-line hidden">>
                                <a href="#"
                                   class="top-menu">
                                    <div class="top-menu__icon"><i data-feather="home"></i></div>
                                    <div class="top-menu__title"> Edit this material</div>
                                </a>
                            </li>
                        @endif
                        @endhasanyrole
                        <li class="orange-line intro-x">
                            <a href="{{route('index.userCourses',auth()->id())}}"
                               class="top-menu">
                                <div class="top-menu__icon"><i data-feather="book-open"></i></div>
                                <div class="top-menu__title"
                                     style="font-size: 16px"> Μαθήματα
                                </div>
                            </a>
                        </li>

                        <li class=" orange-line intro-x">
                            <a href="{{route('discussion.index')}}"
                               class="top-menu relative contact">
                                <div class="top-menu__icon">
                                    <i data-feather="home"></i>
                                </div>

                                <div class="top-menu__title "
                                     style="font-size: 16px"> Επικοινωνία

                                    @if($notify)
                                        <span class="flex h-3 w-3 absolute top-2 right-2">
                                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                        </span>

                                    @endif
                                </div>
                            </a>
                        </li>

                        <li class="bg-login rounded-xl intro-x">
                            <a href="javascript:;"
                               class="top-menu"
                               style="color: white!important;">
                                <div class="top-menu__icon"><i data-feather="hard-drive"></i></div>
                                <div class="top-menu__title"
                                     style="font-size: 16px"> Ο λογαριασμός μου
                                    <i data-feather="chevron-down"
                                       class="top-menu__sub-icon"></i></div>
                            </a>
                            <ul class="py-2 "
                                style="z-index: 9999">
                                <li class="orange-line">
                                    <a href="{{route('index.account',auth()->user()->slug)}}"
                                       class="top-menu">
                                        <div class="top-menu__icon"><i data-feather="user"></i></div>
                                        <div class="top-menu__title"> Προφίλ</div>
                                    </a>
                                </li>
                                <li class="orange-line hidden">
                                    <a href="/message"
                                       class="top-menu js-message-seen">
                                        <div class="top-menu__icon"><i data-feather="mail"></i></div>
                                        <div class="top-menu__title justify-between"> Μηνύματα
                                            <span class="{{$options->seen->seen_message==0?"hidden":"inline-flex"}} js-message-badge  items-center justify-center px-2 py-1 text-xs
                    	                        font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$options->seen->seen_message}}</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="orange-line">
                                    <a href="{{route('discussion.index')}}"
                                       class="top-menu js-task-seen">
                                        <div class="top-menu__icon"><i data-feather="activity"></i></div>
                                        <div class="top-menu__title justify-between">
                                            Εργασίες
                                            <span class="{{$options->seen->seen_task==0?"hidden":"inline-flex"}} js-message-badge  items-center justify-center px-2 py-1 text-xs
                    	                        font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$options->seen->seen_task}}</span>
                                        </div>
                                    </a>
                                </li>
                                <li id="logout-btn"
                                    class="orange-line">
                                    <a href="{{route('logout')}}"
                                       class="top-menu">
                                        <div class="top-menu__icon"><i data-feather="log-out"></i></div>
                                        <div class="top-menu__title"> Έξοδος</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @guest
                            <a class="bg-login text-white px-4 py-3 rounded-full flex"
                               href="{{ route("login") }}">
                                <svg viewBox="0 0 24 24"
                                     width="22"
                                     height="22"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     fill="none"
                                     stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="css-i6dzq1">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15"
                                          y1="12"
                                          x2="3"
                                          y2="12"></line>
                                </svg>
                                <span class="ml-3">Σύνδεση</span>
                            </a>
                        @endguest
                    </ul>
            </nav>
            <!-- END: Top Menu -->
        </div>
    </div>
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        @auth
            <div class="mobile-menu-bar h-5">
                <a href=""
                   class="flex mr-auto"></a>
                <a href="#"
                   id="mobile-menu-toggler"
                   class="absolute right-8 top-12 z-50">
                    <i data-feather="bar-chart-2"
                       class="w-8 h-8 text-black transform -rotate-90"></i>
                </a>
            </div>
            <ul class="burger-menu py-5 hidden">
                @hasanyrole("admin|super-admin")
                <li class="hover:bg-gray-200 ">
                    <a href="{{route('dashboard')}}"
                       class="menu">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> Dashboard</div>
                    </a>
                </li>

                @if(\Request::route()->getName()== "index.showCourse")
                    <li>
                        <a href="/dashboard/courses/{{$course->slug}}/edit"
                           class="menu">
                            <div class="menu__icon"><i data-feather="edit"></i></div>
                            <div class="menu__title"> Eπεξεργασία course</div>
                        </a>
                    </li>
                    <li class="hover:bg-gray-200 hidden">
                        <a href="{{route('dashboard')}}"
                           class="menu">
                            <div class="menu__icon"><i data-feather="home"></i></div>
                            <div class="menu__title"> Edit this material</div>
                        </a>
                    </li>
                @endif
                @endhasanyrole
                <li class="hover:bg-gray-200 ">
                    <a href="{{route('dashboard')}}"
                       class="menu contact">
                        <div class="menu__icon"><i data-feather="home"></i></div>
                        <div class="menu__title"> Επικοινωνία</div>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center"></span>

                    </a>
                </li>
                <li class="hover:bg-gray-200 ">
                    <a href="{{route('index.userCourses',auth()->id())}}"
                       class="menu">
                        <div class="menu__icon"><i data-feather="book-open"></i></div>
                        <div class="menu__title"> Μαθήματα</div>
                    </a>
                </li>

                <li class=" ">
                    <a href="javascript:;"
                       class="menu hover:bg-gray-200 ">
                        <div class="menu__icon"><i data-feather="box"></i></div>
                        <div class="menu__title"> Ο λογαριασμος μου
                            <i data-feather="chevron-down"
                               class="menu__sub-icon"></i></div>
                    </a>
                    <ul class="">
                        <li id="logout-btn"
                            class="hover:bg-gray-200 bg-white border-t-0">
                            <a href="{{route('index.account',auth()->user()->slug)}}"
                               class="menu">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title"> Προφίλ</div>
                            </a>
                        </li>
                        <li id="logout-btn"
                            class="hover:bg-gray-200 hidden bg-white ">
                            <a href="/message"
                               class="menu js-message-seen">
                                <div class="menu__icon"><i data-feather="mail"></i></div>
                                <div class="menu__title"> Μηνύματα
                                    <span class="{{$options->seen->seen_message==0?"hidden":"inline-flex"}} js-message-badge  items-center justify-center px-2 py-1 text-xs
                    	                        font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$options->seen->seen_message}}</span>
                                </div>
                            </a>
                        </li>
                        <li id="logout-btn"
                            class="hover:bg-gray-200 bg-white ">
                            <a href="{{route('discussion.index')}}"
                               class="menu js-message-task">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title js-task-seen"> Εργασίες
                                    <span class="{{$options->seen->seen_task==0?"hidden":"inline-flex"}} js-message-badge  items-center justify-center px-2 py-1 text-xs
                    	                        font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$options->seen->seen_task}}</span>
                                </div>
                            </a>
                        </li>
                        <li id="logout-btn"
                            class="hover:bg-gray-200 bg-white ">
                            <a href="{{route('logout')}}"
                               class="menu">
                                <div class="menu__icon"><i data-feather="activity"></i></div>
                                <div class="menu__title"> Έξοδος</div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        @endauth
    </div>
    <!-- END: Mobile Menu -->
</header>