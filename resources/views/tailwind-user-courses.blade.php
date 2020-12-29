@extends("tailwind")

@section("content")

    <article class="container mx-auto flex flex-wrap ">
        @forelse($courses as $course)
            <section class="overflow-hidden my-2 rounded-lg shadow-lg w-1/3  flex">

                <section class="flex flex-col w-3/12 justify-between h-full rounded-xl   py-5 space-y-10"
                         style="background:linear-gradient(315deg, rgb(255, 78, 0) 0%, rgb(236, 133, 5) 75%)">
                    <header class="flex items-center justify-center leading-tight pt-0 px-2 md:px-4">
{{--                                                <h1 class="text-lg bg-gray-200 px-4 py-1 rounded-full">--}}
                        {{--                                                    {{count($course->topics)?$course->topics->first()->title:"Γενικά"}}--}}
                        {{--                                                </h1>--}}
                    </header>

                    <figure class="flex justify-center">
                        <a href="#">
                            <img alt="Placeholder" class="block h-32 p-2 rounded-full"
                                 src="{{$course->roundedMediumCoverUrl("cover")}}">
                        </a>

                    </figure>


                </section>

                <section class="flex flex-col w-9/12  h-full p-5 justify-around">

                    <header class="flex items-center justify-start leading-tight  ">
                        <a href="{{route('index.showCourse',$course->slug)}}">
                            <h1 class="text-lg ">
                                {{$course->title}}
                            </h1>
                        </a>
                    </header>

                    <div class="text-sm">
                        <p>{!!\Str::limit($course->summary,100,"...")!!}</p>
                    </div>



                </section>
            </section>
        @empty

        @endforelse

    </article>
@endsection
@section("script")
    <script src="{{ mix('js/index/index.js') }}"></script>

@endsection
