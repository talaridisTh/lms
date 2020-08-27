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
                        <form class="needs-validation formPrevent" method="post" action="{{route('material.update',$material->slug)}}"
                              enctype="multipart/form-data" >
                            @method('PATCH')
                            @csrf
                            <div class="form-group mb-3">
                                <label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
                                <input name="title" type="text" class="form-control" id="titleMaterial"
                                       value="{{old('material', $material->title)}}"
                                       placeholder="Εισάγετε τίτλο...">
                                @error("title")
                                <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group mb-3">
                                <label for="subtitleMaterial">Υποτίτλο<span class="text-danger"> *</span></label>
                                <input name="subtitle" type="text" class="form-control" id="subtitleMaterial"
                                       value="{{old('material', $material->subtitle)}}"
                                       placeholder="Εισάγετε υποτίτλο...">
                                @error("subtitle")
                                <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group mb-3">
                                <label for="summaryMaterial">Περίληψη</label>
                                <textarea  name="summary" class="form-control" placeholder="Εισάγετε περίληψη..."
                                          id="summaryMaterial"
                                          rows="5">{{$material->summary}}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descriptionMaterial">Περιγραφή<span class="text-danger"> *</span></label>
                                <textarea name="description" class="form-control" placeholder="Εισάγετε περιγραφή..."
                                          id="descriptionMaterial" rows="5">{{$material->description}}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="contentMaterial">Περιεχόμενο μαθήματος <span
                                        class="text-danger"> *</span></label>
                                <textarea name="content" class="form-control"
                                          value="{{old('material', $material->content)}}"
                                          id="contentMaterial" rows="5">{{$material->content}}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Ενημερωση</button>
                            <a target="_blank" href="{{route('index.material.show',$material->slug)}}" class="btn btn-outline-secondary" type="submit">Προεπισκόπηση </a>

                            <input name="topic" type="hidden" class="form-control" id="topicMaterialHidden">
                            <input name="type" type="hidden" class="form-control" id="typeMaterialHidden">
                            <input name="active" value="0" type="hidden" class="form-control" id="activeMaterialHidden">
                            <input name="video_link" type="hidden" class="form-control" id="urlMaterialHiden">
                            <input name="created_at" type="hidden" class="form-control" id="createAtMaterialHidden">
                            <input name="cover" hidden type="file" class="form-control" id="coverMaterialHidden">
                            <input name="instructor" type="hidden" class="form-control" id="instructorMaterialHidden">
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
                        <label for="urlMaterial">URL video</label>
                        <input type="text" class="form-control" id="urlMaterial"
                               value="{{old('material', $material->video_id)}}"
                               placeholder="Εισάγετε URL video...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="topicMaterial">Topic <span class="text-danger"> *</span></label>
                        <select name="topic[]" multiple="multiple" name="topic" id="topicMaterial" class="form-control" >
                            @foreach ($topics as $topic)>
                                <option
                                    value="{{$topic->id}}" @foreach($material->topics as $top ){{$top->id == $topic->id? "selected":""}} @endforeach>{{$topic->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group mb-3">
                        <label for="typeMaterial">Τύπος <span class="text-danger"> *</span></label>
                        <select  id="typeMaterial" class="form-control " data-toggle="select2">


                            @foreach($types as $type)

                                <option  value="{{$type->type}}" {{$type->type==$material->type? "selected":""}}>{{$type->type}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="createAtMaterial">Created</label>
                        <input type="text" class="form-control date" data-format="yyyy-MM-dd hh:mm:ss"  placeholder="ss" id="createAtMaterial" data-toggle="date-picker" data-single-date-picker="true">

                    </div>

                    <div class="form-group">
                        <label for="updateAtMaterial">Published</label>
                        <input type="text" class="form-control date" id="updateAtMaterial" data-toggle="date-picker" data-single-date-picker="true">

                    </div>
                    <hR>
{{--                    <div class="form-group mb-3">--}}
{{--                        <label for="instructorMaterial">Εισηγητής <span class="text-danger"> *</span></label>--}}
{{--                        <select name="instructor" id="instructorMaterial" class="form-control " data-toggle="select2">--}}
{{--                            @foreach($instructors as $k=> $instructor)--}}
{{--                                <option  value="{{$instructor->id}}" {{$instructor->fullName==$material->users->first()->fullName? "selected":""}}>{{$instructor->fullName}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}

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
                            <input type="checkbox" id="activeMaterial" {{$material->active == 0 ? "" : "checked"}} data-switch="bool"/>
                            <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <div class="border-material">

                    <div class="form-group">
                        <label>Cover<span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="coverMaterialHidden">Εισάγετε αρχειο</label>
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
