@if ( !$files->isEmpty() )

	@php
		$icons = [
			"mp3" => "mdi-music-clef-treble",
			"ev3" => "mdi-robot-industrial",
			"pdf" => "mdi-file-pdf-outline text-danger",
			"html" => "mdi-language-html5 text-danger",
			"odg" => "mdi-file-pdf text-danger",
			"doc" => "mdi-file-document-outline text-teal",
			"odt" => "mdi-file-document-outline text-teal",
			"rtf" => "mdi-file-document-outline text-teal",
			"xl" => "mdi-file-table-box text-success",
			"ods" => "mdi-file-table-box text-success",
			"pp" => "mdi-file-powerpoint-outline text-orange",
			"odp" => "mdi-file-powerpoint-outline text-orange",
			"sb3" => "mdi-cat text-orange",
			"zip" => "mdi-folder-zip-outline text-warning",
			"rar" => "mdi-folder-zip-outline text-warning",
		]
	@endphp

	

	<table class="table table-hover table-centered my-4">
	    <thead>
	        <tr>
	            <th class="text-center">Όνομα</th>
	            {{-- <th class="text-center">Τύπος</th> --}}
	            <th class="text-center">Μέγεθος</th>
	            <th class="w-5"></th>
	        </tr>
	    </thead>
	    <tbody>
			@foreach ($files as $file)

				<tr class="js-file-row" data-file-id="{{ $file->id }}">
	        	    <td>
						<div class="d-flex">
							@foreach ($icons as $type => $icon)

								@if ( fnmatch("$type*", $file->ext ) && $file->ext != "mp3")
									<i class="my-1 h3 mdi {{ $icon }}" title="{{ $file->ext }}"></i>
									@break

								@elseif ( $file->ext == "mp3" )

									<i class="js-audio-btn my-1 h3 mdi mdi-play-circle-outline cursor-pointer" data-audio-status="paused"></i>
									<audio preload="auto" class="js-audio">
										<source src="{{ $file->rel_path }}" type="{{ $file->file_info }}">
									</audio>
									@break

								@endif
								
							@endforeach

							<div class="d-inline">

								<a href="{{ $file->rel_path }}" class="mb-0 ml-2 custom-link-primary" download>{{ $file->original_name }}</a>
								<p class="mb-0 ml-2">{{ $file->name}}.{{ $file->ext }}</p>
								
							</div>
						</div>							
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


              