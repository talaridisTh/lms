
<div id="new-reply" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-bottom">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <i class="mdi mdi-reply"></i>
                    <span> Reply to <span class="text-info replay-name"></span></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                        <textarea class="form-control form-reply-body" id="reply-body"
                                  name="body"
                                  form="form-create-reply" rows="5"
                                  placeholder="Απάντηση.."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary js-form-reply">Post</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-dialog -->

<form id="form-create-reply" method="post" action="{{route('index.modelComment')}}">
    @csrf
</form>

