<!DOCTYPE html>
<html lang="gr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> 
	<title>Idrogios Education</title>
</head>
<body style="height: 100vh; margin: 0px; font-family: 'Open Sans', sans-serif;">
	<header style="background: #eef2f7; padding: 15px 10px;">
		<div style="max-width: 1000px; margin: auto;">
			<img src="{{ $logo }}" alt="" height="60">
		</div>
	</header>
	<main style="max-width: 1000px; margin: 15px auto; color: #2c2f30; padding: 0 10px;">
		{!! $content !!}
	</main>
	<footer style="width: 100%; background: #eef2f7; position: absolute; bottom: 0">
		<div style="max-width: 1000px; margin: auto; padding: 18px 10px; display: flex; align-items: center">
			<img style="margin-right: 20px;" src="{{ $logo }}" alt="" height="60">
			<div style="font-weight: 700; font-size: 14px; display: flex; flex-direction: column; flex-grow: 1; color: #585d63; line-height: 1.1">
				<span style="font-weight: 700; font-size: 18px;">{{ $contactInfo->city }}</span>
				<span>{{ $contactInfo->address }}</span>
				<span>{{ $contactInfo->email }}</span>
				<span>{{ $contactInfo->phone }}, {{ $contactInfo->fax }}</span>
			</div>
			<div>
				@foreach ($socialLinks as $key => $social)
					
					@if (!is_null($social))
						<a href="{{ $social }}" style="margin: 0 2px;"><img src="{{ asset("images/$key.png") }}" alt=""></a>
					@endif

				@endforeach
			</div>
		</div>
	</footer>
</body>
</html>