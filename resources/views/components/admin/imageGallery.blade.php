<div class="row">

	@forelse ($media as $image)
		<div class="col-lg-2 col-md-3 p-2 position-relative css-img-cnt">
			<img class="fade-image img-fluid" src="{{ $image->thumbnail_path }}" alt="{{ $image->name }}">
			<i class="js-add-image image-overlay absolute-center mdi mdi-plus-circle-outline mr-1 h1"
				data-image-id="{{ $image->id }}" data-image-source="{{ $image->rel_path }}
				"	
			></i>
			{{-- <div class='icheck-primary absolute-top-left'>
				<input class="js-gallery-checkbox gallery-checkbox" type='checkbox'
					id='{{ $image->name }}' data-image-id="{{ $image->id }}"
					data-image-name="{{ $image->name }}" autocomplete='off'
					data-image-source="{{ $image->rel_path }}"
				/>
				<label class="opacity-transition" for='{{ $image->name }}'></label>
			</div> --}}
			
		</div>
	@empty
		<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
	@endforelse

</div>

{{ $media->links() }}