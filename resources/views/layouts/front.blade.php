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
	
	<div class="sidebar">

		<div class="sidebar-title">
			<a href="javascript:void(0);" class="sidebar-toggle float-right">
				<i class="mdi mdi-close"></i>
			</a>
			<h5 class="m-0">Menu</h5>
		</div>

		<div class="rightbar-content h-100 d-flex flex-column justify-content-between">
			<div>
				<ul class="sidebar-ls mt-3 px-5 text-center">
					<li class="nav-item">
						<a class="nav-link-custom nav-link" href="#"><span>Νέα</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link-custom nav-link" href="#"><span>Media Gallery</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link-custom nav-link" href="#"><span>Επικοινωνία</span></a>
					</li>						
				</ul>
			</div>
			<div class="sidebar-social d-flex justify-content-around">
				@foreach($options->social as $social => $link)
					<a href="{{ $link }}">
						<img src="{{ asset("images/$social.png" )}}" alt="{{ $social}}" height="30">
					</a>
				@endforeach
			</div>
			
		</div> <!-- end padding-->

		<div class="sidebar-footer text-center">
			<p class="mb-0">{{ $options->copyright }}</p>
			<p class="mb-0"><a href="#">Πολιτική Απορρήτου</a></p>
			<p class="mb-0"><a class="darkpony" href="#"><span>With </span><span class="heart mx-1"></span><span> by Darkpony</span></a></p>
		</div>

	</div>

	<div class="sidebar-overlay"></div>

	<div class="wrapper">
		<div class="container-fluid nav-cnt">
			<nav class="container-xl">
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
						<ul class="nav justify-content-end mt-3">
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><span>Νέα</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><span>Media Gallery</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link-custom nav-link" href="#"><span>Επικοινωνία</span></a>
							</li>
							<li class="nav-item dropdown">
								<a id="account-btn" type="button" class="nav-link-custom nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span>Είσοδος</span></a>
								
								
								
								<div class="dropdown-menu dropdown-menu-right dropdown-custom py-0" aria-labelledby="account-btn">
									<a class="dropdown-item nav-link-custom custom-dropdown-link py-3" href="#"><span>Σύνδεση</span></a>
									<a class="dropdown-item nav-link-custom custom-dropdown-link py-3" href="#"><span>Εγγραφή</span></a>
								</div>
							</li>						
						</ul>
					</div>
					{{-- <div class="col-lg-9 col-md-9 col-sm-6 col-sm-auto d-block d-md-none d-flex align-items-center justify-content-end px-0"> --}}
					<div class="d-block d-md-none d-flex align-items-center justify-content-end px-0">
						
						<a class="mr-3 mb-0 h3" href="#"><i class="mdi mdi-account-circle-outline"></i></a>
						
						<div id="burger">
							<div id="one"></div>
							<div id="two"></div>
							<div id="three"></div>
						</div>
					</div>
				</div>
			</nav>
		</div>

		<main class="container-xl position-relative">
			{{-- @dump($options->social) --}}
		</main>

		<footer>
			<div class="container-xl">
				<div class="row no-gutters">
					<div class="col-lg-8 col-md-12 col-sm-12 d-flex align-items-center justify-content-start">
						<img class="navbar-brand" src="{{ $options->logo }}" alt="{{ $options->title }}" height="80">
						<div class="contact-info-cnt">
							<p id="city">{{ $options->contactInfo->city }}</p>
							<p id="address">{{ $options->contactInfo->address }}, {{ $options->contactInfo->zipCode }}</p>
							<p>{{ $options->contactInfo->email }}</p>
							<p>{{ $options->contactInfo->phone }}, {{ $options->contactInfo->fax }}</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-12 col-sm-12 d-none d-lg-block">
						<ul class="nav justify-content-lg-end h-100 align-items-center">
							@foreach($options->social as $social => $link)
								<li class="nav-item @if (!$loop->first) ml-3 @endif ">
									<a href="{{ $link }}">
										<img src="{{ asset("images/$social.png" )}}" alt="{{ $social}}">
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="policies d-none d-md-block">
				<div class="container-xl">
					<div class="row">
						<div class="col-md-4 text-center text-md-left">
							<span>{{ $options->copyright }}</span>
						</div>
						<div class="col-md-4 text-center">
							<a href="#"><span>Πολιτική Απορρήτου</span></a>
						</div>
						<div class="col-md-4 text-center text-md-right">
							<a class="darkpony" href="#"><span>With </span><span class="heart mx-1"></span><span> by Darkpony</span></a>

						</div>
					</div>

				</div>
			</div>
		</footer>
	</div>
	<script src="{{ mix("js/front/app.js") }}"></script>
</body>
</html>