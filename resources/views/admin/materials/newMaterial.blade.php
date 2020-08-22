@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
    <section class="container-fruid" style="max-width: 1400px">
        <div class="row">
            <div class="col-md-8" id="material-form">
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
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                            <span class="d-none d-md-block">Settings</span>
                        </a>
                    </li>
                </ul>


                <div class="tab-content ">
                    <div class="tab-pane show active" id="content">
                        <form class="needs-validation formPrevent" method="post" action="{{route('material.store')}}"
                              enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
                                <input name="title" type="text" class="form-control" id="titleMaterial"
                                       placeholder="Εισάγετε τίτλο...">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="subtitleMaterial">Υποτίτλο<span class="text-danger"> *</span></label>
                                <input name="subtitle" type="text" class="form-control" id="subtitleMaterial"
                                       placeholder="Εισάγετε υποτίτλο...">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="summaryMaterial">Περίληψη</label>
                                <textarea name="summary" class="form-control" placeholder="Εισάγετε περίληψη..."
                                          id="summaryMaterial"
                                          rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descriptionMaterial">Περιγραφή<span class="text-danger"> *</span></label>
                                <textarea name="description" class="form-control" placeholder="Εισάγετε περιγραφή..."
                                          id="descriptionMaterial" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="contentMaterial">Περιεχόμενο μαθήματος <span
                                        class="text-danger"> *</span></label>
                                <textarea name="content" class="form-control"
                                          placeholder="Εισάγετε περιεχόμενο μαθήματος..."
                                          id="contentMaterial" rows="5"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit form</button>

                            <input name="type" type="hidden" class="form-control" id="typeMaterialHidden">
                            <input name="active" value="0" type="hidden" class="form-control" id="activeMaterialHidden">
                            <input name="video_id" type="hidden" class="form-control" id="urlMaterialHiden">
                            <input name="created_at" type="hidden" class="form-control" id="createAtMaterialHidden">
                            <input name="cover" type="hidden" class="form-control" id="coverMaterialHidden">
                            <input name="instructor"  type="hidden"class="form-control" id="instructorMaterialHidden">
                            <input name="courses"  type="hidden"class="form-control" id="coursesMaterialHidden">
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

            <aside class="col-md-4">
                <div class="border-material">
                    <div class="form-group mb-3">
                        <label for="coursesMaterial">Courses <span class="text-danger"> *</span></label>
                        <select name="courses" id="coursesMaterial" class="form-control" data-toggle="select2">
                            <option value="">Ολα τα courses</option>
                            @foreach($courses as $course)
                                <option value="{{$course->id}}">{{$course->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="urlMaterial">URL video</label>
                        <input type="text" class="form-control" id="urlMaterial"
                               placeholder="Εισάγετε URL video...">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="form-group mb-3">
                    <label for="typeMaterial">Type <span class="text-danger"> *</span></label>
                    <select name="type" id="typeMaterial" class="form-control " data-toggle="select2">
                        <option value="">Ολα τα topics</option>
                        @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    </div>

                    <div class="form-group ">
                        <label for="createAtMaterial">Created</label>
                        <input type="text" class="form-control" id="createAtMaterial" data-provide="datepicker"
                               data-date-format="MM yyyy" data-date-min-view-mode="1">
                    </div>

                    <div class="form-group">
                        <label for="updateAtMaterial">Published</label>
                        <input type="text" class="form-control" id="updateAtMaterial" data-provide="datepicker"
                               data-date-format="MM yyyy" data-date-min-view-mode="1">
                    </div>
                    <hR>
                    <div class="form-group mb-3">
                    <label for="instructorMaterial">Εισηγητής <span class="text-danger"> *</span></label>
                    <select name="instructor" id="instructorMaterial" class="form-control " data-toggle="select2">
                        <option value="">Ολοι οι Εισηγητής</option>
                        @foreach($instructors as $instructor)
                            <option value="{{$instructor->id}}">{{$instructor->fullName}}</option>
                        @endforeach
                    </select>
                    </div>

                    <div class=" form-group ">
                        <h3>Creator</h3>
                        <input type="text" class="form-control" id="creatorMaterialHidden" disabled
                               value="{{auth()->user()->fullName}}"
                               placeholder="Εισάγετε URL video...">
                    </div>
                    <hr>

                    <div class="form-row justify-content-between">
                        <div class="col-10">
                            <label for="createAtMaterial">Κατάσταση</label>
                        </div>
                        <div class="col-2 ">
                            <input type="checkbox" id="activeMaterial" checked data-switch="bool"/>
                            <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <div class="border-material">

                    <div class="form-group">
                        <label>Cover<span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="cover" type="file" class="custom-file-input" id="coverMaterial">
                                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-material">
                    <h3>Tags</h3>
                </div>
            </aside>

        </div>
    </section>


@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/materials/materialNew.js') }}"></script>

    <script>

    </script>

@endsection
