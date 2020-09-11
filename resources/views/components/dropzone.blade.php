<div class="card">
    <div class="card-body">

        <div id="{{$dropzone}}">
            <div class="fallback">
                {{--                                        <input name="file" type="file" multiple/>--}}
            </div>

            <div class="dz-message needsclick text-center">
                <i class="h1 text-muted dripicons-cloud-upload"></i>
                <h3>{{$type}}</h3>
            </div>
        </div>

        <!-- Preview -->
        <div class="dropzone-previews mt-3" id="file-previews"></div>
        {{--                                && isset($user)--}}


        @if(isset($user) )

            <img height="80" width="80" class="{{!count($model->media) ? "d-none":"rounded-circle"}} "
                 src="{{url(!count($model->media) ? "":$model->media->first()->rel_path)}}" alt="">
        @endif
        <div class="d-none" id="uploadPreviewTemplate">
            <div class="card mt-1 mb-0 shadow-none border">
                <div class="p-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light"
                                 alt="">
                        </div>
                        <div class="col pl-0">
                            <a href="javascript:void(0);" class="text-muted font-weight-bold"
                               data-dz-name></a>
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <!-- Button -->
                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                <i class="dripicons-cross"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end card-body -->
</div>
