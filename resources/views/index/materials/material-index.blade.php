@extends("layouts.app")

@section("style")

@endsection

@section("content")

    <section class="d-flex wrapper flex-column">
        @role("admin")

        <div class="card ribbon-box" style="background-color: #FAFBFE">
            <div class="card-body py-0">
                <div class="ribbon ribbon-secondary float-right"><i class="mdi mdi-access-point mr-1"></i>
                    <a class="text-white ribbon-edit" href="{{route('material.show',$materials->slug)}}">
                        <spant class="ribbon-edit">Edit this page</spant>
                    </a>
                </div>
            </div> <!-- end card-body -->
        </div>
        @endrole
        @if($materials->video_link)
            <div class=" container text-center ">
                @if(strlen($materials->video_link)<12 )
                    <iframe src="https://player.vimeo.com/video/{{$materials->video_link}}"
                            width="1024" height="768" frameborder="0" allow="autoplay; fullscreen"
                            allowfullscreen></iframe>
                @else
                    <iframe src="{{$materials->video_link}}" width="1024" height="768" frameborder="0"
                            allow="autoplay; fullscreen" allowfullscreen></iframe>

                @endif
            </div>
        @else
            <img class="img-thumbnail" src="{{asset("images/video.png")}}" alt="">
        @endif
        <div class="container" style="max-width: 1277px">
            <div class="row justify-content-center">
                @if(!empty($prevMaterial->slug))
                    <div class="arrow col-md-1 d-flex justify-content-center align-items-center">
                        <a data-toggle="tooltip" rel="tooltip" data-placement="left"
                           title="Προηγούμενο {{!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug}} "
                           href="{{route('index.material.show',[$course->slug,!empty($prevMaterial->slug)? $prevMaterial->slug : $materials->slug])}}">
                            <i class="cursor-pointer mdi h2 mdi-chevron-left"></i>
                        </a>
                    </div>
                @endif
                <div class="col-md-9 box-material mx-1" style="border-radius: 20px">
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center justify-content-center ">
                                    <img height="130" width="130" class=" rounded-circle"
                                         src="{{$materials->cover}}"
                                         alt="">
                                </div>
                                <div class="col-md-8 text-white">
                                    <h3>{{$materials->title}}</h3>
                                    <span class="font-weight-bold font-12 ">
                                    Μάθημα {{$priority}} - {{$materials->created_at->format("d-m-y")}}
                                </span>
                                    <p class="mt-3  font-weight-bold">Μάθημα
                                        <a class="" href="{{route('index.userCourse',$course->slug)}}">
                                            <span class="course-title">{{$course->title}}</span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div class="watchlist  d-flex flex-column">
                                <button class="mb-2  btn btn-lg bghover text-white border btn-outline-secondary">
                                    <span class="font-weight-bold">Το έχω δει</span>
                                </button>
                                <button
                                    data-model="material" data-model-id="{{$materials->id}}"
                                    data-user-id="{{auth()->id()}}"
                                    class=" add-watchlist mb-2 btn btn-lg bghover text-white border btn-outline-secondary">
                                    <i class="font-16
                                     {{!count(auth()->user()->watchlistMaterial->whereIn("title",$materials->title))?"mdi mdi-heart-outline":"mdi mdi-cards-heart"}}
                                        ">
                                    </i> <span>Προσθήκη στα αγαπημένα</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @if(!empty($nextMaterial->slug))
                    <div class="arrow col-md-1 d-flex justify-content-center align-items-center">
                        <a data-toggle="tooltip" rel="tooltip" data-placement="right"
                           title="Επόμενο {{!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug}} "
                           href="{{route('index.material.show',[$course->slug,!empty($nextMaterial->slug)? $nextMaterial->slug : $materials->slug])}}">
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
                        <div class="col-md-12 ">
                            <div class="row mb-1">
                                <div class="col-md-2 pt-2 text-center">
                                    <img height="80" width="80" class="img-fluid img-thumbnail rounded-circle"
                                         src="  {{$course->curator->cover}}"
                                         alt=""></div>
                                <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>Πληροφορίες </h4>
                                            <p> {{$course->curator->profil}}
                                            </p>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
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
                                    {{$materials->description}}
                                </div>
                                <p class="d-flex align-items-center pl-4 mt-2 ">
                                    Δημοσιεύθηκε {{$materials->created_at->format("d-m-y")}}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class=" p-3"><span class="font-weight-bold text-black">Σχετικά με το μάθημα</span>
                        </div>
                        <div class="col-md-12  px-3 {{empty($course->description)?"d-none":""}}">
                            {!! $course->description !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-3 pl-3">
                    <div class="row hover-yellow">
                        <div class="col-md-12  border d-flex justify-content-between"
                             style="border-radius: 18px; padding: 9px;">
                            <div class="col-md-2 d-flex align-items-center">
                                <img height="40" width="40" class="rounded-circle"
                                     src="{{$course->cover=="vaggelaras"? "http://lorempixel.com/300/300":url($course->cover)}}"
                                     alt="">
                            </div>
                            <div class="col-md-10 ">
                                <a class="d-flex justify-content-center flex-column"
                                   href="{{route('index.userCourse',$course->slug)}}">
                                    <span
                                        class="font-18  text-center text-black font-weight-bold">{{$course->title}}</span>
                                    <div class="d-flex justify-content-around">
                                        {{--                                        <span class="font-12 text-primary">Μέτριο</span>--}}
                                        <span class="font-14">{{$MaterialsOrderByPriority->count()}} Μάθηματα</span>

                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <hr class="text-blac">

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
                                             width="40"
                                             src="{{$material->cover}}"
                                             class="rounded-circle"
                                             alt="">
                                    @endif
                                </div>
                                <div class="col-md-10 ">
                                    <a class="d-flex justify-content-center flex-column"
                                       href="{{route('index.material.show',[$course->slug,$material->slug])}}">
                                <span
                                    class="font-16 text-center text-black font-weight-bold">{{$material->title}}</span>
                                        <div class="d-flex justify-content-around align-items-center">
                                            <span class="font-12"> Μάθημα {{$material->priority}}</span>
                                            <span class="font-16"><i
                                                    class="{{App\Material::find($material->material_id)->type}}"></i></span>
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

@section("script")
    <script src="{{ mix('js/index/materials/indexMaterials.js') }}"></script>


    <script>


    </script>

@endsection
