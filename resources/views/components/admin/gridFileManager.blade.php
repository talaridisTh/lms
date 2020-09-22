<div class="row">
	@forelse ($files as $file)
		<div class="col-lg-2 col-md-3 p-2 position-relative css-img-cnt">
			<img class="fade-image img-fluid" src="{{ url($file->thumbnail_path) }}" alt="{{ $file->name }}">
			<i class="js-add-image image-overlay mdi mdi-plus-circle-outline mr-1 h1"
				data-image-name="{{ $file->name }}"	
				data-image-source="{{ $file->rel_path }}"	
			></i>
		</div>
	@empty
		<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
	@endforelse

</div>

{{ $files->links() }}