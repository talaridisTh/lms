@php
    $isLiked = auth()->user()->commentIsLiked($comment)?"text-red-700":" hover:text-red-700 text-gray-500  ";
    $isLikedCount = $comment->likes->count()?$comment->likes->count():"";
    $isBestAnswerCnt = $comment->best?"best-answer-cnt":"";
    $isBestAnswerBtn = $comment->best?"text-green-700":"is-active-best text-blue-700";
    $isBestAnswerBadge = $comment->best?"":"hidden"
@endphp


<div class="main-post main-reply flex mt-2 bg-gray-200 py-5 px-3 {{$class}} rounded-xl {{$isBestAnswerCnt}} comment-{{$comment->id}}"
     data-comment-id="{{$comment->id}}"
     data-thread-id="{{$comment->id}}"
     data-count="{{$model->id}}">
    <div class="mx-3 group hidden  md:table w-20 h-20 rounded-full overflow-hidden text-center bg-purple table cursor-pointer ">
        <img height="20"
             class=" rounded-full object-cover object-center w-full h-full visible group-hover:hidden"
             src="{{$comment->user->avatar}}"
             alt="{{$comment->user->fullname}}">
    </div>
    <div class="cnt-list-content w-full px-4">
        <div class="flex justify-between items-center ">
            <div class="flex items-center cnt-post-buttons space-x-3">
                <h3 class="font-semibold author-post-name">{{$comment->user->fullName}}</h3>
            </div>
            @if($comment->user_id == auth()->id())
                <div class="dropdown"
                     data-placement="bottom-end">
                    <i data-feather="align-justify"
                       class="dropdown-toggle"></i>
                    <div class="dropdown-box w-60">
                        <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                            <a href=""
                               class="flex items-center block p-2 transition duration-300 ease-in-out bg-white
                                   dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md js-edit-comment"
                               data-class-comment="{{$comment->id}}">
                                <i data-feather="edit-2"
                                   class="w-4 h-4 mr-2"></i>
                                <span class="text-sm">
                                        Επεξεργασία comment
                                </span>
                            </a>
                            <a href=""
                               class="hidden flex items-center block p-2 transition duration-300 ease-in-out bg-white
                                    dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md js-delete-comment"
                               data-class-comment="{{$comment->id}}">
                                <i data-feather="trash"
                                   class="w-4 h-4 mr-2"></i>
                                <span class="text-sm">
                                      Διαγραφή comment
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @endif

        </div>
        <p class="font-semibold pt-1  text-xs ">
            <span class="text-gray-500">{{$comment->created_at->diffForHumans()}}</span></p>

        <div class="cnt-body-comment">
            <pre style="font-family:'roboto'"
                 class="my-6">{!!  $comment->body!!}</pre>
        </div>
        @if(count($comment->media))
            <div class="flex space-x-4 border-t border-gray-300">
                @foreach($comment->media as $image)
                    <div>
                        <a class="flex rounded my-5 zoom-in relative"
                           href="{{ $image->rel_path}}"
                           height="80"
                           data-lightbox="cover-comment"
                           data-title="{{$image->name}}">
                            <img class="rounded"
                                 data-image-id="{{$image->id}}"
                                 src=" {{$image->roundedSmallCoverUrl("rel_path")}}"
                                 alt="comment-photo">
                            @if($comment->user_id == auth()->id())
                                <i class="z-30 zoom-in w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 hover:scale-125 right-0 top-0 -mr-2 -mt-2 js-delete-comments-photo"
                                   data-original-title="Αφαιρέστε την φωτογραφία"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   data-feather="x-circle"></i>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        <hr>
        <div class="post-buttons flex items-center justify-between">
            <div class="flex space-x-4">
                <i data-comment-id="{{$comment->id}}"
                   class="mdi mdi-heart mr-2 btn-reply-like {{$isLiked}}">
                    <span class="">{{$comment->isLikedCount()}}</span>
                </i>
                <a class="js-reply-post-btn zoom-in cursor-pointer js-comment-reply font-normal hover:font-semibold"
                   data-toggle="modal"
                   data-target="#new-reply">Aπάντηση
                </a>
            </div>
            <div class="single-post-show hidden">
                <i class="uil-align-left bg-list-thread  cursor-pointer"></i>
            </div>
        </div>
    </div>
</div>
