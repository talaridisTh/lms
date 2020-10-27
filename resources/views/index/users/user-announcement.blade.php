@extends("layouts.app")

@section("style")

    <style>
        .bghover-red {
            background-color: red;
            display: inline;
            padding: 7px 10px;
            border-radius: 16px;
            color: white;
            font-size: 15px;
        }



         .wrapper  {
             max-height: 800px!important;
         }

        .sidebar {
            position: -webkit-sticky;
            position: sticky!important;
            top: 0!important;
        }

    </style>


@endsection

@section("content")
{{--    <x-alertMsg :msg="'update'"></x-alertMsg>--}}
{{--    @php($user = auth()->user())--}}



{{--    <div class="container-fluid p-5 my-3" style="height: 68vh">--}}
{{--            <div class="row ">--}}
{{--                @forelse($announcements as $announcement)--}}
{{--                <div class="col-md-6 p-3 " style="background: #fff">--}}
{{--                    <h4 class="bghover-red">{{$announcement->courses[0]->title}}</h4>--}}
{{--                    <h1 class="text-black my-3">{{$announcement->title}}</h1>--}}
{{--                    <p class="p-2">{{$announcement->description}}</p>--}}
{{--                    <a href="{{route('index.material.show',[$announcement->courses[0]->slug,$announcement->slug])}}"--}}
{{--                       class="btn ml-2 btn-sm btn-outline-secondary">Δες την ανακοίνωση </a>--}}
{{--                </div>--}}
{{--                @empty--}}
{{--                    <h3>Δεν υπάρχουν ανακοινώσεις</h3>--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--    </div>--}}

<div id='calendar'></div>


@endsection


@section("script")
    <script src="{{ mix("js/index/announcement/announcement.js") }}"></script>



    <script>

    </script>

@endsection
