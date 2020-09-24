@if ( !$files->isEmpty() )
	<table class="table table-hover table-centered my-4">
	    <thead>
	        <tr>
	            <th>Όνομα</th>
	            <th class="text-center">Τύπος</th>
	            <th class="text-center">Μέγεθος</th>
	            <th class="w-5"></th>
	        </tr>
	    </thead>
	    <tbody>
			@foreach ($files as $file)
				<tr>
	        	    <td>{{ $file->original_name }}</td>
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


              