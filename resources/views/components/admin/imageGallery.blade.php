<div class="row">
	@forelse ($media as $image)
		<div class="col-lg-2 col-md-3 p-2 position-relative css-img-cnt">
			<img class="fade-image img-fluid" src="{{ url($image->rel_path) }}" alt="{{ $image->name }}">
			<i class="js-add-image image-overlay mdi mdi-plus-circle-outline mr-1 h1"
				data-image-name="{{ $image->name }}"	
				data-image-source="{{ $image->rel_path }}"	
			></i>
		</div>
	@empty
		<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
	@endforelse

</div>

{{ $media->links() }}