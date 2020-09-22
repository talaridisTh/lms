@forelse ($gallery as $image)
	<div class="p-2 css-img-cnt position-relative">
		<img class="img-fluid fade-image cursor-move" src="{{ $image->thumbnail_path }}" alt="{{ $image->name }}">
		<span data-image-id="{{ $image->id}}" 
			class="js-remove-image image-overlay h2 px-2 m-0 absolute-top-right cursor-pointer"
			aria-hidden="true"
		>
			&times;
		</span>
	</div>
@empty
	<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
@endforelse