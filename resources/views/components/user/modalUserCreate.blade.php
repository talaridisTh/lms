<!-- Signup modal-->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Sign Up Modal</button>
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span><img src="" alt="" height="18"></span>
                    </a>
                </div>

                <form class="pl-3 pr-3 d-flex flex-column align-items-center" action="{{route('user.store')}}" method="POST">

                    @csrf
                    <div class="d-flex">
                        <div class="form-group  m-2">
                            <label for="firstname">Όνομα</label>
                            <input class="form-control" name="first_name" type="text" id="firstname" requireduser.store="">
                        </div>

                        <div class="form-group  m-2">
                            <label for="lastname">Επίθετο</label>
                            <input class="form-control" name="last_name" type="text" id="lastname" required="">
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group  m-2">
                            <label for="emailaddress">Email</label>
                            <input class="form-control" name="email" type="email" id="emailaddress" required="">
                        </div>


                        <div class="form-group  m-2">
                            <label for="avatar">Avatar</label>
                            <input class="form-control" name="avatar" type="password" required="" id="avatar">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group  m-2">
                            <label for="password">Κωδικός</label>
                            <input class="form-control" name="password" type="password" required="" id="password">
                        </div>

                        <div class="form-group  m-2">
                            <label for="passwordconfig">Επιβεβαίωση κωδικού</label>
                            <input class="form-control" name="password_confirmation" type="password" required="" id="passwordconfig">
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


