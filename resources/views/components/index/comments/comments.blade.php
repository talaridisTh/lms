<div class="cnt-reply-list">
    {{dd($post)}}
    @if(isset($post->comments))


        <div class="flex flex-col reply-list space-y-6">

            @foreach($post->comments as $comment)

                @if ( !$comment->parent_id )
                    @include("components.index.comments.comments-single-post",["comment"=>$comment,"class"=>""]) @endif

                @if ( $comment->replies )
                    @foreach($comment->replies as $rep1)
                        @include("components.index.comments.comments-single-post",["comment"=>$rep1,"class"=>"ml-8"])
                    @endforeach
                @endif

            @endforeach
        </div>
    @endif
</div>
{{--//modal new threads--}}
