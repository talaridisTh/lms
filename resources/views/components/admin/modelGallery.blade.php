@forelse ($gallery as $image)
	<div class="col-xl-2 col-md-3 p-2 css-img-cnt position-relative">
		<img class="js-active-image img-fluid fade-image cursor-move"
			src="{{ $image->thumbnailUrl("rel_path") }}" alt="{{ $image->name }}"
			data-image-id="{{ $image->id }}"
		/>
		<span data-image-id="{{ $image->id}}" 
			class="js-remove-image image-overlay h2 px-2 m-0 absolute-top-right cursor-pointer"
			aria-hidden="true"
		>
			&times;
		</span>
	</div>
@empty
	<h3 class="w-100 text-center my-5">Δεν βρέθηκαν εικόνες</h3>
@endforelse