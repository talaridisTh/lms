<div class="container task-cnt content-width mt-4">

    <ul class="nav nav-tabs nav-bordered mb-3">
        @role("student")
        <li class="nav-item">
            <a href="#upload-task-content" class="upload-task nav-link active" data-toggle="tab" aria-expanded="false">
                Αποστολή
            </a>
        </li>
        @endrole
        <li class="nav-item">
            <a href="#show-task-content"
               class="show-task nav-link   @hasanyrole("admin|super-admin|instructor") active @endhasanyrole "
               data-toggle="tab" aria-expanded="true">
                Εργασίες
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
                              name="content" rows="5">
                    </textarea>
                </div>

                <div id="file-target" class="my-3"></div>

                <button class="btn btn-primary js-send-task" type="button" disabled>
                    <span class="spinner-border spinner-border-sm mr-1 d-none" role="status" aria-hidden="true"></span>
                    Αποστολή
                </button>
            </form>
        </div>
        @endrole

        <div class="tab-pane    @hasanyrole("admin|super-admin|instructor")   active show @endhasanyrole"
             id="show-task-content">
            <div class="row">

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="accordion" id="accordionExample">
                            @foreach($courses as $course)
                                @hasanyrole('instructor|admin|super-admin')
                                @php
                                    $tasks =\App\Models\Homework::where("course_id", $course->id )->get();
                                    $completedTask =\App\Models\Attachment::where("attachmentable_id", $course->id )->where("completed_at", "!=" ,null)->get();
                                    $allTask =\App\Models\Attachment::where("attachmentable_id", $course->id )->get();
                                @endphp
                                @endhasanyrole

                                @role("student")
                                @php
                                    $courseIds = auth()->user()->courses->pluck("id");
                                      $tasks =\App\Models\Homework::whereIn("course_id",auth()->user()->courses->pluck("id") )->where("student_id",auth()->id())->get();

                                @endphp
                                @endrole
                                <div class="card mb-0">
                                    <div class="card-header" data-all-task="{{isset($tasks)?count($tasks):""}}"
                                         data-completed-task="{{isset($completedTask)?count($completedTask):""}}"
                                         id="head-{{$course->id}}"
                                         style="border-radius: 3px; ">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title d-block {{$course->slug}}"
                                               data-toggle="collapse" href="#collapse-{{$course->slug}}"
                                               aria-expanded="true" aria-controls="collapse-{{$course->slug}}"
                                               data-course-name="{{$course->title}}">
                                                <div
                                                    class="headline d-flex justify-content-between align-items-center ">
                                                    <h3>
                                                        <i class="icon-material-outline-assignment"
                                                           style="margin-left: -6px;"></i> {{$course->title}}
                                                    </h3>
                                                    @hasanyrole('instructor|admin|super-admin')
                                                    <h5>Eλέγχθηκαν : <span class="js-completed-task"><span
                                                                class="js-num-task">{{isset($completedTask)?count($completedTask):""}}</span>/{{isset($allTask)?count($allTask):""}} </span>
                                                    </h5>
                                                    @endhasanyrole
                                                </div>
                                            </a>
                                        </h5>
                                    </div>


                                    <div id="collapse-{{$course->slug}}" class="collapse"
                                         aria-labelledby="head-{{$course->id}}" data-parent="#accordionExample">

                                        <div class="card-body p-0">

                                            <div class="content">

                                                <ul class="dashboard-box-list">

                                                    @forelse($tasks as $task)

                                                        @foreach($task->attachments as $attachment)
{{--                                                        @if($task->mail->user_id == auth()->id() && $task->course_id == $course->id)--}}
                                                            <li class="dashboard-box-li" data-task-id="{{$attachment->id}}">
                                                                <!-- Job Listing -->
                                                                <div class="job-listing width-adjustment">

                                                                    <!-- Job Listing Details -->
                                                                    <div class="job-listing-details">

                                                                        <!-- Details -->
                                                                        <div class="job-listing-description">
                                                                            <h3 class="job-listing-title m-0 ">
                                                                                <a class="mr-2" href="#">{{$attachment->name}}
                                                                                    .{{$attachment->ext}}</a>
                                                                                <span
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top"
                                                                                    title="{{isset($attachment->completed_at)?"":"Aναμονή ελέγχου καθηγητή"}}!"
                                                                                    class="dashboard-status-button m-0 p-0 {{isset($attachment->completed_at)?"green":"red"}}">
                                                                                {!!isset($attachment->completed_at)?"Ελέγχθηκε <span class='text-muted font-12'>(".Carbon\Carbon::parse($attachment->completed_at)->format("d-m-Y H:i").')</span>':"Αναμονή.."!!}
                                                                            </span>
                                                                            </h3>


                                                                            <!-- Job Listing Footer -->
                                                                            <div class="job-listing-footer">
                                                                                <ul style="padding-left: 1.1rem">
                                                                                    <li class="my-2">
                                                                                        Ονοματεπώνυμο
                                                                                        : {{App\Models\User::find($task->student_id)->fullname}}
                                                                                    </li>
                                                                                </ul>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Task Details -->
                                                                <ul class="dashboard-task-info">
                                                                    <li>
                                                                        <strong>{{$attachment->ext}}</strong>
                                                                        <span>Τυπος</span>
                                                                    </li>
                                                                    <li>
                                                                        <strong>
                                                                            <i class="mdi font-16 {{\App\Models\Media::$icons[$attachment->ext]}}"></i>
                                                                        </strong>
                                                                        <a href="{{$attachment->rel_path}}"
                                                                           target="_blank"
                                                                           data-toggle="tooltip"
                                                                           data-placement="bottom"
                                                                           data-original-title="Προβολή {{$attachment->ext}}"
                                                                           class="text-hover-underline cursor-pointer">View</a>
                                                                    </li>
                                                                    <li>
                                                                        <strong>{{$attachment->created_at->format("d/m/Y (H:i)")}}</strong><span>Στάλθηκε</span>
                                                                    </li>
                                                                </ul>

                                                                <!-- Buttons -->
                                                                <div class="buttons-to-right always-visible">
                                                                    @hasanyrole("admin|super-admin|instructor")
                                                                    <button
                                                                        class="js-complete-task btn btn-sm {{isset($attachment->completed_at)?"btn-outline-danger":"btn-outline-custom-primary"}} mr-2">
                                                                        {{isset($attachment->completed_at)?"Δεν ελέγχθηκε":"Ελέγχθηκε"}}
                                                                    </button>
                                                                    @endhasanyrole
                                                                    <a href="#"
                                                                       data-toggle="tooltip"
                                                                       data-placement="bottom"
                                                                       data-original-title="Eπικοινωνία με καθηγητή"
                                                                       class="button gray ripple-effect ico first-thread">
                                                                        <i class="uil-comments-alt"></i>
                                                                    </a>
                                                                    <a href="#"
                                                                       data-toggle="tooltip"
                                                                       data-placement="bottom"
                                                                       data-original-title="Αφαίρεση εργασιας"
                                                                       class="button gray ripple-effect  js-remove-task ico">
                                                                        <i class="dripicons-document-delete"></i></a>
                                                                </div>
                                                            </li>
                                                        @endforeach
{{--                                                        @endif--}}
                                                    @empty
                                                        <h1>dfd</h1>
                                                    @endforelse

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
<div id="new-post-task" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label for="post-body">Εισάγετε ερώτηση</label>
                    <textarea class="form-control" id="post-body" name="body" form="form-create-thread" rows="5"
                              placeholder="Εισάγετε ερώτηση"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary  js-task-create">Post</button>
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
