@extends("layouts.app")

@section("style")

@endsection

@section("content")

    <div class="d-flex flex-column">

        <h1>Courses</h1>
    @foreach($watchlistCourses as $course)
        <h3>{{$course->title}}</h3>
    @endforeach


        <h1>Materials</h1>

        @foreach($watchlistMaterials as $material)
            <h3>{{$material->title}}</h3>

        @endforeach
    </div>
@endsection


@section("script")


    <script>


    </script>

@endsection
