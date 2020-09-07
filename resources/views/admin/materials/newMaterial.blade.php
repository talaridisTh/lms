@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <section class="container-fruid position-relative">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="/dashboard/materials"
                                                           class="custom-link-primary">Υλικό</a></li>
                            <li class="breadcrumb-item active">test</li>
                        </ol>
                    </div>
                    <h4 class="page-title">test</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12" id="material-form">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#content" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                            <span class="d-none d-md-block">Content</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#courses-tabs" data-toggle="tab" aria-expanded="true"
                           class="nav-link {{ !isset($material) ? 'tab-link text-muted' : '' }}">
                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                            <span class="d-none d-md-block">Courses</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                            <span class="d-none d-md-block">Settings</span>
                        </a>
                    </li>
                </ul>

                <div class="col-md-4 offset-md-8 sticky pb-3 px-2  text-center mr-5">
                    <button id="button-createMaterial-form" type="submit" form="material-create"
                            class="btn btn-primary">{{isset($material)? "Ενημέρωση":"Δημιουργια"}}
                    </button>
{{--                    <button id="preview-btn" class="under-development btn btn-warning"><i--}}
{{--                            class="mdi mdi-eye"></i>--}}
{{--                    </button>--}}
                </div>
                <div class="tab-content ">
                    <div class="tab-pane show active" id="content">
                        <form id="material-create" method="post" action="{{route('material.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if(isset($material))
                                @method('PATCH')
                            @endif
                        </form>

                        <div class="row">
                            <div class="content-form col-xl-9 col-lg-7 col-md-12">
                                <div class="form-group mb-3">
                                    <label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
                                    <input form="material-create" name="title" type="text" class="form-control"
                                           id="titleMaterial"
                                           placeholder="Εισάγετε τίτλο..."
                                           value="{{ old('title') != "" ? old('title') : ( isset($material) ? $material['title'] : "" ) }}"
                                    >
                                    @error("title")
                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="subtitleMaterial">Υποτίτλος<span class="text-danger"> *</span></label>
                                    <input form="material-create" name="subtitle" type="text" class="form-control"
                                           id="subtitleMaterial"
                                           placeholder="Εισάγετε υποτίτλο..."
                                           value="{{ old('subtitle') != "" ? old('subtitle') : ( isset($material) ? $material['subtitle'] : "" ) }}"
                                    >
                                    @error("subtitle")
                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                    @enderror
                                </div>


                                <div class="form-group mb-3">
                                    <label for="summaryMaterial">Περίληψη</label>
                                    <textarea form="material-create" name="summary" class="form-control"
                                              placeholder="Εισάγετε περίληψη..."
                                              id="summaryMaterial"
                                              rows="5">{{isset($material) ? $material['summary'] : ""}}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="descriptionMaterial">Περιγραφή<span
                                            class="text-danger"> *</span></label>
                                    <textarea form="material-create" name="description" class="form-control"
                                              placeholder="Εισάγετε περιγραφή..."
                                              id="descriptionMaterial"
                                              rows="5">{{isset($material) ? $material['description'] : ""}}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="contentMaterial">Περιεχόμενο μαθήματος <span
                                            class="text-danger"> *</span></label>
                                    <textarea form="material-create" name="content" class="form-control"
                                              placeholder="Εισάγετε περιεχόμενο μαθήματος..."
                                              id="contentMaterial"
                                              rows="5">{{isset($material) ? $material['content'] : ""}}</textarea>
                                </div>
                            </div>
                            <aside class="col-xl-3 col-lg-5 col-md-12">
                                <div class="border-material">

                                    <div class="form-group mb-3">
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span><strong>Κατάσταση</strong></span>
                                            <input   name="status" type="checkbox"
                                                   id="activeMaterial" data-switch="bool"/>
                                            <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="urlMaterial">URL video</label>
                                        <input form="material-create" name="video_link" type="text" class="form-control"
                                               id="urlMaterial"
                                               placeholder="Εισάγετε URL video..."
                                               value="{{ old('subtitle') != "" ? old('subtitle') : ( isset($material) ? $material['video_link'] : "" ) }}">
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="typeMaterial">Τύπος <span class="text-danger"> *</span></label>
                                        <select  data-placeholder="Επιλέξτε Topics..." id="typeMaterial"
                                                class="select2-multiple form-control"
                                                name="type" data-toggle="select2"
                                                 form="material-create">
                                            <option value=""></option>
                                            @foreach ($types as $type)
                                                <option value="{{$type->type}}"
                                                @if(isset($material))
                                                    {{$material->type == $type->type? "selected":""}}
                                                    @endif
                                                >{{$type->type}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="topicMaterial">Topic <span class="text-danger"> *</span></label>
                                        <select name="topic[]" multiple id="topicMaterial"
                                                class="form-control select2-multiple" data-toggle="select2"
                                                data-placeholder="Επιλέξτε Topics..."
                                                form="material-create">
                                            @foreach ($topics as $topic)
                                                <option value="{{$topic->id}}"
                                                @if(isset($material))
                                                    @foreach($material->topics as $top)
                                                        {{$top->id == $topic->id? "selected":""}}
                                                        @endforeach
                                                    @endif
                                                    >{{$topic->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <hR>


                                    <div class="form-group mb-3">
                                        <label for="instructorMaterial">Εισηγητής <span
                                                class="text-danger"> *</span></label>
                                        <select form="material-create" name="instructor[]" multiple
                                                id="instructorMaterial"
                                                class="form-control " data-toggle="select2"
                                                data-placeholder="Επιλέξτε instructor...">
                                            @foreach ($instructors as $instructor)
                                                <option value="{{$instructor->id}}"
                                                @if(isset($material))
                                                    @foreach($material->users as $user)
                                                        {{$user->id == $instructor->id? "selected":""}}
                                                        @endforeach
                                                    @endif
                                                >{{$instructor->fullName}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class=" form-group ">
                                        <p class="font-weight-bold">Creator</p>
                                        <input type="text" class="form-control" id="creatorMaterialHidden" disabled
                                               value="{{auth()->user()->fullName}}"
                                        >
                                    </div>
                                    <hr>
                                </div>
                                <div class="border-material">
                                    <option></option>
                                    <div class="form-group">
                                        <label>Cover<span class="text-danger"> *</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" id="cover-material"
                                                       for="coverMaterialHidden">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-material">
                                    <h3>Tags</h3>
                                </div>
                            </aside>
                        </div>
                    </div>
                    <div class="tab-pane " id="courses-tabs">
                        @if(isset($material))
                        @include("components.admin.materials.tabsCourses")
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </section>


@endsection

@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="/assets/js/vendor/dataTables.buttons.min.js"></script>

    <x-routes></x-routes>
{{--    <script src="{{ asset('js/dashboard/materials/material.js') }}"></script>--}}
    <script src="{{ asset('js/dashboard/materials/materialNew.js') }}"></script>


@endsection
