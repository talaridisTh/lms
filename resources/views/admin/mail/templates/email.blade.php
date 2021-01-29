@component('mail::message', [
	"logo" => $logo,
	"title" => $title,
	"copyright" => $copyright
])
# {{ $subject }}

{!! $content !!}

@endcomponent