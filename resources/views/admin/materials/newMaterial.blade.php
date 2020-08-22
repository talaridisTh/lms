@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
    <section class="container-fruid" style="max-width: 1400px">
        <div class="row">
            <div class="col-md-8" id="material-form" >
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#content" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                            <span class="d-none d-md-block">Content</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link ">
                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                            <span class="d-none d-md-block">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                            <span class="d-none d-md-block">Settings</span>
                        </a>
                    </li>
                </ul>


                <div class="tab-content ">
                    <div class="tab-pane show active" id="content">
                        <form class="needs-validation formPrevent" method="post" action="{{route('material.store')}}" novalidate>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="titleMaterial">Τίτλος</label>
                                <input type="text" class="form-control" id="titleMaterial"
                                       placeholder="Εισάγετε τίτλο..."  >
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="subtitleMaterial">Υποτίτλο</label>
                                <input type="text" class="form-control" id="subtitleMaterial"
                                       placeholder="Εισάγετε υποτίτλο..." >
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="summaryMaterial">Περίληψη</label>
                                <textarea class="form-control"  placeholder="Εισάγετε περίληψη..." id="summaryMaterial" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descriptionMaterial">Περιγραφή</label>
                                <textarea class="form-control"  placeholder="Εισάγετε περιγραφή..." id="descriptionMaterial" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="contentMaterial">Περιεχόμενο μαθήματος</label>
                                <textarea class="form-control"  placeholder="Εισάγετε περιεχόμενο μαθήματος..." id="contentMaterial" rows="5"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit form</button>

                            <input type="text" class="form-control" id="type">
                            <input type="text" class="form-control" id="active">

                            <input type="text" class="form-control" id="videoId">


                        </form>
                    </div>
                    <div class="tab-pane " id="profile">
                        <p>...</p>
                    </div>
                    <div class="tab-pane" id="settings">
                        <p>...</p>
                    </div>
                </div>


            </div>

            <div class="col-md-4">thano</div>

        </div>
    </section>


@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/materials/materialNew.js') }}"></script>

    <script>



    </script>
@endsection
