@if($body)
    <div class="accordion custom-accordion" id="{{$idAccordion}}">
        <div class="card mb-0">
            <div class="card-header p-2" id="{{$idHeader}}">
                <h5 class="m-0 pl-2">
                    <a class="custom-accordion-title d-block py-1"
                       data-toggle="collapse" href="#{{$href}}"
                       aria-expanded="true" aria-controls="{{$href}}">
                        {{$title}} <i
                            class="mdi mdi-chevron-down accordion-arrow"></i>
                    </a>
                </h5>
            </div>

            <div id="{{$href}}" class="collapse show"
                 aria-labelledby="{{$idHeader}}"
                 data-parent="#{{$idAccordion}}">
                <div class="card-body">
                    {!! $body !!}
                </div>
            </div>
        </div>
    </div>
@endif
