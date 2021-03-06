<style>
    .modal-open {
        overflow: auto;
    }

    .modal-backdrop {
        opacity: 0.3 !important;
    }

    .modal-content {
        height: 400px;
    }
</style>
<ul class="ul-thread stick">
    <li class="py-3 px-8 mx-2 mt-2 mb-8 list-unstyled first-thread mb-2 hidden"
        data-toggle="modal"
        data-target="#new-threads">
        NEO POST
    </li>

    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden active-thread"
        id="filter-all-threads">
        <i class="font-18 font-18 mr-1 uil-notebooks"></i>
        Συζητήσεις
    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden"
        id="filter-my-question">
        <i class="font-18 mr-1 uil-question-circle"></i>
        Οι Ερωτήσεις μου
    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden"
        id="filter-participation">
        <i class="font-18 mr-1 uil-volume"></i>
        Η συμμετοχή μου
    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread flex hidden"
        id="filter-best-answer">
        <i class="font-18 mr-2 uil-check-circle block"></i>
        <span>Δεν υπάρχουν ακόμη απαντήσεις</span>

    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread flex hidden"
        id="filter-popular-week">
        <i class="font-18 mr-2 uil-star block"></i>
        <span>Δημοφιλή αυτήν την εβδομάδα</span>

    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden"
        id="filter-popular-allTime">
        <i class="font-18 mr-1 uil-star"></i>
        Δημοφιλές όλο το χρόνο
    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden "
        id="filter-isClosed">
        <i class=" mdi mdi-power mr-1 font-18"></i>
        Κλειστό
    </li>
    <li class="py-2 px-6 m-2 list-unstyled bg-thread flex hidden"
        id="filter-no-replies">
        <i class="font-18 mr-2 uil-link-h block"></i>
        <span>Δημοφιλή αυτήν την εβδομάδα</span>
    </li>

    <li class="py-2 px-6 m-2 list-unstyled bg-thread hidden"
        data-role-user="{{auth()->user()->getRoleNames()[0]}}"
        id="filter-announcement">
        <i class="font-18 mr-1 uil-star"></i>
        Επικοινωνία
    </li>
    @role("student")
    <li class="py-2 px-6 mt-9 mx-4 list-unstyled bg-thread hidden active-thread"
        data-role-user="{{auth()->user()->getRoleNames()[0]}}"
        id="filter-my-task">
        <i class="font-18 mr-1 uil-link-h"></i>
        Εργασίες
    </li>
    @endrole
</ul>


{{--//modal new threads--}}
<div id="new-threads"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-bottom">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-row w-100">
                    <div class="form-group col-md-8">
                        <label for="post-title"
                               class="col-form-label">Εισάγετε τίτλο</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               id="post-title"
                               form="form-create-thread"
                               placeholder="Εισάγετε τίτλο">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="post-course"
                               class="col-form-label">Eπέλεξε μαθήματα </label>
                        <select id="post-course"
                                class="form-control"
                                name="course_id"
                                form="form-create-thread">
                            <option>Choose</option>
                            @foreach($courses as $key=> $course)
                                <option value="{{$course}}">{{$course}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
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
                        class="btn btn-primary  js-form-create">Post
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-dialog -->


{{--//modal new threads--}}
<div id="new-reply"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-bottom">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <i class="mdi mdi-reply"></i>
                    <span> Reply to <span class="text-blue-500 replay-name"></span></span>
                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                        <textarea class="form-control form-reply-body"
                                  id="reply-body"
                                  name="body"
                                  form="form-create-reply"
                                  rows="5"
                                  placeholder="Απάντηση.."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">Close
                </button>
                <button type="button"
                        class="btn btn-primary js-form-reply"
                        data-namespace="">Post
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-dialog -->


{{--<button  type="button" class="btn btn-success" data-toggle="modal" data-target="#bs-example-modal-sm">Small Modal</button>--}}
<div class="modal fade"
     id="centermodal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true"
     style="    background: rgba(0,0,0,.7);">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content"
             style="height:0 ;background-color: transparent">
            <div class="modal-body ">
                <div class="position-relative">
                    <i class="uil-search position-absolute global-search"></i>
                    <input type="text"
                           class="form-control bg-list-thread js-search-post css-search-snippet pl-10"
                           placeholder="Αναζήτηση">
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<form id="form-create-thread"
      method="post"
      action="{{route('discussion.thread')}}">
    @csrf

</form>

<form id="form-create-reply"
      method="post"
      action="{{route('discussion.reply')}}">
    @csrf
</form>


