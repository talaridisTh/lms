<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta content="{{ $description }}" name="description">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
	<title>{{ $title }}</title>
</head>
<body style="background-color: #eef2f7; font-family: 'Open Sans', sans-serif; color: #4d4d4d;">
	<div style="height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
		<img style="margin-bottom: 1rem;" src="{{ url($logo) }}" alt="">
		<div style="max-width: 520px; padding: 1rem; background-color: #fafbfe; border-radius: 0.25rem; box-shadow: 5px 5px 10px 0px rgba(196,196,196,0.61);">
			<h1 style="font-size: 1.350rem;">Καλώς ήρθατε!</h1>
			<div class="uv-card-body">

				<p style="margin-bottom: 1.5rem;">Για να <span style="font-weight: 600; text-decoration: underline;">επιβεβαιώσετε</span> τον λογαριασμό σας και να συνδεθείτε ακολουθήστε τον παρακάτω σύνδεσμο.</p>
				
				<div style="text-align: center;">

					<a href="{{ $url }}" style="display: inline-block; padding: 8px 13px; text-decoration: none; text-align: center; background-color: #06b6d4; color:  #fafbfe; border-radius: 0.25rem; transition: background-color 0.2s ease-in-out;">Σύνδεση</a>
				</div>
			</div>

			<hr style="margin: 1.5rem 0; border-color: #c0c0c0;">
			<div style="font-size: 0.8rem;">
				<p style="margin-bottom: 0.4rem;">Εναλλακτικά μπορείτε να χρησιμοποιήσετε το Link που ακολουθεί.</p>
				<a href="{{ $url }}">{{ $url }}</a>
			</div>
		</div>
		<div>
			<p style="font-size: 0.8rem;">{{ date("Y") }} {{ $copyright }}</p>
		</div>
	</div>
</body>
</html>