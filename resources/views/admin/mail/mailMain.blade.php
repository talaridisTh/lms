@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<style>
		.mails-table {
			border-bottom: 1px solid #464f5b;
			overflow: hidden;
		}
		
		.mails-table td:first-child {
			width: 30px;
		}
		.mails-table td:last-child {
			width: 85px;
		}

		.mails-table > tbody > tr > td:nth-child(3) {
			position: relative;
		}

		.mails-table .tool-cnt {
			position: absolute;
			width: 80px;
			top: 50%;
			background: #343a40;
			right: -50px;
			transform: translate(50%, -50%);
			transition: right 0.5s ease-in-out;
		}
		
		.mails-table tr:hover .tool-cnt {
			background: #3a444e;
			right: 8px;
		}

		.mails-table tr:hover .time-cnt {
			display: none;
		}
	</style>
@endsection

@section('content')

	<!-- start page title -->
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">E-Mail</li>
						</ol>
					</div>
					<h4 class="page-title">E-Mail</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->

	<div class="container table-cnt content-width">
		<div class="mb-3 text-right">
			<a href="/dashboard/email/compose" class="btn btn-primary ml-1">
				Δημιουργία
			</a>
			<button id="mail-delete-btn" class="btn btn-secondary ml-1"
				data-text="Διαγραφή" data-enabled-color="btn-danger"
				{{-- data-disabled-color="btn-danger" --}} disabled>
				Διαγραφή (0)
			</button>
		</div>

		@hasanyrole("admin|super-admin")
			<table id="mails-datatable" class="mails-table table w-100 nowrap js-remove-table-classes">
				<thead>
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center">
							<div class='icheck-primary d-inline'>
								<input type='checkbox' id='select-all-mails' autocomplete='off'>
								<label for='select-all-mails'></label>
							</div>
						</th>
						<th class="text-center">Θέμα</th>
						<th class="text-center">Συντάκτης</th>
						<th class="text-center">Ημ. Αποστολής</th>
						<th class="text-center">Ημ. Αποστολής</th>
					</tr>
				</thead>
				<tbody class="tables-hover-effect"></tbody>
				<tfoot>
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center"></th>
						<th class="text-center">Θέμα</th>
						<th class="text-center">Συντάκτης</th>
						<th class="text-center">Ημ. Αποστολής</th>
						<th class="text-center">Ημ. Αποστολής</th>
					</tr>
				</tfoot>
			</table>
		@endhasanyrole
		@hasrole("instructor")
			<table id="instructor-mails-datatable" class="mails-table table w-100 nowrap js-remove-table-classes">
				<thead>
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center">
							<div class='icheck-primary d-inline'>
								<input type='checkbox' id='select-all-mails' autocomplete='off'>
								<label for='select-all-mails'></label>
							</div>
						</th>
						<th class="text-center">Θέμα</th>
						<th class="text-center">Ημ. Αποστολής</th>
						<th class="text-center">Ημ. Αποστολής</th>
					</tr>
				</thead>
				<tbody class="tables-hover-effect"></tbody>
				<tfoot>
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center"></th>
						<th class="text-center">Θέμα</th>
						<th class="text-center">Ημ. Αποστολής</th>
						<th class="text-center">Ημ. Αποστολής</th>
					</tr>
				</tfoot>
			</table>
		@endhasrole
	</div>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

@if (Auth::user()->hasRole("admin|super-admin"))
	<script src="{{ mix("js/dashboard/mail/email-main.js") }}"></script>
@else
	<script src="{{ mix("js/dashboard/mail/instructor-email-main.js") }}"></script>
@endif

@if (session("sent"))
	<script>
		Swal.fire({
    	    toast: 'true',
    	    position: 'top-end',
    	    icon: "success",
    	    title: "Στάλθηκε",
    	    showConfirmButton: false,
    	    timer: 3000,
    	    timerProgressBar: true
    	});
	</script>
@endif
	
@endsection