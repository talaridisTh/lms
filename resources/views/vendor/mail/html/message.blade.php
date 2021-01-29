@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', [
	'url' => config('app.url'),
	"logo" => isset($logo) ? url($logo) : url("/images/logo.png"),
	"title" => $title ?? "Υδρόγειος"
])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ $copyright ?? " Idrogios Education. All rights reserved." }}
@endcomponent
@endslot
@endcomponent
