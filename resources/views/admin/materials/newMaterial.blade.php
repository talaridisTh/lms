@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    <div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title" id="gallery-modalLabel">Media Library</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#media-library" id="media-library-tab-btn"
                               data-toggle="tab" aria-expanded="false"
                               class="nav-link active"
                            >
                                Media Library
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#upload" id="upload-tab-btn"
                               data-toggle="tab" aria-expanded="true"
                               class="nav-link"
                            >
                                Upload
                            </a>
                        </li>
                    </ul> <!-- end nav-->

                    <div class="tab-content">

                        <div id="media-library" class="tab-pane show active">
                            <!-- Search -->
                            <div class="row">
                                <div class="mx-auto col-4">
                                    <div class="form-group">
                                        <input id="image-search" class="form-control text-center" type="text" placeholder="Αναζήτηση..." />
                                    </div>
                                </div>
                            </div>

                            <div id="gallery-content" data-model="App\Material" data-action="cover" data-id={{ $material->id }}>
                                @include('components.admin.imageGallery', ['media' => $media])
                            </div>



                        </div>

                        <div id="upload" class="tab-pane">

                            <input id="file-pond" type="file[]"/>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
                </div>
            </div>
        </div>
    </div>


    <x-alertMsg :msg="'create'"></x-alertMsg>
    <x-alertMsg :msg="'update'"></x-alertMsg>
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


                <div class="tab-content ">
                    <div class="tab-pane show active" id="content">
                        <div class="col-md-3 offset-md-9 sticky  py-3 px-2 pl-3    mr-5">
                            <button id="button-createMaterial-form {{isset($material)? "update-btn":""}} " type="submit"
                                    form="material-create"
                                    class="btn btn-primary ">
                                {{isset($material)? "Ενημέρωση":"Δημιουργια"}}
                            </button>
                            <button id="preview-btn" class="under-development btn btn-warning"><i
                                    class="mdi mdi-eye"></i>
                            </button>
                            <button form="material-destroy" data-material-slug="{{$material->slug}}" id="material-delete-btn" class="btn btn-danger float-right">Διαγραφή</button>

                        </div>
                        <form id="material-create" method="post"
                              @if(isset($material))
                              action="{{route('material.update',$material->slug)}}"
                              @else
                              action="{{route('material.store')}}"
                              @endif
                              enctype="multipart/form-data">
                            @csrf
                            @if(isset($material))
                                @method('PATCH')
                            @endif
                        </form>


                        <form  id="material-destroy"  method="POST" action="{{route('material.destroy',$material->slug)}}">
                            @csrf

                                @method('DELETE')

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
                                            <input form="material-create" name="status" type="checkbox"
                                                   id="activeMaterial" data-switch="bool"
                                            @if(isset($material))
                                                {{$material->status==1? 'checked':""}}
                                                @endif
                                            />

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
                                        <select data-placeholder="Επιλέξτε Topics..." id="typeMaterial"
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
                                                value="ss"
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

                            @isset($material)
                                <!-- Cover Preview -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Cover</h4>

                                        </div>
                                        <div class="card-body">
                                            <img id="cover-image" src="{{ url($material->cover) }}" class="img-fluid"

                                                 alt="Cover Image">

                                            <a id="change-cover-btn" class="btn btn-primary btn-block mt-3">Αλλαγή Cover</a>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end course info card -->
                                @endisset

                            @isset($material)
                                <!-- Cover Preview -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Cover</h4>

                                        </div>
                                        <div class="card-body">
                                            <img id="cover-image" src="{{ url($material->cover) }}" class="img-fluid"

                                                 alt="Cover Image">

                                            <a id="change-cover-btn" class="btn btn-primary btn-block mt-3">Αλλαγή Cover</a>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end course info card -->
                                @endisset

                                <hr>
{{--                                @include("components.dropzone",["model"=>isset($material)?$material:null ,"type"=>"Galery","dropzone"=>"galery-material-dropzone"] )--}}
                                <div class="border-material">
                                    <h3>Tags</h3>
                                </div>
                            </aside>
                        </div>
                    </div>
                    <div class="tab-pane " id="courses-tabs">

                        @include("components.admin.materials.tabsCourses")

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
