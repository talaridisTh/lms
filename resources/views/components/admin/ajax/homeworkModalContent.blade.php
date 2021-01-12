<h4 class="mb-1">{{ $homework->subject }}</h4>
<p class="mt-0 mb-3">Απο: {{ $homework->student->fullName }}</p>
					
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