<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta content="{{ $options->description }}" name="description">
	<link rel="shortcut icon" href="{{ $options->logo }}">

	<link rel="stylesheet" href="{{ mix("css/front/app.css") }}">

	<title>{{ $options->title }}</title>
</head>
<body>
	{{-- <div class="side-menu">
		<a href="#">Είσοδος</a>
		<a href="#">Νέα</a>
		<a href="#">Media Gallery</a>
		<a href="#">Επικονωνία</a>
	</div> --}}
	<div id="wrapper">
		<div class="container-fluid nav-cnt">
			<nav class="container">
				{{-- <div class="row"> --}}
				<div class="custom-row">
					{{-- <div class="col-lg-3 col-md-3 col-sm-6 px-0"> --}}
					<div class="custom-col px-0">
						<a href="/">
							<img class="navbar-brand mr-0" src="{{ $options->logo }}" alt="{{ $options->title }}" height="70">
						</a>

					</div>
					{{-- <div class="col-lg-9 col-md-9 col-md-9 px-0 d-none d-md-block"> --}}
					<div class="px-0 d-none d-md-block">
						<ul class="nav navbar-custom justify-content-end mt-3">
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><strong>Νέα</strong></a>
							</li>
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><strong>Media Gallery</strong></a>
							</li>
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><strong>Επικοινωνία</strong></a>
							</li>
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><strong>Είσοδος</strong></a>
							</li>						
						</ul>
					</div>
					{{-- <div class="col-lg-9 col-md-9 col-sm-6 col-sm-auto d-block d-md-none d-flex align-items-center justify-content-end px-0"> --}}
					<div class="d-block d-md-none d-flex align-items-center justify-content-end px-0">
						<div class="burger">
							<div id="one"></div>
							<div id="two"></div>
							<div id="three"></div>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<main class="container">
			{{-- @dump($options->social) --}}
		</main>

		<footer>
			<div class="container">
				<div class="row no-gutters">
					<div class="col-lg-8 col-md-12 col-sm-12 d-flex align-items-center justify-content-center justify-content-lg-start">
						<img class="navbar-brand" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
						<div class="contact-info-cnt">
							<p id="city">{{ $options->contactInfo->city }}</p>
							<p id="address">{{ $options->contactInfo->address }}, {{ $options->contactInfo->zipCode }}</p>
							<p>{{ $options->contactInfo->email }}</p>
							<p>{{ $options->contactInfo->phone }}, {{ $options->contactInfo->fax }}</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-12 col-sm-12 pb-2 pb-lg-0">
						<ul class="nav justify-content-between justify-content-lg-end h-100 align-items-center">
							@foreach($options->social as $social => $link)
								<li class="nav-item ml-3">
									<a href="{{ $link }}">
										<img src="{{ asset("images/$social.png" )}}" alt="{{ $social}}">
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="policies">
				<div class="container">
					<div class="row">
						<div class="col-md-4 text-center text-md-left">
	
							<span>{{ $options->copyright }}</span>
						</div>
						<div class="col-md-4 text-center">
							<a href="#"><span>Πολιτική Απορρήτου</span></a>
	
						</div>
						<div class="col-md-4 text-center text-md-right">
							<a href="#"><span>With </span><span class="heart mx-1"></span><span> by Darkpony</span></a>

						</div>
					</div>

				</div>
			</div>
		</footer>
	</div>
	<script src="{{ mix("js/front/app.js") }}"></script>
</body>
</html>