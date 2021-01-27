<div class="container task-cnt content-width mt-4">

    <ul class="nav nav-tabs nav-bordered mb-3">
        @hasanyrole($policiesRoles)
        <li class="nav-item">
            <a href="#upload-task-content"
               class="upload-task nav-link active"
               data-toggle="tab"
               aria-expanded="false">

                Αποστολή
            </a>
        </li>
        @endhasanyrole
        <li class="nav-item">
            <a href="#show-announcement-content"
               class="show-announcement nav-link  "
               data-toggle="tab"
               aria-expanded="true">
                Ανακοινώσεις
            </a>
        </li>
    </ul>

    <div class="tab-content">
        @hasanyrole($policiesRoles)
        <div class="tab-pane active"
             id="upload-task-content">
            <form id="email-form"
                  action="{{route('discussion.sendTask')}}"
                  method="POST"
                  autocomplete="off"
                  enctype="multipart/form-data">

            @csrf

            <!--element -->
                <div class="form-group flex flex-col  space-y-3">
                    <div class="flex-1 flex space-x-2">
                        <div class="cnt-title w-8/12">
                            <label for="subject-task">Τίτλος</label>
                            <input id="announcement-title"
                                   class="form-control "
                                   type="text"
                                   placeholder="Εισάγετε Τίτλος..."
                                   name="subject"
                                   value="{{ old('subject') }}"/>
                        </div>
                        <div class="cnt-title  w-full flex flex-col"
                             style="flex:1">
                            <label class=""
                                   for="curator-task">Courses </label>
                            <select id="curator-task"
                                    class="form-control w-full select2 ml-2 "
                                    data-toggle="select2">
                                <option
                                        value=""></option>

                                @foreach($courses as $course)
                                    <option value="{{$course->curator->id}}">{{$course->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex  space-x-2">

                        <div class="cnt-title flex flex-col"
                             style="flex:1">
                            <label class=""
                                   for="user-task">Χρήστες</label>
                            <select id="user-task"
                                    class="form-control select2 ml-2 w-full announcement-user"
                                    data-toggle="select2"
                                    multiple="multiple">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="editor-task">Περιεχόμενο</label>
                    <textarea class="form-control "
                              id="editor-task"
                              placeholder="Εισάγετε περιεχόμενο..."
                              name="content"
                              rows="5">
                    </textarea>
                </div>

                <div id="file-target"
                     class="my-3"></div>
                <ul class="mb-4">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">*{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn btn-primary js-send-announcement"
                        type="button">
                    <span class="spinner-border spinner-border-sm mr-1 hidden"
                          role="status"
                          aria-hidden="true"></span>
                    Αποστολή
                </button>
            </form>
        </div>
        @endhasanyrole
        <div class="tab-pane  @role("student") active @endrole"
             id="show-announcement-content">
            <ul class="threads-main-list p-0 mt-6">

                @forelse($posts  as $post)
                    <li class="d-flex list-unstyled bg-list-thread px-6 py-4 mb-5 single-thread"
                        data-post-id="{{$post->id}}"
                        data-namespace="{{get_class($post)}}">
                        <div class="mr-2 d-flex align-items-center ">
                            {{--                    <img src="{{$post->thumbnailUrl("cover")}}"--}}
                            {{--                         class="avatar-sm rounded"--}}
                            {{--                         alt="">--}}
                        </div>

                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-md-7 space-y-2">
                                    <h4 class="text-hover-underline cursor-pointer js-thread-title">{{Str::limit($post->title,35,'...')}}</h4>
                                    <p class="text-dark d-none js-post-body">{{Str::limit($post->description,120,'...')}}</p>
                                    <p>
                                        {{--                                <span class="text-info mr-2">{{\App\Models\User::find($post->user_id)}}</span>--}}
                                        <span class="text-secondary"> {{$post->created_at->diffForHumans()}}</span>
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex mt-1 justify-content-around">
                                        <div>
                                            {{--                                            <i class="font-18  uil-eye"></i>--}}
                                            {{--                                            <span class="js-thread-watched">{{$post->watched}}</span>--}}
                                        </div>
                                        <div>
                                            <i class="font-18  uil-comment"></i>
                                            {{$post->comments->count()}}
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-primary btn-thread-custom font-12 font-weight-bold">
                                                {{\App\Models\User::find($post->course->user_id)->fullName}}

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>


                @empty
                    <h3>Δεν υπάρχουν σχετικές ανακοινώσεις</h3>
                @endforelse
                {{--        {{ $posts->render() }}--}}

            </ul>


        </div>

    </div>
</div>

<div id="new-post-task"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"
         role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label for="post-body">Εισάγετε ερώτηση</label>
                    <textarea class="form-control"
                              id="post-body"
                              name="body"
                              form="form-create-thread"
                              rows="5"
                              placeholder="Εισάγετε ερώτηση"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">Close
                </button>
                <button type="button"
                        class="btn btn-primary  js-question-btn">Post
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-dialog -->
<script>


    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $R('#editor-task', {
        fileUpload: '/discussion/upload-task',
        fileAttachment: '#file-target',
        callbacks: {
            upload: {
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    // $(".js-send-task").hide();
                },
                complete: function (response) {
                    // $(".js-send-task").show();
                    let attachmentFile = []
                    $(".alert-body").remove();
                    $(".redactor-file-item").each((idx, file) => {
                        let dataAttr = $(file).find("a").data('file')
                        attachmentFile.push({
                            id: dataAttr,
                            path: $(file).find("a").attr('href')
                        });

                    })
                    if ($("#attachment-task").length) {
                        $("#attachment-task").remove()
                    }
                    $("#email-form").append(
                        $('<input >', {
                            type: 'hidden',
                            value: JSON.stringify(attachmentFile),
                            id: "attachment-task"
                        })
                    );
                }

            },

        },

    });

</script>
