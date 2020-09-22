@forelse ($gallery as $image)
	<div class="p-2 css-img-cnt position-relative">
		<img class="js-active-image img-fluid fade-image cursor-move"
			src="{{ $image->thumbnail_path }}" alt="{{ $image->name }}"
			data-image-id="{{ $image->id }}"
		/>
		<span data-image-id="{{ $image->id}}" 
			class="js-remove-image image-overlay h2 px-2 m-0 absolute-top-right cursor-pointer"
			aria-hidden="true"
		>
			&times;
		</span>
		{{-- <div class='icheck-primary absolute-top-left'>
			<input class="js-active-image-checkbox gallery-checkbox" type='checkbox'
				id='{{ $image->name }}{{ $image->id }}' data-image-id="{{ $image->id }}"
				data-image-name="{{ $image->name }}" autocomplete='off'
				data-image-source="{{ $image->rel_path }}"
			/>
			<label class="opacity-transition" for='{{ $image->name }}{{ $image->id }}'></label>
		</div> --}}
	</div>
@empty
	<h3 class="w-100 text-center">Δεν βρέθηκαν εικόνες</h3>
@endforelse