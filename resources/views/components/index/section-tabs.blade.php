<div id="scrollTo"></div>
<section class="w-full lg:w-4/6 spa-cnt">
    <section class="bg-gray-200 rounded-xl flex  space-x-6 px-8 py-6">
        <figure
            class="group hidden  md:table w-32 h-32 rounded-full overflow-hidden text-center bg-purple table cursor-pointer ">
            <img src="{{$curator->avatar}}"
                 class=" rounded-full object-cover object-center w-full h-full visible group-hover:hidden"
                 alt="avatar-curator">
        </figure>
        <section class="space-y-4">
            <section class="flex justify-between">
                <h5 class="ml-1"><span class="text-lg font-bold">Εισηγητής</span> <span
                        class="font-semibold">- {{$curator->fullname}}</span>
                </h5>
                <figure class="text-xl items-center space-x-3 flex hidden">
                    @if($curator->facebook_link)
                        <img src="{{asset("images/facebook-1.png")}}" alt="">
                    @endif
                    @if($curator->instagram_link)
                        <img src="{{asset("images/linked-in.png")}}" alt="">
                    @endif
                    @if($curator->linkedin_link)
                        <img src="{{asset("images/twitter-1.png")}}" alt="">
                    @endif
                    @if($curator->youtube_link)
                        <img src="{{asset("images/twitter-1.png")}}" alt="">
                    @endif
                </figure>

            </section>
            <p class="w-11/12 ml-1">{!!$curator->profil!!} </p>
        </section>
    </section>
    <div class="rounded mx-auto mt-7">
        <!-- Tabs -->
        <ul id="tabs" class="inline-flex px-1 w-full space-x-1">
            @if(get_class($model)=="App\Models\Material")
                <li class="bg-white px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t border-t border-r border-l -mb-px {{$fields->content==0?"hidden":""}}">
                    <a href="#content">Content</a>
                </li>
            @endif
            <li class="bg-white px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t border-t border-r border-l -mb-px {{$fields->description==0?"hidden":""}}">
                <a href="#first">Πληροφορίες</a>
            </li>
            <li class="px-4 text-gray-80 bg-gray-100 font-semibold py-2 rounded-t {{$fields->summary==0?"hidden":""}}">
                <a
                    href="#second">Περίληψη</a></li>
            <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->file==0?"hidden":""}}">
                <a href="#third">Αρχεία</a>
            </li>
            <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->media==0?"hidden":""}}">
                <a href="#fourth">Media</a>
            </li>
            <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t {{$fields->script==0?"hidden":""}}">
                <a href="#quiz">Quiz</a></li>
            <li class="px-4 text-gray-80 bg-gray-200 font-semibold py-2 rounded-t "><a
                    href="#disscussion">Συζήτηση</a>
            </li>
        </ul>
        <!-- Tab Contents -->
        <div id="tab-contents" class="ml-1 border-1 border-gray-200 py-3 px-10">
            @if(get_class($model)=="App\Models\Material")
                <div id="content" class=" hidden py-7 px-4">

                    {!! $model->content !!}
                </div>
            @endif
            <div id="first" class=" hidden py-6 px-4">

                {!! $model->description !!}
            </div>
            <div id="second" class="hidden py-6 px-4 list-inside">

                {!! $model->summary !!}
            </div>
            <div id="third" class="hidden py-6 px-4">

                @foreach($model->media->where("type",1) as $file)
                    <div
                        class="text-gray-600 px-2 flex w-1/2 items-center justify-between hover:bg-gray-400 rounded-lg hover:text-white cursor-pointer">
                        <a class=" p-2" href="{{$file->rel_path}}" target="_blank">
                            <span>{{$file->original_name}}.{{$file->ext}}</span>
                        </a>
                        <a href="{{$file->rel_path}}" download>
                            <i class="mdi-24px mdi mdi-cloud-download-outline mr-1"></i>
                        </a>
                    </div>
                @endforeach
                {{--                    {!! $model->media->where("type",1) !!}--}}
            </div>
            <figure id="fourth" class="hidden py-6 px-4 flex flex-wrap space-x-4">

                @foreach($model->media->where("type",0) as $file)
                    <a href="{{$file->rel_path}} " data-lightbox="image-1">
                        <img class="rounded-lg" src="{{$file->roundedMediumCoverUrl("rel_path")}}"
                             alt="{{$file->name}}">
                    </a>
                @endforeach
            </figure>
            <div id="quiz" class="hidden py-6 px-4">

                {!! $model->script !!}
            </div>
            <div id="disscussion" class="py-6 px-4">

                Συζήτηση
            </div>
        </div>
    </div>
</section>
