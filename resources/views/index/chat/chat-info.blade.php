<div class="card-body" style="height: 650px">
    <div class="dropdown float-right">
        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
           aria-expanded="false">
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
        <img src="{{$user->avatar}}" alt="shreyu"
             class="img-thumbnail avatar-lg rounded-circle"/>
        <h4>{{$user->fullName}}</h4>
        <button class="btn btn-primary btn-sm mt-1"><i class='uil uil-envelope-add mr-1'></i>Send
            Email
        </button>
{{--        <p class="text-muted mt-2 font-14">Last Interacted: <strong>Few hours back</strong></p>--}}
    </div>

    <div class="mt-3">
        <hr class=""/>

        <p class="mt-4 mb-1"><strong><i class='uil uil-at'></i> Email:</strong></p>
        <p>{{$user->email}}</p>

        <p class="mt-3 mb-1"><strong><i class='uil uil-phone'></i> Phone Number:</strong></p>
        <p>{{$user->phone}}</p>

        <p class="mt-3 mb-1"><strong><i class='uil uil-location'></i> Location:</strong></p>
        <p>Greece</p>


        <p class="mt-3 mb-2"><strong><i class='uil uil-users-alt'></i> Courses</strong></p>
        <p>
            @foreach($user->courses as $course)
            <span class="badge badge-success-lighten p-1 m-1 font-14">{{$course->title}}</span>
            @endforeach
        </p>
    </div>
</div> <!-- end card-body -->
