<div class=" w-full">

    <div class="hidden-post"
         data-model-id="{{$model->id}}"
         data-namespace="{{$namespace}}"
         data-model-slug="{{$model->slug}}"
         data-model-info="{{$model}}"></div>
</div>

<div class="w-full flex   flex-col">
    <div class="flex space-x-5">

        <a href="#"
           class="flex-1"
           data-toggle="modal"
           data-target="#new-reply">
            <div class="form-group border-dotted border-2 cursor-pointer transition duration-500 ease-in-out hover:border-blue-600
                hover:bg-gray-200 border-transparent rounded-xl my-6 replay-bottom first-thread-replay">
                <!-- BEGIN: textarea -->
                <p class="p-8 text-black bg-dropzone text-center">
                    <i class="mdi mdi-hand-pointing-down cnt-container-reply-button  mr-4"></i>
                    <span class=" text-reply-comment ">{{!count($model->post)?"Έναρξη συζήτησης":"Νέο μήνυμα"}}
            </span>
                </p>
            </div><!-- END: texarea -->
        </a>

        <div class="flex-1 border-dotted border-2 cursor-pointer transition duration-500 ease-in-out hover:border-blue-600
                hover:bg-gray-200 border-transparent rounded-xl my-6 bg-dropzone cnt-dropzone">
            <form
                    class=" dropzone-task p-0 min-h-0 border-0 bg-dropzone flex flex-col justify-center items-center"
                    data-model="{{$model}}"
                    method="post"
                    enctype="multipart/form-data"
                    style="height: 5.5rem !important;">
                @csrf
                <div class="fallback">
                    <input name="file"
                           type="file"
                           multiple/>
                </div>
                <div class="dz-message w-full text-center mt-5"
                     data-dz-message>
                    <i class="mdi mr-4 mdi-download-circle"></i><span class='text-black'>Ανέβασμα εργασίας</span>
                </div>

                <div class="w-2/3 h-4 mt-2 bg-gray-400 dark:bg-dark-1 rounded invisible  cnt-task-bar">
                    <div id="the-progress-div"
                         class="transition-all ease-out duration-2000 h-full bg-theme-1 rounded text-center text-xs text-white w-0"></div>
                </div>

                {{--            <div class="dz-preview dz-file-preview">--}}
                {{--                <div class="dz-details">--}}
                {{--                    <div class="dz-filename"><span data-dz-name></span></div>--}}
                {{--                    <div class="dz-size"--}}
                {{--                         data-dz-size></div>--}}
                {{--                    <img data-dz-thumbnail/>--}}
                {{--                </div>--}}
                {{--                <div class="dz-progress"><span class="dz-upload"--}}
                {{--                                               data-dz-uploadprogress></span></div>--}}
                {{--                <div class="dz-success-mark"><span>✔</span></div>--}}
                {{--                <div class="dz-error-mark"><span>✘</span></div>--}}
                {{--                <div class="dz-error-message"><span data-dz-errormessage></span></div>--}}
                {{--            </div>--}}

            </form>
        </div>
    </div>
    @include("components.index.comments.comments-form")


    @include("components.index.comments.comments")

</div>
