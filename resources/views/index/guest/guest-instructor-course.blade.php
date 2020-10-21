@foreach($courses as $course)
    @php
      dd($course)
    @endphp

        <span class="badge badge-success-lighten p-1 font-12">{{$course->title}}</span>

@endforeach
