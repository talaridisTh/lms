<div class=" w-full">

    <div class="hidden-post"
         data-model-id="{{$model->id}}"
         data-namespace="{{$namespace}}"
         data-model-slug="{{$model->slug}}"
         data-model-info="{{$model}}"></div>
</div>
<div class="w-full">
    <a href="#"
       data-toggle="modal"
       data-target="#new-reply">
        <div class="form-group border-dotted border-2 cursor-pointer transition duration-500 ease-in-out hover:border-blue-600
                hover:bg-gray-200 border-transparent rounded-xl my-6 replay-bottom first-thread-replay">
            <!-- BEGIN: textarea -->
            <p class="p-8 text-black ">
                <i class="mdi mdi-hand-pointing-down cnt-container-reply-button  mr-4"></i>
                <span class=" text-reply-comment ">{{!count($model->post)?"Έναρξη συζήτησης":"Νέο μήνυμα"}}
            </span>
            </p>
        </div><!-- END: texarea -->
    </a>

    @include("components.index.comments.comments-form")


    @include("components.index.comments.comments")

</div>
