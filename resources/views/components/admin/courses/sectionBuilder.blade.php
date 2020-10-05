@foreach ($sections as $key => $section)

	@php
		$status = [
			'color' => $section->pivot->status == 1 ? 'badge-outline-success px-1 mr-1' : 'badge-outline-danger',
			'text' => $section->pivot->status == 1 ? 'Active' : 'Inactive'
		]
	@endphp

	<div class="card mb-0">
		<div class="card-header d-flex justify-content-between align-items-center" id="{{ $section->slug }}">

			<h5 class="m-0 flex-grow-1">
				<a class="js-chapter-title custom-accordion-title d-block pt-2 pb-2" data-toggle="collapse"
					href="#{{ $section->slug }}-collapse"
					aria-expanded="true" aria-controls="{{ $section->slug }}-collapse">
					{{ $section->title }}
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
					</div>
				</div>
			</h5>
			<div class="tools-cnt pl-4 pr-1 h3 d-flex align-items-center">
				<i class="js-edit-chapter-btn px-1 mdi mdi-square-edit-outline custom-primary cursor-pointer" title="Edit section"></i>
				<i class="js-remove-material px-1 ml-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer"
					data-material-id="{{ $section->id }}" title="Delete section"></i>
				<div class="d-flex justify-content-end align-items-center" style="width: 81px;">
					<span class="js-chapter-badge px-1 font-12 badge {{ $status['color'] }} badge-pill"
						data-material-id="{{ $section->id }}">{{ $status['text'] }}</span>
				</div>
			</div>
		</div>
		
		<div id="{{ $section->slug }}-collapse" class="collapse{{ $key == 0 ? " show" : "" }}"
			aria-labelledby="{{ $section->slug }}" data-parent="#section-accordion">
			<div class="card-body">
				<table class="table mb-0">
					<thead>
						<tr>
							<th class="text-center" scope="col" style="min-width: 400px;">Title</th>
							<th class="text-center w-10" scope="col">Κατάσταση</th>
							<th class="text-center w-10" scope="col">Κατάταξη</th>
							<th class="text-center w-10" scope="col">Τύπος</th>
							<th class="text-center" scope="col">Τελ. Ανανέωση</th>
							<th class="text-center w-5" scope="col"></th>
						</tr>
					</thead>
					<tbody>

						@forelse ($section->chapters as $material)
						<tr class="js-accordion-row" data-material-id="{{ $material->id }}">
							<td>
								<a href='/dashboard/material/{{ $material->slug }}' class='h5 custom-link-primary'>{{ $material->title }}</a>
								<p class='mb-1'>{{ $material->slug }}</p>
								<a href='/dashboard/material/{{ $material->slug }}' class='custom-link-primary'>Edit</a>
								<span class='mx-2'>|</span>
								<a href='#' class='custom-link-primary'>View</a>	
							</td>
							<td class="align-middle text-center">
								@php
									$status = $material->pivot->status == 0 ? "" : "checked";
								@endphp
													
								<input data-material-id='{{ $material->id }}' type='checkbox' id='{{ $material->slug }}-toggle-checkbox' {{ $status }} data-switch='bool' autocomplete='off'/>
								<label for='{{ $material->slug }}-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>
							</td>
							<td class="align-middle text-center">
								<div class='form-group mb-0'>
									<input type='text' class='form-control text-center' 
										data-material-id='{{ $material->id }}' 
										data-current-priority="{{ $material->pivot->priority }}" 
										value="{{ $material->pivot->priority }}" autocomplete='off'>
								</div>
							</td>
							<td class="align-middle text-center">{{ $material->type}}</td>
							<td class="text-center">
								@php
									if ( !is_null($material->updated_at) ) {
										$date = date_create($material->updated_at);
										$dayMonthYear = date_format($date, "d-m-Y");
										$hour = date_format($date, "H:i");
									}
									else {
										$dayMonthYear ="";
										$hour ="";
									}
								@endphp
								<p class='js-date mb-0 mt-1'>{{ $dayMonthYear }}</p>
								<p class='js-time mb-0'>{{ $hour }}</p>
							</td>
							<td class="align-middle text-center">
								<i class="h3 pt-1 mx-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer"></i>
							</td>
						</tr>
						@empty
							<td colspan="6" class="dataTables_empty text-center" valign="top">Δεν υπάρχουν εγγραφές</td>
						@endforelse
					</tbody>
				</table>															
			</div><!-- ./card-body -->
		</div><!-- ./accordion -->
	</div>

@endforeach