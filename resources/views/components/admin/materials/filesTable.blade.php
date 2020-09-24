@if ( !$files->isEmpty() )

	@php
		$icons = [
			"mp3" => "mdi-music-clef-treble text-warning",
			"pdf" => "mdi-file-pdf-outline text-danger",
			"doc" => "mdi-file-document-outline text-primary",
			"xl" => "mdi-file-table-box text-success",
			"pp" => "mdi-file-powerpoint-outline text-danger",
			"zip" => "mdi-folder-zip-outline text-warning"
		]
	@endphp

	

	<table class="table table-hover table-centered my-4">
	    <thead>
	        <tr>
	            <th class="text-center">Όνομα</th>
	            <th class="text-center">Τύπος</th>
	            <th class="text-center">Μέγεθος</th>
	            <th class="w-5"></th>
	        </tr>
	    </thead>
	    <tbody>
			@foreach ($files as $file)

				{{-- @dd( fnmatch($file->ext, "pdf") ) --}}

				<tr class="js-file-row" data-file-id="{{ $file->id }}">
	        	    <td class="{{-- d-flex align-items-center --}}">
						@if ($file->file_info == "audio/mpeg")
						<i class="my-0 mr-2 js-audio-btn h3 mdi mdi-play-circle-outline cursor-pointer" data-audio-status="paused"></i>
						<audio class="js-audio">
							<source src="{{ $file->rel_path }}" type="{{ $file->file_info }}">
							</audio>
							@endif
							{{ $file->original_name }}
					</td>

					<td class="text-center">
						@foreach ($icons as $type => $icon)

							@if ( fnmatch("$type*", $file->ext ) )
								<i class="h3 mdi {{ $icon }}" title="{{ $file->ext }}"></i>
								@break
							@endif
							
						@endforeach
					</td>

	        	    <td class="text-center">{{ number_format($file->size / 1000000, 2, ",", ".") ."MB" }}</td>
	        	    <td class="text-center">
						<i class="js-remove-file h3 pt-1 mdi mdi-delete-circle-outline custom-danger cursor-pointer"
							data-file-id="{{ $file->id }}"></i>
					</td>
	        	</tr>
			@endforeach
	    </tbody>
	</table>
@else
	<h3 class="w-100 text-center my-5">Δεν βρέθηκαν αρχεία</h3>
@endif


              