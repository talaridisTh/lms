@extends("layouts.app")

@section("style")
@endsection

@section("content")
    <div class="container">
        <form action="{{route('user.linkStore')}}" method='post'>
            @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Καθηγητης</label>
            </div>
            <select name="user_id" class="custom-select" id="inputGroupSelect01">
                @role("admin")
                <option selected>Choose...</option>
                @foreach($partners as $partner)
                <option value="{{$partner->id}}">{{$partner->fullName}}</option>
                @endforeach
                @endrole
                @hasanyrole('instructor|partner')
                    <option value="{{auth()->user()->id}}">{{auth()->user()->fullName}}</option>
                @endrole
            </select>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Course</label>
            </div>
            <select name="course_id"  class="custom-select" id="inputGroupSelect01">
                <option selected>Choose...</option>
                @foreach($courses as $course)
                    <option value="{{$course->id}}">{{$course->name}}</option>
                @endforeach
            </select>
        </div>
            <input type="submit"  value="Δημιουργία Link" class="btn btn-primary">
        </form>

    </div>
@endsection



@section("script")
    <script src="/assets/js/pages/demo.form-wizard.js"></script>
@endsection




