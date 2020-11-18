<div class="row">

	@forelse ($media as $image)
		<div class="col-lg-2 col-md-3 p-2 position-relative css-img-cnt">
			<img class="fade-image img-fluid" src="{{ $image->thumbnailUrl("rel_path") }}" alt="{{ $image->name }}">
			<i class="js-add-image image-overlay absolute-center mdi mdi-plus-circle-outline mr-1 h1"
				data-image-id="{{ $image->id }}" data-image-source="{{ $image->rel_path }}"	
			></i>			
		</div>
	@empty
		<h3 class="w-100 text-center my-5">Δεν βρέθηκαν εικόνες</h3>
	@endforelse

</div>

{{ $media->links() }}