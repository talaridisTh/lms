<div class="card-body ">
    <ul class="conversation-list testa" data-simplebar style="max-height: 650px">
        @forelse($message as $msg)

            {{--    {{dd(Auth::id())}}--}}
            {{--    {{dd($msg->to==Auth::id())}}--}}
            <li class="clearfix {{$msg->from==Auth::id()? "odd":""}}">
                <div class="chat-avatar">
                    @if($msg->from==Auth::id())
                        <img src="{{ App\Models\User::find($msg->from)->cover}}" class="rounded" alt="Shreyu N"/>
                    @else
                        <img src="{{ App\Models\User::find($msg->from)->cover}}" class="rounded" alt="Shreyu N"/>
                    @endif

                    <i>{{$msg->created_at->diffForHumans()}}</i>
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">

                        <i>{{App\Models\User::find($msg->from)->fullName}}</i>
                        <p>
                            {{$msg->message}}
                        </p>
                    </div>
                </div>
                <div class="conversation-actions dropdown">
                    <button class="btn btn-sm btn-link" data-toggle="dropdown"
                            aria-expanded="false"><i class='uil uil-ellipsis-v'></i></button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Copy Message</a>
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>
            </li>
        @empty

            <h4 class="ml-3">Δεν υπαρχουν μηνύματα</h4>
        @endforelse
    </ul>
</div>

<div class="row">
    <div class="col">
        <div class="mt-2 bg-light p-3 rounded">

            <div class="row">
                <div class="col mb-2 mb-sm-0">
                    <input type="text" name="message" class="form-control border-0 js-message"
                           placeholder="Enter your text" required="">
                    <div class="invalid-feedback">
                        Please enter your messsage
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="btn-group">
                        <a href="#" class="btn btn-light"><i class="uil uil-paperclip"></i></a>
                        <button class="btn btn-light emoji-button"><i class='uil uil-smile'></i></button>
                        <button type="submit" class="btn btn-success chat-send btn-block"><i
                                class='uil uil-message'></i></button>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row-->

        </div>
    </div> <!-- end col-->
</div>
<!-- end row -->




