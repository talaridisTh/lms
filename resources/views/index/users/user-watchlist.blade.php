@extends("layouts.app")

@section("style")

@endsection

@section("content")

    <div class="container my-5">
    <div class="d-flex flex-column" style="height: 55vh">

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
