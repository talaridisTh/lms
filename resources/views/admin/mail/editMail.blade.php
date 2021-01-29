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

		#users-datatable_length span.select2:not(:last-child) {
			margin-right: 6px;
		}

		#recipients-datatable_length span.select2:not(:last-child) {
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
		<div class="mt-1 mb-1 text-right">
			<a href="/dashboard/email/compose/{{ $mail->id }}" class="btn btn-danger ml-1">
				Προώθηση
			</a>
			<button id="delete-btn" class="btn btn-light">
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
				<a href="#recipients-tab" class="nav-link" data-toggle="tab" aria-expanded="true">
					Παραλήπτες
				</a>
			</li>
		</ul>

		<div class="tab-content mb-3">
			<div id="view-mail-tab" class="tab-pane show active">
				<iframe id="mail-frame" srcdoc="{{ $body }}" frameBorder="0" width="100%"></iframe>

				<div>
					@forelse ($mail->attachments as $attachment)
						<div class="custom-file-details my-1">
							<div class="d-inline-block">

								<div class="mb-1"><span>{{ $attachment->original_name }}.{{ $attachment->ext }}</span></div>
								<div class="d-flex justify-content-between align-items-bottom">

									@if ($attachment->size < 1000000)
										<div class="mr-4"><strong>{{ number_format( floatval($attachment->size / 1000), 2, ",", ".") }}</strong> kb</div>
									@else
										<div class="mr-4"><strong>{{ number_format( floatval($attachment->size  / 1000000), 2, ",", ".") }}</strong> mb</div>
									@endif
									<a class="custom-link-primary h5 m-0" href="{{ url($attachment->rel_path) }}" download>Download</a>
								</div>

							</div>
						</div>
					@empty
						
					@endforelse
				</div>
			</div>

			<div id="recipients-tab" class="tab-pane">
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
								<tr class="js-old-recipients" data-old-recipient-id="{{ $user->id }}">
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

			<form id="delete-mail-form" action="/dashboard/email/{{ $mail->id }}/delete" method="POST">
				@csrf
				@method('DELETE')
			</form>
		</div>
	</div><!-- ./container -->

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/mail/edit-email.js") }}"></script>

@error('recipients')
	<script>
		Swal.fire({
			title: "Προσοχή!",
			text: 'Δεν ορίστηκαν παραλήπτες.',
			icon: 'warning',
			confirmButtonColor: '#536de6',
		});
	</script>
@enderror
	
@endsection