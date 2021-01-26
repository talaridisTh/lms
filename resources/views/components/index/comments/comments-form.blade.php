<style>
    .filepond--item {
        width: calc(20%);
    }

    .filepond--file-status {
        display: none;
    }

    .filepond--panel-root {
        display: none;
    }

    .filepond--panel-root {
        background-color: transparent;
        border: 2px solid #2c3340;
    }
</style>
<div class="modal flex items-end justify-center"
     id="new-reply"><!-- Begin: modal -->
    <div class="modal__content mb-0 modal__content--xl p-5">

        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-300 dark:border-dark-5 space-x-10">
            <!-- BEGIN: header modal -->
            <h4 class="flex-1">
                <i class="mdi mdi-reply"></i>
                <span> Reply to <span class="text-blue-500 replay-name"></span></span>
            </h4>
            <button id="file-pond"
                    class="button flex-1 items-center text-gray-700 dark:border-dark-5 dark:text-gray-300 flex">
                <i data-feather="file"
                   class="w-4 h-4 mr-2"></i> Download Docs
            </button><!-- END: decktop -->

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

        <div class="px-5 py-3 flex justify-end text-right border-t border-gray-300 dark:border-dark-5">
            <!-- BEGIN: footer modal -->
            <button type="button"
                    data-dismiss="modal"
                    class="button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel
            </button>
            <button type="button"
                    class="button w-20 flex flex-center  bg-theme-1 text-white js-form-reply">
                <svg class="animate-spin hidden -ml-1 mr-3 h-5 w-5 text-white"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"></circle>
                    <path class="opacity-75"
                          fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Post</span>
            </button>
        </div><!-- END: fotter modal -->

    </div>
</div><!-- END: modal -->

<form id="form-create-reply"
      method="post"
      action="{{route('index.modelComment')}}">
    @csrf
</form>
