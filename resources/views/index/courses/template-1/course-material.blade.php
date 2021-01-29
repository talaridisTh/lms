@extends("layouts.app")

@section("content")
    <article class="mdc:container mx-auto flex flex-col spa-cnt-material">

        <section class="flex justify-between mb-7 items-center">
            <h2 class="text-4xl ">{{$material->title}}</h2>
            <div class="flex space-x-2">
                <i class="mdi text-xl  mdi-window-maximize js-open-fullscreen hidden cursor-pointer"></i>
                <i class="mdi text-xl  mdi-close-box-multiple js-close-fullscreen cursor-pointer"></i>
            </div>
        </section>


        <x-index.courses.section-tabs
                :curator=$curator
                :fields="$fields"
                :model="$material"
        >
        </x-index.courses.section-tabs>

    </article>
@endsection
@section("script")
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>



@endsection
