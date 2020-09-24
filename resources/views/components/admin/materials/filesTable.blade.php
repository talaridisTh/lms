@if ( !$files->isEmpty() )
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
				<tr>
	        	    <td class="d-flex align-items-center">
						@if ($file->file_info == "audio/mpeg")
							<i class="mr-2 js-audio-btn h3 mdi mdi-play-circle-outline cursor-pointer" data-audio-status="paused"></i>
							<audio class="js-audio">
								<source src="{{ $file->rel_path }}" type="{{ $file->file_info }}">
								{{-- <source src="{{ $file->rel->path }}" type="audio/mpeg"> --}}
								{{-- Your browser does not support the audio element. --}}
							</audio>
						@endif
						{{ $file->original_name }}
					</td>
	        	    <td class="text-center">{{ $file->ext }}</td>
	        	    <td class="text-center">{{ $file->size }}</td>
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


              