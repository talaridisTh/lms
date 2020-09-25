

        <div class="card">
            <div class="card-body">
                <ul class="conversation-list" data-simplebar style="max-height: 800px">
                    @foreach($message as $msg)
                    <li class="clearfix {{$msg->from==Auth::id()? "odd":""}}">
                        <div class="chat-avatar">
                            <img src="assets/images/users/avatar-5.jpg" class="rounded" alt="Shreyu N" />
                            <i>{{$msg->created_at->diffForHumans()}}</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <i>{{App\User::find($msg->id)->fullName}}</i>
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
                    @endforeach
                </ul>

                <div class="row">
                    <div class="col">
                        <div class="mt-2 bg-light p-3 rounded">

                                <div class="row">
                                    <div class="col mb-2 mb-sm-0">
                                        <input type="text" name="message" class="form-control border-0 js-message" placeholder="Enter your text" required="">
                                        <div class="invalid-feedback">
                                            Please enter your messsage
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-light"><i class="uil uil-paperclip"></i></a>
                                            <a href="#" class="btn btn-light"> <i class='uil uil-smile'></i> </a>
                                            <button type="submit" class="btn btn-success chat-send btn-block"><i class='uil uil-message'></i></button>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->

                        </div>
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- end card-body -->
        </div> <!-- end card -->


