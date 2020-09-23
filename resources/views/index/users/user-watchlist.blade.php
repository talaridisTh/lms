@extends("layouts.app")

@section("style")

@endsection

@section("content")
    <div class="" style="max-height: 600px">
        @include("components.index.users.user-menu")
    </div>


    <div class="container my-5">



    <div class="d-flex flex-column">

        <h1>Courses</h1>
    @foreach($watchlistCourses as $course)
        <h3><a href="{{route('index.userCourse',$course->slug)}}">{{$course->title}}</a></h3>
    @endforeach


        <h1>Materials</h1>

        @foreach($watchlistMaterials as $material)
            <h3>{{$material->title}}</h3>

        @endforeach
    </div>
    </div>
@endsection


@section("script")


    <script>


    </script>

@endsection
