@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<style>

		.content-page {
			overflow: initial;
		}
		.wrapper {
			overflow: initial;
		}
		.sticky-btns {
			position: sticky;
			top: 70px;
			z-index: 100;
			background-color: #343a40 !important;
		}
		.page-title {
			line-height: 55px !important;
		}

		.page-title-box .page-title-right {
			margin-top: 9px !important;
		}
		.redactor-toolbar-wrapper {
			position: sticky;
			top: 70px;
			background: #404954;
			z-index: 1000;
		}

		#users-datatable_length span.select2:nth-child(3) {
			margin-right: 6px;
		}

	</style>
@endsection

@section('content')

	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="/dashboard/email" class="custom-link-primary">E-Mail</a></li>
							<li class="breadcrumb-item active">{{ $mail->subject }}</li>
						</ol>
					</div>
					<h4 class="page-title">{{ $mail->subject }}</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->
	
	
	<div class="container content-width">
		<div class="mt-1 mb-1 text-right">{{-- an figi to value den mporo na kano isset() sto controller --}}
			<button class="js-submit-btn btn btn-danger ml-1" name="button" value="send">
				Προώθηση
			</button>
			<button class="js-submit-btn btn btn-light" name="button" value="draft">
				Διαγραφή
			</button>
		</div>

		<ul class="nav nav-tabs nav-bordered mb-3">
			<li class="nav-item">
				<a href="#view-mail-tab" class="nav-link active" data-toggle="tab" aria-expanded="false">
					Προβολή
				</a>
			</li>
			<li class="nav-item">
				<a href="#history-tab" class="nav-link" data-toggle="tab" aria-expanded="true">
					Ιστορικό
				</a>
			</li>
			<li class="nav-item">
				<a href="#forward-tab" class="nav-link" data-toggle="tab" aria-expanded="true">
					Προώθηση
				</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="view-mail-tab" class="tab-pane show active">
				
				<div class="position-relative" style="width: 100%; height: 100vh">
					<div style="position: absolute; top: 0; bottom:0; left: 0px; right: 0; background: #fff;">
						<iframe srcdoc="{{ $body }}" frameborder="0" width="100%" height="100%"></iframe>
					</div>
				</div>
			</div>

			<div id="history-tab" class="tab-pane">
				<table id="history-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
					<thead>
						<tr>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Email</th>
							<th class="text-center">Τηλέφωνο</th>
						</tr>
					</thead>
					<tbody class="tables-hover-effect">
						@if (!is_null($recipients))
							@foreach ($recipients as $user)
								<tr>
									<td>{{ $user->last_name }} {{ $user->first_name }}</td>
									<td class="text-center">{{ $user->email }}</td>
									<td class="text-center">{{ $user->phone }}</td>
								</tr>							
							@endforeach							
						@endif
					</tbody>
					<tfoot>
						<tr>
							<th class="text-center">Ονοματεπώνυμο</th>
							<th class="text-center">Email</th>
							<th class="text-center">Τηλέφωνο</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div id="forward-tab" class="tab-pane">
				forward
			</div>

		</div>
	</div><!-- ./container -->

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/mail/edit-email.js") }}"></script>

	
@endsection