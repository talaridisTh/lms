<div class="left-side-menu left-side-menu-detached">


        <div class="leftbar-user">
            <a href="{{route('index.profile',Auth::user()->slug)}}">
                <img src="https://robohash.org/{{ Auth::user()->first_name }}.png?set=set5" alt="user-image"
                     height="42" class="rounded-circle shadow-sm">
                <span
                    class="leftbar-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </a>
            <p>({{$user->getRoleNames()[0]}})</p>
        </div>




<ul class="metismenu side-nav">


    <li class="side-nav-title side-nav-item"></li>

    <li class="side-nav-item">
        <a href="#" class="side-nav-link">
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
        <a href="{{route('index.profile',$user->slug)}}" class="side-nav-link">
            <i class="uil-calender"></i>
            <span>Profile</span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('index.profile.announcements',$user->slug)}}" class="side-nav-link">
            <i class="uil-calender"></i>
            <span>Ανακοινώσεις</span>
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
