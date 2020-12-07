@extends('layouts.dashboard')

@section('css')

        {{-- <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" /> --}}


@endsection

@section('content')

<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modalLabel"
    aria-hidden="true">
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
                        <a href="#media-library" id="media-library-tab-btn" data-toggle="tab" aria-expanded="false"
                            class="nav-link active">
                            Media Library
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#upload" id="upload-tab-btn" data-toggle="tab" aria-expanded="true" class="nav-link">
                            Upload
                        </a>
                    </li>
                </ul> <!-- end nav-->
                <div class="tab-content">
                    <div id="media-library" class="tab-pane show active">
                        <!-- Search -->
                        <div class="row">
                            <div class="col-4 mx-auto">
                                <div class="form-group">
                                    <input id="image-search" class="form-control text-center" type="text"
                                        placeholder="Αναζήτηση..." />
                                </div>
                            </div>
                        </div>
                        <div id="gallery-content" data-model="App\Models\Material">
                            @include('components.admin.imageGallery', ['media' => $media])
                        </div>
                    </div>
                    <div id="upload" class="tab-pane">
						<input id="file-pond" class="js-filepond-file-dragging mb-0" type="file[]" />
						<p class="text-right mb-2">
							<small>
								<strong>
									Το πεδίο δέχεται αρχεία: .jpg, .png.
								</strong>
							</small>
						</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="remainings-files-modal" tabindex="-1" role="dialog"
    aria-labelledby="remainings-files-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title" id="remainings-files-modalLabel">File Library</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table id="remaining-files-datatable"
                    class="table w-100 nowrap center-not-second modal-table js-remove-table-classes">
                    <thead>
                        <tr>
                            <th class="text-center">Όνομα</th>
                            <th class="text-center">Μέγεθος</th>
                            <th class="text-center w-5"></th>
                        </tr>
                    </thead>
                    <tbody class="tables-hover-effect"></tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">Όνομα</th>
                            <th class="text-center">Μέγεθος</th>
                            <th class="text-center"></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<!-- Title - Breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="/" class="custom-link-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/dashboard" class="custom-link-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/dashboard/materials" class="custom-link-primary">Υλικό</a></li>
                    <li class="breadcrumb-item active">Νέο Υλικό</li>
                </ol>
            </div>
            <h4 id="material-title" class="page-title">
                Νέο Υλικό
            </h4>
        </div>
    </div>
</div><!-- ./Title - Breadcrumb -->

<div class="wrapper">
    <div class="content">
        <!-- Tab Links -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#content" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                    <span class="d-none d-md-block">Ρυθμίσεις</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#courses-tabs" data-toggle="tab" aria-expanded="true"
                    class="nav-link tab-link text-muted">
                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                    <span class="d-none d-md-block">Courses</span>
                </a>
            </li>
        </ul><!-- ./Tab Links -->

        <div class="tab-content">
            <div class="tab-pane show active" id="content">
                <div class="row">

                    <!-- form inputs -->
                    <div class="col-xl-9 col-lg-8 col-md-12">

                        <form id="material-create" method="post" action="/dashboard/materials" enctype="multipart/form-data" autocomplete="off">

                            @isset($priority)
                            	<input type="text" name="courseId" value="{{ $course->id }}" hidden />
								<input type="text" name="priority" value="{{ $priority }}" hidden />
								@if ( !is_null($section) )

									<input type="text" name="sectionId" value="{{ $section->id }}" hidden/>

								@endif
                            @endisset

                            @csrf

                            <div class="form-row">

                                <div class="form-group col-lg-6">
                                    <label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
									<input name="title" id="titleMaterial" type="text" placeholder="Εισάγετε τίτλο..."
										class="form-control @error("title") is-invalid @enderror" value="{{ old('title') }}" />
                                    @error("title")
                                    	<span class="invalid-feedback" role="alert">
                                    	    <strong>{{ $message }}</strong>
                                    	</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="subtitleMaterial">Υποτίτλος</label>
                                    <input id="subtitleMaterial" name="subtitle" type="text" class="form-control"
                                        placeholder="Εισάγετε υποτίτλο..." value="{{ old('subtitle') }}" />
                                </div>

                            </div>

                            <div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="toggle">Σύνοψη</label>
									<input id="summary-toggle" data-switch="success"
										data-field="summary" type="checkbox" name="summaryField"/>
									<label for="summary-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>

                                <textarea id="summary" name="summary" class="form-control" rows="5"
                                    placeholder="Εισάγετε σύνοψη...">{{ old('summary') }}</textarea>
                            </div>

                            <div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="description">Περιγραφή</label>
									<input id="description-toggle" data-switch="success"
										data-field="description" type="checkbox" name="descriptionField"/>
									<label for="description-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>
                                <textarea id="description" name="description" class="form-control" rows="5"
                                    placeholder="Εισάγετε περιγραφή...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="material-content">Περιεχόμενο</label>
									<input id="content-toggle" data-switch="success"
										data-field="content" type="checkbox" name="contentField"/>
									<label for="content-toggle" data-on-label="On" data-off-label="Off"></label>
								</div>
                                <textarea id="material-content" name="content" class="form-control" rows="5"
                                    placeholder="Εισάγετε περιεχόμενο...">{{ old('content') }}</textarea>
                            </div>

                        </form>

                    </div><!-- ./form inputs -->

                    <div class="col-xl-3 col-lg-4 col-md-12 pt-1">

                        <!-- Βuttons -->
                        <div class="sticky py-3">
                            <button id="store-material-btn" class="btn btn-primary btn-block" type="submit"
								form="material-create">
								Save
                            </button>
                        </div><!-- ./Βuttons -->

                        <div class="card">
                            <div class="card-body">

                                <div class="form-group mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label for="activeMaterial">Κατάσταση</label>
                                        <input form="material-create" name="status" type="checkbox" id="activeMaterial"
                                            data-switch="success" />
                                        <label for="activeMaterial" data-on-label="On" class="mb-0"
                                            data-off-label="Off"></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group mb-3 wrapper-video">
                                    <label for="urlMaterial">URL video</label>
                                    <input   form="material-create" name="video_link" type="text" class=" font-14 input-video form-control"
                                        id="urlMaterial" placeholder="vimeo-id" value="{{ old('video_link') }}" />
                                    <div class="input-group-prepend">
                                        <span style="top: 29px ; left: 0" class="input-group-text px-1 " id="basic-addon1">https://vimeo.com/</span>
                                    </div>

                                </div>
                                <hr>
                                <div class="form-group mb-3">
                                    <label for="typeMaterial">Τύπος</label>
                                    <select data-placeholder="Επιλέξτε Topics..." id="typeMaterial" class="form-control"
										name="type" data-toggle="select2" data-width="100%" form="material-create" autocomplete="off"
										data-minimum-results-for-search="-1">

                                        <option value="Lesson" {{ old("type") === "Lesson" ? "selected" : "" }}>Μάθημα</option>
                                        <option value="Announcement" {{ old("type") === "Announcement" ? "selected" : "" }}>Ανακοίνωση</option>
                                        <option value="Video" {{ old("type") === "Video" ? "selected" : "" }}>Video</option>
                                        <option value="Link" {{ old("type") === "Link" ? "selected" : "" }}>Link</option>

                                    </select>
                                </div>
                                <hr>
                                <div class="form-group mb-0">
                                    <label for="instructorMaterial">Εισηγητές</label>
                                    <select form="material-create" name="instructors[]" multiple id="instructorMaterial"
                                        class="form-control" data-toggle="select2" data-width="100%" data-placeholder="Επιλέξτε instructor...">
										@foreach ( $instructors as $instructor )
										
											<option value='{{ $instructor->id }}' 
												{{ old("instructors") != "" && in_array($instructor->id, old("instructors")) ? "selected" : ""}}>
												{{ $instructor->last_name }} {{ $instructor->first_name }}
											</option>";

										@endforeach
                                    </select>
                                </div>

                            </div>
                        </div><!-- ./card -->

                    </div><!-- ./col -->
                </div><!-- ./row -->
            </div><!-- ./tab-pane content -->

        </div>

    </div>
</div>


@endsection

@section('scripts')

<script src="{{ mix("/js/dashboard/materials/newMaterial.js") }}"></script>


@endsection
