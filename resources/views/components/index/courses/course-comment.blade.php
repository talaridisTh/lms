<div class="cnt-reply-list">
@isset($post->comments)
    <div class="d-flex flex-column reply-list">
        @foreach($post->comments as $comment)
            @php
                $isLiked = auth()->user()->commentIsLiked($comment)?"like-class":"";
                $isLikedCount = $comment->likes->count()?$comment->likes->count():"";
                $isBestAnswerCnt = $comment->best?"best-answer-cnt":"";
                $isBestAnswerBtn = $comment->best?"text-success":"is-active-best text-info";
                $isBestAnswerBadge = $comment->best?"":"d-none"

            @endphp

            @if ( !$comment->parent_id )
                <div class="main-post main-reply d-flex mt-1 {{$isBestAnswerCnt}}"
                     data-comment-id="{{$comment->id}}"
                     data-thread-id="{{$comment->id}}"
                     style="background-color: rgba(0, 0, 0, 0.03)">
                    <div class="mx-3 my-2">
                        <img height="50" src="{{$comment->user->avatar}}" alt="">
                    </div>
                    <div class="cnt-list-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center cnt-post-buttons">
                                <h3 class="mt-2 mb-1 font-18 author-post-name">{{$comment->user->fullName}}</h3>
                                @if(auth()->id()==$post->user_id)
                                    <i class="{{$isBestAnswerBtn }} js-best-answer  cursor-pointer font-20 mt-2 ml-3  mdi mdi-alpha-b-circle"></i>
                                @endif
                                <a href="#"
                                   class="{{$isBestAnswerBadge}} ml-3 mt-2 badge badge-success badge-best  font-14">Best
                                    Answer</a>

                            </div>
                            @if($comment->user_id == auth()->id())
                                <div class="dropdown">
                                    <i class="font-22 mdi mdi-dots-horizontal mr-3 cursor-pointer"
                                       data-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-animated">
                                        <a class="dropdown-item js-delete-comment"
                                           href="#">Διαγραφή comment</a>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <p class="font-12">{{$comment->created_at->diffForHumans()}}</p>
                        <p class="p-3">{!!  $comment->body!!}</p>
                        <hr>
                        <div
                            class="post-buttons d-flex font-18 justify-content-between mb-2">
                            <div class="d-flex">
                                <i data-comment-id="{{$comment->id}}"
                                   class="mdi mdi-heart mr-2 btn-reply-like {{$isLiked}}">
                                                                    <span
                                                                        class="font-weight-normal font-16 text-dark">{{$comment->isLikedCount()}}</span>
                                </i>
                                <span
                                    class="js-reply-post-btn  cursor-pointer js-comment-reply "
                                    data-toggle="modal" data-target="#new-reply">Aπάντηση
                                                                 </span>
                            </div>
                            <div class="single-post-show d-none">
                                <i class="font-18  uil-align-left bg-list-thread mr-2 cursor-pointer"
                                   style="padding: 0px 0.375rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ( $comment->replies )
                @foreach($comment->replies as $rep1)
                    @php
                        $isLiked = auth()->user()->commentIsLiked($rep1)?"like-class":"";
                        $isLikedCount = $rep1->likes->count()?$rep1->likes->count():"";
                        $isBestAnswerCnt = $rep1->best?"best-answer-cnt":"";
                        $isBestAnswerBtn = $rep1->best?"text-success":"is-active-best text-info";
                        $isBestAnswerBadge = $rep1->best?"":"d-none"
                    @endphp

                    <div
                        class="main-post d-flex mt-1 ml-5 js-reply-body {{$isBestAnswerCnt}}"
                        data-comment-id="{{$comment->id}}"
                        data-thread-id="{{$rep1->id}}"
                        style="background-color: rgba(0, 0, 0, 0.03)">
                        <div class="mx-3 my-2">
                            <img height="50" src="{{$rep1->user->avatar}}" alt="">
                        </div>
                        <div class="cnt-list-content">
                            <div
                                class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center cnt-post-buttons">
                                    <h3 class="mt-2 mb-1 font-18 author-post-name">{{$rep1->user->fullName}}</h3>
                                    @if(auth()->id()==$post->user_id)
                                        <i data-original-title="Tooltip on top"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="Best Answer"
                                           class="{{$isBestAnswerBtn}} js-best-answer is-active-best cursor-pointer font-20 mt-2 ml-3 text-info mdi mdi-alpha-b-circle"></i>
                                    @endif
                                    <a href="#"
                                       class="{{$isBestAnswerBadge}} ml-3 mt-2 badge badge-success badge-best  font-14">Best
                                        Answer</a>

                                </div>
                                @if($rep1->user_id == auth()->id())
                                    <div class="dropdown">
                                        <i class="font-22 mdi mdi-dots-horizontal mr-3 cursor-pointer"
                                           data-toggle="dropdown"></i>
                                        <div
                                            class="dropdown-menu dropdown-menu-animated">
                                            <a class="dropdown-item js-delete-comment"
                                               href="#">Διαγραφή comment</a>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <p class="font-12">{{$rep1->created_at->diffForHumans()}}</p>
                            <p class="p-3">{!!  $rep1->body!!}</p>
                            <hr>
                            <div class="post-buttons d-flex font-18  mb-2">
                                <i data-comment-id="{{$rep1->id}}"
                                   class="mdi mdi-heart mr-2 btn-reply-like {{$isLiked}}">
                                        <span
                                            class="js-count-like font-weight-normal font-16 text-dark">{{$rep1->isLikedCount()}}</span>
                                </i>
                                <span
                                    class="js-reply-post-btn cursor-pointer  js-sub-comment-reply "
                                    data-toggle="modal" data-target="#new-reply">Aπάντηση</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else

            @endif
        @endforeach
    </div>
@endisset
</div>
{{--//modal new threads--}}
