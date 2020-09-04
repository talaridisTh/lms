@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    <section class="container-fruid">
        <x-alertMsg :msg="'update'"></x-alertMsg>
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/materials" class="custom-link-primary">Υλικό</a></li>
							<li class="breadcrumb-item active">{{ $material->title }}</li>
						</ol>
					</div>
					<h4 class="page-title">{{ $material->title }}</h4>
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-xl-9 col-lg-12 col-md-12" id="material-form">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#content" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                            <span class="d-none d-md-block">Materials</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#courses-tabs" data-toggle="tab" aria-expanded="true" class="nav-link ">
                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                            <span class="d-none d-md-block">Courses</span>
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
                      @include("components.admin.materials.tabsMaterials")
                    </div>
                    <div class="tab-pane " id="courses-tabs">
                        @include("components.admin.materials.tabsCourses")
                    </div>
                    <div class="tab-pane" id="settings">
                        <p>...</p>
                    </div>
                </div>


            </div>
        @php($courseName=$material->courses()->first()->slug)
            <aside class="col-xl-3 col-lg-5 col-md-12">

                <div class="sticky pb-3 px-2">
                    <button id="update-btn" class="btn btn-primary">Ενημέρωση</button>
                    <a href="{{route('index.material.show',[$courseName,$material->slug])}}" id="preview-btn" class="under-development btn btn-warning"><i class="mdi mdi-eye"></i>
                    </a>
                    <button id="delete-btn" class="under-development btn btn-danger float-right">Διαγραφή</button>
                </div>
                <div class="border-material">

                    <div class="form-group mb-3">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span><strong>Κατάσταση</strong></span>
                            <input type="checkbox" id="activeMaterial" {{$material->status == 0 ? "" : "checked"}}
                            data-switch="bool"/>
                            <label for="activeMaterial" data-on-label="On" data-off-label="Off"></label>
                        </div>
                        <hr>
                    </div>
                    <div class="form-group mb-3">
                        <label for="urlMaterial">URL video</label>
                        <input type="text" class="form-control" id="urlMaterial"
                               value="{{old('material', $material->video_link)}}" placeholder="Εισάγετε URL video...">
                    </div>

                    <div class="form-group mb-3">
                        <label for="topicMaterial">Topic <span class="text-danger"> *</span></label>
                        <select name="topic[]" multiple="multiple" id="topicMaterial" class="form-control">
                            @foreach ($topics as $topic)>
                            <option value="{{$topic->id}}"
                                @foreach($material->topics as $top)
                                    {{$top->id == $topic->id? "selected":""}}
                                 @endforeach>
                                {{$topic->title}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="typeMaterial">Τύπος <span class="text-danger"> *</span></label>
                        <select id="typeMaterial" class="form-control " data-toggle="select2">
                            @foreach($types as $type)
                                <option
                                    value="{{$type->type}}" {{$type->type==$material->type? "selected":""}}>{{$type->type}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{--                    {{dd($material->users)}}--}}


                    <div class="form-group">
                        <label for="updateAtMaterial">Published</label>
                        <input type="text" class="form-control date" id="updateAtMaterial" data-toggle="date-picker"
                               data-single-date-picker="true">
                    </div>
                    <hR>

                    <div class="form-group mb-3">
                        <label for="instructorMaterial">Εισηγητής <span class="text-danger"> *</span></label>
                        <select name="instructor" id="instructorMaterial" class="form-control " data-toggle="select2">
                            <option></option>

                            @foreach($instructors as $instructor)
                                <option
                                    value="{{$instructor->id}}" {{$top->id == $topic->id? "selected":""}} >{{$instructor->fullName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" form-group ">
                        <h3>Creator</h3>
                        <input type="text" class="form-control" id="creatorMaterialHidden" disabled
                               value="{{auth()->user()->fullName}}" placeholder="Εισάγετε URL video...">
                    </div>
                    <hr>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="/assets/js/vendor/dataTables.buttons.min.js"></script>
    <x-routes></x-routes>

    <script src="{{ asset('js/dashboard/materials/materialNew.js') }}"></script>

    <script>


    </script>

@endsection
