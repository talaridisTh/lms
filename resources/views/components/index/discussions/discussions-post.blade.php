<style>

    .original-post {
        padding: 6px 22px
    }

    .new-post {
        padding: 6px 22px
    }

    .post-show {
        top: 10px;
        left: 10px;
    }

</style>
@if(get_class($post)=="App\Models\\Announcement")
    <div class="post-scrollbar-cnt stick mt-1 z-10 "
         style="background-color:#fafbfe; height: 114px;">
        <div class="row align-items-center position-relative post-scrollbar">
            <div class="col-1 mt-3"
                 style="max-width: 14.333333%">
                <span class="bg-thread original-post ">Αρχικό</span>
            </div>
            <div class="col-10"
                 style="max-width: 71.33333%;">
                <input type="text"
                       class="js-range-slider"
                       name="my_range"
                       data-min="0"
                       data-max="{{isset($post->comments)? $post->comments->count() :$post->announcement->comments->count()}}"
                       data-grid="true"
                />
            </div>
            <div class="col-1 mt-3"
                 style="max-width: 14.333333%">
                <span class="bg-thread new-post">Νέο</span>
            </div>


            <div class="row justify-content-center mt-2 align-items-center w-100">
                <i class="font-18 uil-grip-horizontal-line bg-list-thread mr-1 js-hidden-body cursor-pointer "
                   style="padding: 0px 0.375rem"></i>
                <i class="font-18 uil-align-left bg-list-thread js-show-body cursor-pointer js-body-active"
                   style="padding: 0px 0.375rem"></i>
            </div>
        </div>
    </div>
@endif

<div class="mt-3 hidden md:flex position-relative height-55px cnt-top-bar-post"
     style="">
    <div class="arrow-line position-absolute"></div>
    <div class="top-bar-post  position-absolute p-2 d-flex justify-content-between align-items-center">
        <div class="font-12 d-none d-lg-block">
            Ο {{"user"}} ξεκίνησε αυτήν τη συνομιλία {{$post->created_at->diffForHumans()}}
            . {{isset($post->comments)? $post->comments->count() :$post->announcement->comments->count()}} άτομα
            απάντησαν.
        </div>
        <div class="d-flex align-items-center w-35 justify-content-between">
            <div>
                {{--                <i class="font-18  uil-eye"></i>--}}
                {{--                <span class="js-thread-watched">{{$post->watched}}</span>--}}
            </div>
            <div>
                <i class="font-18  uil-comment"></i>

                {{isset($post->comments)? $post->comments->count() :$post->announcement->comments->count()}}
            </div>
            <div>
                <button class="btn btn-outline-primary btn-thread-custom font-12 font-weight-bold">
                    {{\App\Models\User::find($post->user_id)->fullName}}
                </button>
            </div>
        </div>
    </div>
</div>

@php
    $closedBadge = $post->closed?"badge-danger":"badge-info";
    $closedHide = $post->closed?"d-none":"";
    $closedbadgeShow = $post->closed?"":"d-none";
    $closedBtn = $post->closed?"d-none":"";
@endphp

<div class="main-post items-center d-flex py-8 space-x-6"
     data-post-id="{{$post->id}}"
     data-namespace="{{get_class($post)}}"
     style="background-color: rgba(0, 0, 0, 0.1)">
    <div class="mx-3 mx-5 w-28 h-28 ">
        @if(get_class($post)=="App\Models\Course")
            <img
                    src="{{$post->thumbnailUrl("cover")}}"
                    class="rounded-xl"
                    alt="">
        @elseif(get_class($post)=="App\Models\Comment")
            <img
                    src="{{\App\Models\User::find($post->user_id)->thumbnailUrl("avatar")}}"
                    class="rounded-xl"
                    alt="">
        @endif
    </div>
    <div class="space-y-5">
        <div>
            <div class="d-flex align-items-center">
                <h3 class=" font-18 ">{{isset($post->curator)?$post->curator->fullName:\App\Models\User::find($post->user_id)->fullName}}</h3>


            </div>
            <p class="font-12">{{$post->created_at->diffForHumans()}}</p>
        </div>
        <div>
            <h2 class="bg-thread font-16 text-dark d-inline-block px-3 mb-3 py-2">{{isset($post->title)?$post->title:$post->announcement->title}}</h2>
            <p class="px-4">{!!$post->body!!}</p>
        </div>
    </div>
</div>

<div class="cnt-reply-list mt-6">
    @isset($post->comments)
        @php  $countPost =0   @endphp
        <div class="d-flex flex-column reply-list space-y-6">
            @foreach($post->comments as $comment)
                @php
                    $isLiked = auth()->user()->commentIsLiked($comment)?"like-class":"";
                    $isLikedCount = $comment->likes->count()?$comment->likes->count():"";


                @endphp

                @if ( !$comment->parent_id )
                    @php  $countPost =$countPost+1   @endphp
                    <div class="main-post main-reply d-flex py-5 space-x-6 "
                         id="reply-{{$countPost}}"
                         data-comment-id="{{$comment->id}}"
                         data-thread-id="{{$comment->id}}"
                         style="background-color: rgba(0, 0, 0, 0.03)">
                        <div class="mx-3 my-2 w-20 h-20 ">
                            <img
                                    class="rounded-xl"
                                    src="{{$comment->user->thumbnailUrl("avatar")}}"
                                    alt="">
                        </div>
                        <div class="cnt-list-content">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center cnt-post-buttons">
                                    <h3 class="mt-2 mb-1 font-18 author-post-name">{{$comment->user->fullName}}</h3>


                                </div>
                                @if($comment->user_id == auth()->id())
                                    <div class="dropdown">
                                        <i class="font-22 mdi mdi-dots-horizontal mr-3 cursor-pointer"
                                           data-toggle="dropdown"></i>
                                        <div class="dropdown-menu dropdown-menu-animated">
                                            <button class="btn dropdown-item js-edit-comment"
                                                    href="#">Επεξεργασία
                                                comment
                                            </button>
                                            <a class="dropdown-item js-delete-comment"
                                               href="#">Διαγραφή comment</a>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <p class="font-12">{{$comment->created_at->diffForHumans()}}</p>
                            <div class="cnt-body-comment">
                            <pre style="font-family:'Open Sans'"
                                 class="font-16 p-3">{!!  $comment->body!!}</pre>
                            </div>
                            <div class="post-buttons d-flex font-18 justify-content-between mb-2">
                                <div class="d-flex">
                                    <i data-comment-id="{{$comment->id}}"
                                       class="mdi mdi-heart mr-2 btn-reply-like {{$isLiked}}">
                                <span
                                        class="font-weight-normal font-16 text-dark">{{$comment->isLikedCount()}}</span>
                                    </i>
                                    <span class="js-reply-post-btn  cursor-pointer js-comment-reply "
                                          data-toggle="modal"
                                          data-target="#new-reply">Aπάντηση
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

                        @endphp

                        <div class="main-post d-flex py-5 ml-10 js-reply-body space-x-6 "
                             data-comment-id="{{$comment->id}}"
                             data-thread-id="{{$rep1->id}}"
                             style="background-color: rgba(0, 0, 0, 0.03)">
                            <div class="mx-3 my-2 h-20 w-20">
                                <img class="rounded-xl"
                                     src="{{$rep1->user->thumbnailUrl("avatar")}}"
                                     alt="">
                            </div>
                            <div class="cnt-list-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center cnt-post-buttons">
                                        <h3 class="mt-2 mb-1 font-18 author-post-name">{{$rep1->user->fullName}}</h3>

                                    </div>
                                    @if($rep1->user_id == auth()->id())
                                        <div class="dropdown">
                                            <i class="font-22 mdi mdi-dots-horizontal mr-3 cursor-pointer"
                                               data-toggle="dropdown"></i>
                                            <div class="dropdown-menu dropdown-menu-animated">
                                                <button class="btn dropdown-item js-edit-comment"
                                                        href="#">Επεξεργασία
                                                    comment
                                                </button>
                                                <a class="dropdown-item js-delete-comment"
                                                   href="#">Διαγραφή comment</a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <p class="font-12">{{$rep1->created_at->diffForHumans()}}</p>
                                <div class="cnt-body-comment">
                                <pre style="font-family:'Open Sans'"
                                     class="font-16 p-3">{!!  $rep1->body!!}</pre>
                                </div>

                                <div class="post-buttons d-flex font-18  mb-2">
                                    <i data-comment-id="{{$rep1->id}}"
                                       class="mdi mdi-heart mr-2 btn-reply-like {{$isLiked}}">
                                    <span
                                            class="js-count-like font-weight-normal font-16 text-dark">{{$rep1->isLikedCount()}}</span>
                                    </i>
                                    <span class="js-reply-post-btn cursor-pointer  js-sub-comment-reply"
                                          data-toggle="modal"
                                          data-target="#new-reply">Aπάντηση</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else

                @endif


            @endforeach
            @endisset
        </div>
</div>


<div class="form-group  mt-7 replay-bottom first-thread-replay mb-4 hidden "
     data-toggle="modal"
     data-target="#new-reply">
    <p class="p-8 text-dark  font-20"><i class="mdi mdi-hand-pointing-down font-18 mr-4"></i> Απαντησε στο Post</p>
</div>
