<div class="left-side-menu left-side-menu-detached ">


    <div class="leftbar-user ">
        <a href="{{route('index.profile',Auth::user()->slug)}}">
            <img src="https://robohash.org/{{ Auth::user()->first_name }}.png?set=set5" alt="user-image"
                 height="42" class="rounded-circle shadow-sm">
            <span
                class="leftbar-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
        </a>
        <p>({{auth()->user()->getRoleNames()[0]}})</p>
    </div>


    <ul class="metismenu side-nav">


        <li class="side-nav-item">
            <a href="/courses/{{ Auth::user()->slug }}" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Courses</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{route('index.profile.watchlist',auth()->user()->slug)}}" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Αγαπημένα</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="#" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Ιστορικό </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('index.profile',auth()->user()->slug)}}" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('index.profile.announcements',auth()->user()->slug)}}" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Ανακοινώσεις</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('index.message')}}" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>message</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="#" class="side-nav-link">
                <i class="uil-calender"></i>
                <span>Logout</span>
            </a>
        </li>


    </ul>
</div>
