<!-- Signup modal-->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Sign Up Modal</button>
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span><img src="" alt="" height="18"></span>
                    </a>
                </div>

                <form id="buttonUser" class="px-4" action="{{route('user.store')}}"
                      method="POST">
                    @csrf

                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label for="firstName">Όνομα</label>
                            <input class="form-control" name="first_name" type="text" id="firstName">
                            @error("first_name")
                            <div class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="form-group  col-md-6">
                            <label for="lastName">Επίθετο</label>
                            <input class="form-control" name="last_name" type="text" id="lastName">
                            @error("last_name")
                            <div class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label for="email">Email</label>
                            <input class="form-control" name="email" type="email" id="email">
                            @error("email")
                            <div class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">avatar</label>
                            <select class="form-control" name="item_id">
                                @foreach($rolesName as $roleName)
                                    <option value="{{$roleName->id}}">{{$roleName->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group ">
                        <label>Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                                <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                @error("avatar")
                                <div class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="submit">Sign Up Free</button>
                    </div>

                </form>


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>


@if(count($errors))
    <script>
        $('#signup-modal').modal('show');
    </script>
    @enderror











