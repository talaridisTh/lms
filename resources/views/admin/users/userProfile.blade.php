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
                                        class="ml-2">{{$user->getRoleNames()[0]}}</span></p>
                                <div class="text-right">
                                    <form method="POST" action="{{route('user.destroy',$user->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Sure Want Delete?')" type="submit"
                                                class="btn btn-danger btn-sm mb-2 ">Διαγραφη
                                            {{$user->fullName}}
                                        </button>
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
                                       class="nav-link rounded-0 ">
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

                                <div class="tab-pane" id="aboutme">
                                    @foreach($user->courses()->get() as $users)
                                    <div class="accordion custom-accordion" id="custom-accordion-one">
                                        <div class="card mb-0">
                                            <div class="card-header" id="headingFour">
                                                <h5 class="m-0">
                                                    <a class="custom-accordion-title d-block py-1"
                                                       data-toggle="collapse" href="#collapseFour"
                                                       aria-expanded="true" aria-controls="collapseFour">

                                                        <i class="mdi mdi-cards-variant mr-1"></i>
{{--                                                        {{$user->courses->first() == true ? $user->courses->first()->name : '' }}--}}
                                                        {{$users->name}}

                                                        <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                    </a>
                                                </h5>
                                            </div>

                                            <div id="collapseFour" class="collapse show"
                                                 aria-labelledby="headingFour"
                                                 data-parent="#custom-accordion-one">
                                                <div class="card-body">

                                                    <div class="table-responsive">
                                                        <table class="table table-borderless table-nowrap mb-0">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Clients</th>
                                                                <th>Project Name</th>
                                                                <th>Start Date</th>
                                                                <th>Due Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>


                                                            @if ($user->findMaterials($user->id))

                                                                @foreach($user->findMaterials($user->id) as $materials )
                                                                    @foreach($materials->materials as $key=> $material )
                                                                    <tr>

                                                                        <td>{{$material->id }}</td>
                                                                        <td><img src="{{$material->cover}}"
                                                                                 alt="table-user"
                                                                                 class="mr-2 rounded-circle"
                                                                                 height="24"></td>
                                                                        <td>{{$material->name}}</td>
                                                                        <td>{{$material->small_description}}</td>
                                                                        <td>{{$material->type}}</td>

                                                                        <td><span class="badge badge-info-lighten">Work in Progress</span>
                                                                        </td>

                                                                    </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach

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

    </script>
@endsection
