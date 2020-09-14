@extends("layouts.app")

@section("style")
    <style>
        .bghover-red{
            background-color: red;
            display: inline;
            padding: 7px 10px;
            border-radius: 16px;
            color: white;
            font-size: 15px;
        }
    </style>


@endsection

@section("content")
    <x-alertMsg :msg="'update'"></x-alertMsg>
    @php($user = auth()->user())


    <div class="left-side-menu left-side-menu-detached">

{{--        @auth--}}
{{--            <div class="leftbar-user">--}}
{{--                <a href="{{route('index.profile',Auth::user()->slug)}}">--}}
{{--                    <img src="https://robohash.org/{{ Auth::user()->first_name }}.png?set=set5" alt="user-image"--}}
{{--                         height="42" class="rounded-circle shadow-sm">--}}
{{--                    <span--}}
{{--                        class="leftbar-user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>--}}
{{--                </a>--}}
{{--            </div>\--}}

{{--        @endauth--}}


    <!--- Sidemenu -->
        @include("components.index.users.user-menu")

    </div>

    <div class="container-fluid p-5 my-3">
        @forelse($announcements as $announcement)
        <div class="row " >
            <div class="col-md-6 p-3 "style="background: #fff">
                <h4 class="bghover-red">{{$announcement->courses[0]->title}}</h4>
                <h1 class="text-black my-3">{{$announcement->title}}</h1>
                <p class="p-2">{{$announcement->description}}</p>
                <a href="{{route('index.material.show',[$announcement->courses[0]->slug,$announcement->slug])}}" class="btn ml-2 btn-sm btn-outline-secondary">Δες την ανακοίνωση </a>

            </div>
            @empty
                <h3>Δεν υπάρχουν ανακοινώσεις</h3>
            @endforelse
        </div>



@endsection


@section("script")


    <script>


    </script>

@endsection
