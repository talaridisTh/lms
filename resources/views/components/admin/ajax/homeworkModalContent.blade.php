<div class="custom-border-bottom px-2">
	<h4 class="mb-1">{{ $homework->subject }}</h4>
	<p class="m-0 mb-1">Απο: 
		@can('viewAny', App\Models\User::class)
			<a class="h5 custom-link-primary" href="/dashboard/users/{{ $homework->student->slug }}">
				{{ $homework->student->fullName }}
			</a>
		@else
			<strong>{{ $homework->student->fullName }}</strong>
		@endcan
	</p>
</div>

<div class="p-2">
	{!! $homework->content !!}

	<div class="d-flex flex-wrap mt-3">
		@forelse ($homework->attachments as $attachment)
			<div class="mr-3">
				<i class="font-20 mdi {{ $attachment->fileIcon() }}"></i>
				<a class="custom-link-primary" href="{{ $attachment->rel_path }}" download>

					{{ $attachment->original_name }}.{{ $attachment->ext}}
				</a>
			</div>
		@empty

		@endforelse
	</div>
</div>