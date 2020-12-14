<div class="col-md-12 px-2">
    <div class="cnt-disscus rounded" style="background-color: rgba(0, 0, 0, 0.08) !important;">
        <h4 class="p-3">Συζήτηση</h4>

    </div>

    <div class="hidden-post" data-model-id="{{$model->id}}" data-namespace="{{$namespace}}" data-model-slug="{{$model->slug}}"
         data-model-info="{{$model}}"></div>

</div>

<div class="col-md-12">
    @include("components.index.comments.comments")
    <div class="form-group  mt-4 replay-bottom first-thread-replay mb-2 " data-toggle="modal"
         data-target="#new-reply">
        <p class="p-4 text-dark font-20"><i
                class="mdi mdi-hand-pointing-down  font-18 mr-2"></i><span class=" text-reply-comment ">{{!count($course->post)?"Έναρξη συζήτησης":"Νέο μήνυμα"}}</span></p>
    </div>
</div>
