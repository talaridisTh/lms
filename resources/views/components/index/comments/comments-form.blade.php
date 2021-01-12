{{--<div id="new-reply"--}}
{{--     class="modal fade"--}}
{{--     tabindex="-1"--}}
{{--     role="dialog"--}}
{{--     aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-lg modal-bottom">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h4>--}}
{{--                    <i class="mdi mdi-reply"></i>--}}
{{--                    <span> Reply to <span class="text-info replay-name"></span></span>--}}
{{--                </h4>--}}
{{--                <button type="button"--}}
{{--                        class="close"--}}
{{--                        data-dismiss="modal"--}}
{{--                        aria-hidden="true">--}}
{{--                    ×--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div class="form-group">--}}

{{--                    <textarea class="form-control form-reply-body"--}}
{{--                              id="reply-body"--}}
{{--                              name="body"--}}
{{--                              form="form-create-reply"--}}
{{--                              rows="5"--}}
{{--                              placeholder="Απάντηση.."></textarea>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <style>--}}
{{--                .filepond--item {--}}
{{--                    width: calc(33.33% - .5em);--}}
{{--                }--}}
{{--            </style>--}}
{{--            <div class="modal-footer d-flex justify-content-between">--}}
{{--                <div class=" w-75 form-group">--}}
{{--                    <div class="card">--}}

{{--                        <div id="upload"--}}
{{--                             class="tab-pane">--}}

{{--                            <input id="file-pond"--}}
{{--                                   type="file"--}}
{{--                                   name="filepond"--}}
{{--                                   class="js-filepond-file-dragging mb-0"/>--}}
{{--                            <p class="text-right mb-2">--}}
{{--                                <small>--}}
{{--                                    <strong>--}}
{{--                                        Το πεδίο δέχεται αρχεία: .jpg, .png.--}}
{{--                                    </strong>--}}
{{--                                </small>--}}
{{--                            </p>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <button type="button"--}}
{{--                            class="btn btn-light"--}}
{{--                            data-dismiss="modal">Close--}}
{{--                    </button>--}}
{{--                    <button type="button"--}}
{{--                            class="btn btn-primary js-form-reply">Post--}}
{{--                    </button>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div><!-- /.modal-content -->--}}
{{--    </div><!-- /.modal-dialog -->--}}
{{--</div><!-- /.modal-dialog -->--}}

{{--<form id="form-create-reply"--}}
{{--      method="post"--}}
{{--      action="{{route('index.modelComment')}}">--}}
{{--    @csrf--}}
{{--</form>--}}


<div class="modal flex items-end justify-center"
     id="new-reply"><!-- Begin: modal -->
    <div class="modal__content mb-0 modal__content--xl p-5">

        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-300 dark:border-dark-5">
            <!-- BEGIN: header modal -->
            <h4 class="flex-1">
                <i class="mdi mdi-reply"></i>
                <span> Reply to <span class="text-blue-500 replay-name"></span></span>
            </h4>
            <button class="button border items-center text-gray-700 dark:border-dark-5 dark:text-gray-300 hidden sm:flex">
                <i data-feather="file"
                   class="w-4 h-4 mr-2"></i> Download Docs
            </button><!-- END: decktop -->
            <div class="dropdown sm:hidden">
                <a class="dropdown-toggle w-5 h-5 block"
                   href="javascript:;">
                    <i data-feather="more-horizontal"
                       class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                </a>
                <div class="dropdown-box w-40">
                    <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                        <a href="javascript:;"
                           class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <i data-feather="file"
                               class="w-4 h-4 mr-2"></i> Download Docs </a>
                    </div>
                </div>
            </div><!-- END: mobile -->
        </div><!-- END: header modal -->

        <div class="p-5 w-full"><!-- BEGIN: body modal -->

            <div class="row sm:flex">
                <div class="col sm:w-1/2">
                    <div class="box border-2 border-gray-300 rounded flex flex-col shadow bg-white">
                        <div class="box__title bg-grey-lighter px-3 py-2 border-b">
                            <h3 class="text-sm text-grey-darker font-medium">Eρώτηση</h3></div>
                        <textarea placeholder=""
                                  class="outline-none text-grey-darkest flex-1 p-2 m-1 bg-transparent"
                                  id="reply-body"
                                  name="body"
                                  form="form-create-reply"
                                  rows="5"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div><!-- END: body modal -->

        <div class="px-5 py-3 text-right border-t border-gray-300 dark:border-dark-5"><!-- BEGIN: footer modal -->
            <button type="button"
                    data-dismiss="modal"
                    class="button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel
            </button>
            <button type="button"
                    class="button w-20 bg-theme-1 text-white js-form-reply">Post
            </button>
        </div><!-- END: fotter modal -->

    </div>
</div><!-- END: modal -->

<form id="form-create-reply"
      method="post"
      action="{{route('index.modelComment')}}">
    @csrf
</form>
