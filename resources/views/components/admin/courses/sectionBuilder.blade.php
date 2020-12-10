@forelse ($sections as $key => $section)

	@php
		$status = [
			'color' => $section->pivot->status == 1 ? 'badge-outline-success px-1 mr-1' : 'badge-outline-danger',
			'text' => $section->pivot->status == 1 ? 'Active' : 'Inactive'
		]
	@endphp

	<div class="card mb-0">
		<div class="card-header d-flex justify-content-between align-items-center" id="{{ $section->slug }}">

			<h5 class="m-0 flex-grow-1">
				<a class="js-chapter-title custom-accordion-title d-flex align-items-center pt-2 pb-2" data-toggle="collapse"
					href="#{{ $section->slug }}-collapse" data-material-slug="{{ $section->slug }}"
					aria-expanded="true" aria-controls="{{ $section->slug }}-collapse">
					{{ $section->title }}
					<div class="d-flex justify-content-end align-items-center" style="width: 81px;">
						<span class="js-chapter-badge px-1 font-12 badge {{ $status['color'] }} badge-pill"
							data-material-id="{{ $section->id }}">{{ $status['text'] }}</span>
					</div>
				</a>

				<div class="js-edit-chapter d-none form-group w-50">
					<label>Title</label>
					<div class="input-group">
						<input type="text" class="js-chapter-input form-control"
							value="{{ $section->title }}" placeholder="Εισάγετε τίτλο..."
							data-material-slug="{{ $section->slug }}" aria-label="Recipient's username" />
						<div class="input-group-append">
							<button class="js-sumbit-chapter-title-btn btn btn-primary" type="button">Save</button>
						</div>
						<div class="input-group-append">
							<button class="js-cancel-chapter-title-btn btn btn-light ml-2" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</h5>
			<div class="tools-cnt pl-4 pr-1 h3 d-flex align-items-center">

				<i class="js-edit-chapter-btn px-1 ml-2 mdi mdi-square-edit-outline custom-primary cursor-pointer" title="Edit section"></i>
				<i class="js-remove-material px-1 ml-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer"
					data-material-id="{{ $section->id }}" data-material-type="Section" title="Delete section"></i>

				<div class="dropdown">
					<i id="{{ $section->slug }}-dropdown" class="js-section-dots ml-2 mdi mdi-dots-vertical cursor-pointer custom-primary"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated py-0" aria-labelledby="{{ $section->slug }}-dropdown">
						<a class="js-add-chapters-btn dropdown-item d-block py-2" href="#"
							data-toggle="modal" data-chapter="{{ $section->id }}"
							data-target="#add-materials-modal">Προσθήκη Υλικού</a>

						<div class="dropdown-divider my-0"></div>
						
						<div class="btn-group dropleft w-100">
							<a class="js-chapters-status py-2 dropdown-toggle dropdown-item cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Αλλαγή κατάστασης (0)
							</a>
							<div class="dropdown-menu py-0">
								<a class="js-activate-chapters dropdown-item my-0 py-2" href="#"
									data-section-id="{{ $section->id }}">Ενεργοποιήση</a>

								<div class="dropdown-divider my-0"></div>

								<a class="js-deactivate-chapters dropdown-item my-0 py-2" href="#"
									data-section-id="{{ $section->id }}">Απενεργοποίηση</a>
							</div>
						</div>

						<div class="dropdown-divider my-0"></div>
						<a class="js-multiple-chapter-remove dropdown-item d-block py-2" href="#" disabled>Αφαίρεση επιλογών (0)</a>
					</div>
				</div>

			</div>
		</div>

		<div id="{{ $section->slug }}-collapse" class="collapse{{ $key == 0 ? " show" : "" }}"
			aria-labelledby="{{ $section->slug }}" data-parent="#section-accordion">
			<div class="card-body overflow-x-auto">
				<table class="table mb-0" data-section-id="{{ $section->id }}" data-section-slug="{{ $section->slug }}">
					<thead>
						<tr>
							<th class="text-center align-middle" scope="col" style="width: 80px;">
								<div class='icheck-primary d-inline'>
									<input id='{{ $section->slug }}-main-checkbox' class="js-section-main-checkbox" type='checkbox' autocomplete='off'>
									<label for='{{ $section->slug }}-main-checkbox'></label>
								</div>
							</th>
							<th class="text-center" scope="col">Title</th>
							<th class="text-center" scope="col" style="width: 133px;">Highlight</th>
							<th class="text-center" scope="col" style="width: 133px;">Κατάσταση</th>
							<th class="text-center" scope="col" style="width: 115px;">Κατάταξη</th>
							<th class="text-center" scope="col" style="width: 170px;">Τύπος</th>
							<th class="text-center" scope="col" style="width: 180px;">Τελ. Ανανέωση</th>
						</tr>
					</thead>
					<tbody>

						@forelse ($section->chapters()->orderBy("priority")->get() as $material)

							@php
								if ( $material->status == 1 ) {
									$badge = "";
								}
								else {
									$badge = "<span class='badge badge-outline-danger badge-pill ml-3'>Inactive</span>";
								}
							@endphp

							<tr class="js-accordion-row row-hover" data-material-id="{{ $material->id }}"
								data-priority="{{ $material->pivot->priority }}">
								<td class="position-relative text-center align-middle ">
									<div class='icheck-primary d-inline'>
										<input id='{{ $material->slug }}-chapter-checkbox'
											class="js-chapter-checkbox" type='checkbox'
											data-material-id="{{ $material->id }}" autocomplete='off'>
										<label for='{{ $material->slug }}-chapter-checkbox'></label>
									</div>

									<a class='custom-primary add-material' href='#' data-section-id="{{ $section->id }}"
										data-section-slug="{{ $section->slug }}" data-priority='{{ $material->pivot->priority }}'
										data-toggle='modal' data-target='#sections-additions-modal'>
										<i class='mdi mdi-plus-circle-outline mr-1'></i>
									</a>
								</td>

								<td>
									<a href='/dashboard/material/{{ $material->slug }}' class='h5 custom-link-primary'>{{ $material->title }}</a>{!! $badge !!}
									<p class='overflow-ellipsis mb-1' style="max-width: 400px;">{{ $material->slug }}</p>
									<a href='/dashboard/material/{{ $material->slug }}' class='custom-link-primary'>Edit</a>
									<span class='mx-2'>|</span>
									<a href='#' class='custom-link-primary'>View</a>
									<span class='mx-2'>|</span>
									<a href='#' class='custom-link-primary js-remove-chapter'
										data-material-id="{{ $material->id }}">Remove</a>
								</td>
								<td class="align-middle text-center">
									<div class='icheck-success d-inline'>
										<input id='{{ $material->slug }}-chapter-material-highlight'
											class="js-chapter-material-highlight" type='checkbox'
											data-material-id="{{ $material->id }}" autocomplete='off'
											data-section-id="{{ $section->id }}"
											{{ $material->pivot->highlight === 0 ? "" : "checked" }}>
										<label for='{{ $material->slug }}-chapter-material-highlight'></label>
									</div>
								</td>
								<td class="align-middle text-center">
									@php
										$status = $material->pivot->status == 0 ? "" : "checked";
									@endphp

									<input id='{{ $material->slug }}-switch-checkbox' data-section-id="{{ $section->id }}"
										class="js-chapter-toggle" data-material-id='{{ $material->id }}'
										type='checkbox' {{ $status }} data-switch='success' autocomplete='off'/>
									<label for='{{ $material->slug }}-switch-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>
								</td>
								<td class="align-middle text-center">
									<div class='form-group mb-1'>
										<input type='text' class='js-chapter-priority form-control text-center'
											data-material-id='{{ $material->id }}' data-section-id="{{ $section->id }}"
											data-current-priority="{{ $material->pivot->priority }}"
											value="{{ $material->pivot->priority }}" autocomplete='off'>
									</div>
								</td>
								<td class="align-middle text-center">{{ $material->type}}</td>
								<td class="text-center align-middle">
									<div class='js-chapter-publish-cover cursor-pointer' data-material-id='{{ $material->id }}'  data-section-id="{{ $section->id }}">
										<span class='js-badge badge {{ $material->publishBadge()->icon }} badge-pill'>{{ $material->publishBadge()->text }}</span>
										<p class='js-date mb-0 mt-1'>{{ $material->publishDate()->date }}</p><p class='js-time mb-0'>{{ $material->publishDate()->time }}</p>
									</div>
									<input class='js-chapter-publish-picker form-control d-none' type='text'
										data-material-id="{{ $material->id }}" data-section-id="{{ $section->id }}"
										value='{{ $material->publishDate()->date }} {{ $material->publishDate()->time }}'>
								</td>
							</tr>
						@empty
							<td colspan="6" class="dataTables_empty text-center" valign="top">Δεν υπάρχουν εγγραφές</td>
						@endforelse
					</tbody>
					<tfoot>
						<tr>
							<th scope="col"></th>
							<th class="text-center" scope="col">Title</th>
							<th class="text-center" scope="col">Highlight</th>
							<th class="text-center" scope="col">Κατάσταση</th>
							<th class="text-center" scope="col">Κατάταξη</th>
							<th class="text-center" scope="col">Τύπος</th>
							<th class="text-center" scope="col">Τελ. Ανανέωση</th>
						</tr>
					</tfoot>
				</table>
			</div><!-- ./card-body -->
		</div><!-- ./accordion -->
	</div>
@empty
	<div class="no-sections">
		<div class="callout callout-danger">
			<div class="d-flex justify-content-center mb-1">
				<h5>Το Course δεν περιέχει Sections</h5>
			</div>
		</div>
	</div>
@endforelse