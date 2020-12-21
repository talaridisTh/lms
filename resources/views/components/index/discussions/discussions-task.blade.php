<div class="container task-cnt content-width mt-4">

    <ul class="nav nav-tabs nav-bordered mb-3">
        @role("student")
        <li class="nav-item">
            <a href="#upload-task-content" class="upload-task nav-link active" data-toggle="tab" aria-expanded="false">
                Δημιουργία
            </a>
        </li>
        @endrole
        <li class="nav-item">
            <a href="#show-task-content" class="show-task nav-link @role("instructor")  active  @endrole " data-toggle="tab" aria-expanded="true">
                Παραλήπτες
            </a>
        </li>
    </ul>

    <div class="tab-content">
        @role("student")
        <div class="tab-pane  show active" id="upload-task-content">
            <form id="email-form" action="{{route('discussion.sendTask')}}" method="POST" autocomplete="off"
                  enctype="multipart/form-data">

            @csrf

            <!--element -->

                <div class="form-group d-flex">
                    <div class="cnt-title " style="flex:1.7">
                        <label for="subject-task">Θέμα</label>
                        <input id="subject-task" class="form-control " type="text"
                               placeholder="Εισάγετε θέμα..." name="subject"
                               value=""/>
                    </div>

                    <div class="cnt-title " style="flex:1">
                        <label class="ml-2" for="curator-task">Μάθημα </label>
                        <select id="curator-task" class="form-control select2 ml-2 " data-toggle="select2">
                            @foreach(auth()->user()->courses as $course)
                                <option value="{{$course->curator->id}}">{{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="editor">Περιεχόμενο</label>
                    <textarea class="form-control "
                              id="editor-task" placeholder="Εισάγετε περιεχόμενο..."
                              name="content" rows="5"></textarea>

                </div>

                <div id="file-target" class="my-3"></div>
                <button disabled class="btn btn-primary  js-send-task">Send</button>
            </form>
        </div>
        @endrole
        <div class="tab-pane    @role("instructor")  active show @endrole" id="show-task-content">
            <div class="row">

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="accordion" id="accordionExample">
                            @foreach($courses as $course)
                                <div class="card mb-0">
                                    <div class="card-header" id="head-{{$course->id}}">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title d-block {{$course->slug}}"
                                               data-toggle="collapse" href="#collapse-{{$course->slug}}"
                                               aria-expanded="true" aria-controls="collapse-{{$course->slug}}"
                                               data-course-name="{{$course->title}}">
                                                <div class="headline">
                                                    <h3>
                                                        <i class="icon-material-outline-assignment"></i> {{$course->title}}
                                                    </h3>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>


                                    <div id="collapse-{{$course->slug}}" class="collapse"
                                         aria-labelledby="head-{{$course->id}}" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                            <div class="content">
                                                <ul class="dashboard-box-list">
                                                    @role("instructor")
                                                    @php
                                                        $tasks =\App\Models\Media::where("usability", $course->id )->get()
                                                    @endphp

                                                    @endrole

                                                    @role("student")
                                                    @php
                                                        $tasks =auth()->user()->media()->where("usability", $course->id )->get()
                                                    @endphp
                                                    @endrole
                                                    @foreach($tasks as $task)
                                                        @php
                                                            $mediable =\App\Models\Mediable::where("media_id",$task->id)->first();
                                                            $user = \App\Models\User::findOrFail($mediable->mediable_id)

                                                        @endphp

                                                        <li class="dashboard-box-li">
                                                            <!-- Job Listing -->
                                                            <div class="job-listing width-adjustment">

                                                                <!-- Job Listing Details -->
                                                                <div class="job-listing-details">

                                                                    <!-- Details -->
                                                                    <div class="job-listing-description">
                                                                        <h3 class="job-listing-title"><a
                                                                                href="#">{{$task->name}}</a> <span
                                                                                class="dashboard-status-button red">waiting..</span>
                                                                        </h3>

                                                                        <!-- Job Listing Footer -->
                                                                        <div class="job-listing-footer">
                                                                            <ul>
                                                                                <li>
                                                                                    <i class="icon-material-outline-access-time"></i> {{$user->fullname}}
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Task Details -->
                                                            <ul class="dashboard-task-info">
                                                                <li><strong>{{$task->ext}}</strong><span>Τυπος</span>
                                                                </li>
                                                                <li><strong><i
                                                                            class="mdi font-16 {{\App\Models\Media::$icons[$task->ext]}}"></i></strong><span>View</span>
                                                                </li>
                                                                <li>
                                                                    <strong>{{$task->created_at->format("d/m/Y")}}</strong><span>Στάλθηκε</span>
                                                                </li>
                                                            </ul>

                                                            <!-- Buttons -->
                                                            <div class="buttons-to-right always-visible">
                                                                @hasanyrole("admin|super-admin|instructor")
                                                                <button class="btn btn-primary mr-2">complete</button>

                                                                @endhasanyrole
                                                                <a href="#" class="button gray ripple-effect ico">
                                                                    <i class="uil-comments-alt"></i>
                                                                    <a href="#" class="button gray ripple-effect ico"><i
                                                                            class="dripicons-document-delete"></i></a>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $R('#editor-task', {
        fileUpload: '/discussion/upload-task',
        fileAttachment: '#file-target',
        callbacks: {
            upload: {
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                },
                complete: function (response) {

                    let attachmentFile = []

                    $(".redactor-file-item").each((idx, file) => {
                        let dataAttr = $(file).find("a").data('file')
                        attachmentFile.push({
                            id: dataAttr,
                            path: $(file).find("a").attr('href')
                        });


                    })
                    console.log(attachmentFile)
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
