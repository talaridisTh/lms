@extends("layouts.app")

@section("style")
    <style>

        .left-side-menu-detached {
            display: none;
        }






        hr.style-two {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }

    </style>
@endsection

@section("content")

    <section class="d-flex flex-column">
        <div class="mb-3">
            <img class="img-thumbnail" src="{{asset("images/video.png")}}" alt="">
        </div>

        <div class="container" style="max-width: 1277px">
            <div class="row justify-content-center">
                @if(!empty($prevMaterial->slug))
                    <div class="arrow col-md-1 d-flex justify-content-center align-items-center">
                        <a data-toggle="tooltip" rel="tooltip" data-placement="left"
                           title="Προηγούμενο {{!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug}} "
                           href="{{route('index.material.show',[$course->id,!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug])}}">
                            <i class="cursor-pointer mdi h2 mdi-chevron-left"></i>
                        </a>
                    </div>
                @endif
                <div class="col-md-9 box-material mx-1" style="border-radius: 20px">
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center justify-content-center ">
                                    <img height="130" width="130" class="rounded-circle"
                                         src="data:image/png;base64,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"
                                         alt="">
                                </div>
                                <div class="col-md-8 text-white">
                                    <h3>{{$materials->title}}</h3>
                                    <span class="font-weight-bold font-12 ">
                                        Μάθημα {{$priority}} - {{$materials->created_at->format("d-m-y")}}
                                    </span>
                                    <p class="mt-3  font-weight-bold">Topic
                                        <a class="" href="{{route('index.userCourse',$course->id)}}">
                                            <span class="course-title">{{$course->title}}</span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div class="watchlist d-flex flex-column">
                                <button class="mb-2 btn btn-lg bghover text-white border btn-outline-secondary">
                                    <span class="font-weight-bold">Το έχω δει</span>
                                </button>
                                <button class="mb-2 btn btn-lg bghover text-white border btn-outline-secondary">
                                    <span class="font-weight-bold">Αγαπήμενα</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @if(!empty($nextMaterial->slug))
                    <div class="arrow col-md-1 d-flex justify-content-center align-items-center">
                        <a data-toggle="tooltip" rel="tooltip" data-placement="right"
                           title="Επόμενο {{!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug}} "
                           href="{{route('index.material.show',[$course->id,!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug])}}">
                            <i class="cursor-pointer mdi h2 mdi-chevron-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="container  my-3" style="max-width: 1187px">
            <div class="row ">
                <div class="col-md-9 ">
                    <div class="row background-material">
                        <div class="col-md-12">
                            <div class="row justify-content-between p-3">
                                <div class="col-md-6"><span class="font-weight-bold text-black">Εισηγητής </span>|
                                    {{$course->curator->first_name}}
                                </div>
                                <div class="col-md-6 text-right">
                                    <i class="mdi cursor-pointer h3 mdi-facebook"></i>
                                    <i class="mdi cursor-pointer h3 mdi-instagram"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  p-2">
                            <div class="row">
                                <div class="col-md-2"><img height="80" width="80" class="rounded-circle"
                                                           src="  {{$course->curator->avatar}}"
                                                           alt=""></div>
                                <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                                    <h4>Πληροφορίες </h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque consectetur
                                        dolorum molestias quas reprehenderit, sint?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row background-material mt-3">
                        <div class="col-md-12">
                            <div class=" p-3"><span class="font-weight-bold text-black">Σχετικά με το μάθημα</span>
                            </div>
                        </div>
                        <div class="col-md-12  px-3 py-1">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center pl-4 text-black">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aut autem libero
                                    magnam molestiae, optio qui saepe. Culpa id laudantium magni, neque officia
                                    perspiciatis ratione reprehenderit voluptate! Cum earum eos hic, illo numquam quae
                                    reiciendis repellat soluta! Aliquam, nulla, repudiandae.
                                </div>
                                <p class="d-flex align-items-center pl-4 mt-2 ">
                                    Δημοσιεύθηκε {{$materials->created_at->format("d-m-y")}}.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pl-3">
                    <div class="row hover-yellow">
                        <div class="col-md-12  border d-flex justify-content-between"
                             style="border-radius: 18px; padding: 9px;">
                            <div class="col-md-2 d-flex align-items-center">
                                <img height="40"
                                     src="data:image/png;base64,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"
                                     alt="">
                            </div>
                            <div class="col-md-10 ">
                                <a class="d-flex justify-content-center flex-column" href="{{route('index.userCourse',$course->id)}}">
                                <span
                                    class="font-16  text-center text-black font-weight-bold">{{$course->title}}</span>
                                <div class="d-flex justify-content-around">
                                    <span class="font-12 text-primary">Μέτριο</span>
                                    <span class="font-12">2 lessons</span>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    @foreach($MaterialsOrderByPriority as $material)
                        <div
                            class="row my-2 material-title @if($material->title==$materials->title) material-title-hover   @endif">
                            <div class="col-md-12 material-title cursor-pointer  border d-flex justify-content-between"
                                 style="border-radius: 5px;padding: 9px;">
                                <div class="col-md-2 d-flex align-items-center">
                                    @if($material->title==$materials->title)
                                        <i class=" now-play rounded-circle mdi h1 mdi-play-circle-outline"></i>
                                    @else
                                        <img height="40"
                                             src="https://laracasts.s3.amazonaws.com/series/thumbnails/css-quirks-and-pitfalls.png"
                                             alt="">
                                    @endif
                                </div>
                                <div class="col-md-10 ">
                                    <a class="d-flex justify-content-center flex-column" href="{{route('index.material.show',[$course->id,$material->slug])}}">
                                        <span
                                            class="font-16 text-center text-black font-weight-bold">{{$material->title}}</span>
                                        <div class="d-flex justify-content-around">
                                            <span class="font-12"> Μάθημα {{$material->priority}}</span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </section>

@endsection

<div>

</div>
<div>

</div>
<div class="col-md-6"></div>
@section("script")


    <script>


    </script>

@endsection
