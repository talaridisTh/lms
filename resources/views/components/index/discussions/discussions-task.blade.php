<div class="container task-cnt content-width mt-4">

    <ul class="nav nav-tabs nav-bordered mb-3">

        <li class="nav-item">
            <a href="#upload-task-content"
               class="upload-task nav-link active"
               data-toggle="tab"
               aria-expanded="false">
                Αποστολή
            </a>
        </li>

        <li class="nav-item">
            <a href="#show-task-content"
               class="show-task nav-link   @hasanyrole("
               admin|super-admin|instructor") active @endhasanyrole "
               data-toggle="tab"
               aria-expanded="true">
                Εργασίες
            </a>
        </li>
    </ul>

    <div class="tab-content">
        @role("student")
        <div class="tab-pane   active"
             id="upload-task-content">
            <form id="email-form"
                  action="{{route('discussion.sendTask')}}"
                  method="POST"
                  autocomplete="off"
                  enctype="multipart/form-data">

            @csrf

            <!--element -->
                <div class="form-group d-flex">
                    <div class="cnt-title "
                         style="flex:1.7">
                        <label for="subject-task">Θέμα</label>
                        <input id="subject-task"
                               class="form-control "
                               type="text"
                               placeholder="Εισάγετε θέμα..."
                               name="subject"
                               value=""/>
                    </div>

                    <div class="cnt-title "
                         style="flex:1">
                        <label class="ml-2"
                               for="curator-task">Μάθημα </label>
                        <select id="curator-task"
                                class="form-control select2 ml-2 "
                                data-toggle="select2"
                                style="width: 18.1rem;">
                            @foreach(auth()->user()->courses as $course)
                                <option value="{{$course->curator->id}}">{{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="editor">Περιεχόμενο</label>
                    <textarea class="form-control "
                              id="editor-task"
                              placeholder="Εισάγετε περιεχόμενο..."
                              name="content"
                              rows="5">
                    </textarea>
                </div>

                <div id="file-target"
                     class="my-3"></div>

                <div class="border-2 border-dashed dark:border-dark-5 rounded-md my-3 pt-4 cursor-pointer">

                    <div class="px-4 pb-4  flex items-center cursor-pointer relative">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-image w-4 h-4 mr-2">
                            <rect x="3"
                                  y="3"
                                  width="18"
                                  height="18"
                                  rx="2"
                                  ry="2"></rect>
                            <circle cx="8.5"
                                    cy="8.5"
                                    r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <span class="text-theme-1 dark:text-theme-10 mr-1 cursor-pointer">Πατήστε </span> επισύναψη
                        αρχείου
                        <a href=""
                           class="js-test block w-full h-full top-0 left-0 absolute opacity-0">test
                        </a>
                    </div>
                </div>


                <button class="btn btn-primary js-send-task"
                        type="button"
                        disabled>
                    <span class="spinner-border spinner-border-sm mr-1 d-none"
                          role="status"
                          aria-hidden="true"></span>
                    Αποστολή
                </button>
            </form>
        </div>
        @endrole

        <div class="tab-pane    @hasanyrole("admin|super-admin|instructor") active show @endhasanyrole"
             id="show-task-content">
            <div class="row">

                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="accordion"
                             id="accordionExample">
                            @foreach($courses as $course)
                                <div class="card mb-0">
                                    <div class="card-header"
                                         id="head-{{$course->id}}"
                                         style="border-radius: 3px; ">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title d-block {{$course->slug}}"
                                               data-toggle="collapse"
                                               href="#collapse-{{$course->slug}}"
                                               aria-expanded="true"
                                               aria-controls="collapse-{{$course->slug}}"
                                               data-course-name="{{$course->title}}">
                                                <div
                                                        class="headline d-flex justify-content-between align-items-center ">
                                                    <h3 class="w-full">
                                                        <span class="flex justify-between">
                                                            <span>
                                                                <i class="icon-material-outline-assignment"
                                                                   style="margin-left: -6px;"></i> {{$course->title}}
                                                            </span>
                                                            <span>{{isset($course->homeworks) ?"Στάλθηκε: ".$course->homeworks->first()->created_at->format("d-m-Y H:i"):""}}</span>
                                                        </span>
                                                    </h3>

                                                </div>
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapse-{{$course->slug}}"
                                         class="collapse"
                                         aria-labelledby="head-{{$course->id}}"
                                         data-parent="#accordionExample">

                                        <div class="card-body p-0">

                                            <div class="content">

                                                <ul class="dashboard-box-list">

                                                    @forelse($course->homeworks as $task)

                                                        <li class="dashboard-box-li">

                                                            <div class="job-listing width-adjustment">

                                                                <div class="job-listing-details">

                                                                    <div class="job-listing-description ">
                                                                        <h3 class="job-listing-title m-0 ">
                                                                            <a class="mr-2"
                                                                               href="#">{{$task->subject}}</a>
                                                                            <span data-toggle="tooltip"
                                                                                  data-placement="top"
                                                                                  title="{{isset($task->seen_at)?"":"Aναμονή ελέγχου καθηγητή"}}!"
                                                                                  class="dashboard-status-button m-0 p-0 {{isset($task->seen_at)?"green":"red"}}">
                                                                                {!!isset($task->seen_at)?"Ελέγχθηκε <span class='text-muted font-12'>(".Carbon\Carbon::parse($task->seen_at)->format("d-m-Y H:i").')</span>':"Αναμονή.."!!}
                                                                            </span>
                                                                        </h3>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <ul class="mb-4">
                                                                @foreach($task->attachments as $attachment)
                                                                    <li class="list-disc space-x-5 list-inside">
                                                                        <span class="w-6/12 font-semibold text-md ">{{$attachment->name}}.{{$attachment->ext}}</span>
                                                                        <span class="w-6/12"><i class="{{$attachment->fileIcon()}} text-lg mdi"></i></span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>

                                                    @empty
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
        $(".re-file").addClass("hidden")

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

    $(document).ready(function () {
        $(".js-test").on("click", function (e) {
            e.preventDefault()

            $(".re-file")[0].click();
        })
    });
</script>
