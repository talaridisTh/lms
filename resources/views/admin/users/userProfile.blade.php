@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="container" style="max-width:1400px">
        <div class="content">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src=" https://robohash.org/set_set3/bgset_bg1/3.14159?size=500x500"
                                 class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">


                            <div class="text-left mt-5">
                                <p class="text-muted mb-2 font-13"><strong>Όνομα :</strong> <span class="ml-2">
                                        {{$user->first_name}}
                                    </span></p>
                                <p class="text-muted mb-2 font-13"><strong>Επώνυμο :</strong> <span class="ml-2">
                                        {{$user->last_name}}
                                    </span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ml-2 ">{{$user->email}}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Active :</strong> <span
                                        class="ml-2">{{$user->active == 1 ? 'Ενεργος' : "Ανενεργος"}}</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Ρολος :</strong> <span
                                        class="ml-2">    {{$userIs }}</span></p>

                                <div class="text-right">
                                    <form method="POST" id="alertSumbit" action="{{route('user.destroy',$user->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit"  value="Διαγραφη {{$user->fullName}}" data-id="{{ $user->id }}"
                                                class=" js-delete btn btn-danger btn-sm mb-2 "/>
                                    </form>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->


                </div> <!-- end col-->

                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#aboutme" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0  active">
                                        Μαθήματα
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"
                                       class="nav-link rounded-0">
                                        Επεξεργασία χρήστη
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active show" id="aboutme">

                                 @include("components.FindUserMaterial")

                                    @include("components.findInstructorMaterial")

                                </div> <!-- end tab-pane -->
                                <div class="tab-pane" id="settings">
                                    <form id="buttonUser" class="px-4" action="{{route('user.update',$user->id)}}"
                                          method="Post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="form-group  col-md-6">
                                                <label for="firstName">Όνομα</label>
                                                <input class="form-control" value="{{$user->first_name}}"
                                                       name="first_name" type="text" id="firstName">
                                                @error("first_name")
                                                <div
                                                    class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                                            </div>

                                            <div class="form-group  col-md-6">
                                                <label for="lastName">Επίθετο</label>
                                                <input class="form-control" value="{{$user->last_name}}"
                                                       name="last_name" type="text" id="lastName">
                                                @error("last_name")
                                                <div
                                                    class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group  col-md-6">
                                                <label for="email">Email</label>
                                                <input class="form-control" value="{{$user->email}}" name="email"
                                                       type="email" id="email">
                                                @error("email")
                                                <div
                                                    class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="email">Ρολος</label>
                                                <select class="form-control" name="role">
                                                    @foreach($rolesName as $key => $roleName)
                                                        <option
                                                            value="{{ $roleName->name }}" {{ $roleName->name == $user->getRoleNames()[0] ? 'selected' : '' }}>{{ $roleName->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label>Avatar</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control" value="{{$user->avatar}}"
                                                       name="avatar" id="avatar">
                                                {{--                                                <img src="{{ 'public/image/users' . $user->avatar}}" width="200px"/>--}}
                                                @error("avatar")
                                                <div
                                                    class="mt-1 d-inline-block alert alert-danger">{{$message}}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <button class="btn btn-primary" type="submit">Ενημέρωση Χρήστη</button>
                                        </div>

                                    </form>
                                </div>

                                <!-- end settings content-->

                            </div> <!-- end tab-content -->

                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- End Content -->


    </div> <!-- content-page -->

@endsection

@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script>
        $('#alertSumbit').submit(async function(e) {
            e.preventDefault()
            let buttonDelete = $('.js-delete');
            const user = buttonDelete[0].dataset.id;
            try {
                const {value} = await Swal.fire({
                    title: 'Είστε σίγουρος;',
                    text: "αρχεία θα διαγραφούν",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ναί, διαγραφή!',
                    cancelButtonText: 'Άκυρο'
                });
                if(value){
                       const res = await axios.post(`/dashboard/users/${user}`)
                       Swal.fire({
                           toast: 'true',
                           position: 'top-end',
                           icon: 'success',
                           title: "Διαγράφηκαν",
                           showConfirmButton: false,
                           timer: 3000,
                           timerProgressBar: true
                       });
                    window.location = `http://127.0.0.1:8000/dashboard/users`;
                }
            }catch (e) {
                Swal.fire({
                    toast: 'true',
                    position: 'top-end',
                    icon: 'error',
                    title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }





        });


    </script>
@endsection
