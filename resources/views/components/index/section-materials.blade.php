<aside class="space-y-5 mt-5 lg:mt-0 w-full lg:w-2/6 spa-list-material lg:pl-2">
    @if($course->media->where("type",1)->count())
        <div class="row intr-y">
            <div class="col">
                <div class="tabs">
                    <div class="tab bg-gray-200 px-4 em-padding">
                        <input class="input-tab" type="checkbox" id="extra-file">
                        <label class="tab-label text-black  text-lg p-2" for="extra-file"><span
                                class="">Βοηθητικά αρχεία</span></label>
                        @foreach($course->media->where("type",1) as $file)
                            <div
                                class="tab-content text-gray-600 flex justify-between zoom-in rounded-lg hover:text-black cursor-pointer">
                                <a class="mt-2" href="{{$file->rel_path}}" target="_blank">
                                    <span>{{$file->original_name}}.{{$file->ext}}</span>
                                </a>
                                <a href="{{$file->rel_path}}" download>
                                    <i class="mdi-24px mdi mdi-cloud-download-outline mr-1"></i>
                                </a>

                            </div>
                            @if($loop->last)
                                <div></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($lessons->count())
        <div class="row intro-y">
            <div class="col">
                <div class="tabs">
                    <div class="tab bg-gray-200 px-4 em-padding">
                        <input class="input-tab" type="checkbox" id="material-file">
                        <label class="tab-label text-black  text-lg p-2" for="material-file"><span
                                class="">Μαθήματα</span></label>
                        @foreach($lessons as $lesson)
                            <div
                                class="tab-content text-gray-600 zoom-in flex justify-between  rounded-lg  hover:text-black cursor-pointer spa-click"
                                data-href="{{$lesson->type=="Link"?$lesson->link:route('index.showMaterial',[$course->slug,$lesson->slug])}}"
                                data-type="{{$lesson->type}}"
                            >
                                        <span style="flex-basis: 10%;"
                                              class="mt-1 font-semibold">{{$loop->index+1}}</span>
                                <a class="mt-1  flex-1" href="">
                                    <span class="">{{$lesson->title}}</span>
                                </a>
                                <i style="flex-basis: 10%;"
                                   class="mt-1 mr-1 text-right  {{$lesson->getType($lesson->type)}}"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($isSectionExist->isNotEmpty())
        <div class="row intro-y">
            <div class="col">
                <div class="tabs ">
                    <div class="tab bg-gray-200 px-4 ">
                        <input class="input-tab" type="checkbox" id="sections">
                        <label class="tab-label text-black text-lg my-1 p-2" for="sections"><span
                                class="">Ενότητες</span></label>
                        <div class="tab-content text-gray-600 p-0 m-0 space-y-1" style="padding:0!important;">
                            @foreach($sections as $key=> $section)
                                @if(count($section->activeChapters))
                                    <div class="tabs " style="box-shadow: none!important;">
                                        <div class="tab bg-gray-200 p-0 mb-1">
                                            <input class="input-tab" type="checkbox"
                                                   id="section-{{$section->slug}}">
                                            <label
                                                class="tab-label mx-2 mb-2 text-black list-disc text-sm {{$section->pivot->highlight? "bg-blue-300" :"bg-white"}}  pr-5 items-center rounded-lg"
                                                for="section-{{$section->slug}}">
                                                <span
                                                    class="border-r-1 border-gray-400 px-5 py-4">Ενότητα {{++$countSection}}</span>
                                                <span
                                                    class="px-5 py-2 flex-1">{{\Str::limit($section->title,50,"...")}}</span>
                                            </label>
                                            @foreach($section->activeChapters()->where("type","!=","Announcement")->get() as $chapter)
                                                <div
                                                    class="tab-content text-gray-600 flex justify-between zoom-in hover:text-black cursor-pointer spa-click"
                                                    style="padding-left: 15px;padding-right: 15px;"
                                                    data-href="{{$chapter->type=="Link"?$chapter->link:route('index.showMaterial',[$course->slug,$chapter->slug])}}"
                                                    data-type="{{$chapter->type}}"
                                                >
                                                            <span style="flex-basis: 10%;"
                                                                  class="mt-1 font-semibold">{{$loop->index+1}}</span>
                                                    <a class="mt-1 flex-1 px-1" href="">
                                                        <span class="">{{$chapter->title}}</span>
                                                    </a>
                                                    <span class="mt-1">
                                                                <i style="flex-basis: 10%;"
                                                                   class="text-right mr-1 {{$chapter->getType($chapter->type)}}"></i></span>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</aside>
