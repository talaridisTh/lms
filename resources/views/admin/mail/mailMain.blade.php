@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	<style>
		#mails-datatable {
			border-bottom: 1px solid #464f5b;
			overflow: hidden;
		}
		
		#mails-datatable td:first-child {
			width: 30px;
		}
		#mails-datatable td:last-child {
			width: 85px;
		}

		#mails-datatable > tbody > tr > td:nth-child(3) {
			position: relative;
		}

		#mails-datatable .tool-cnt {
			position: absolute;
			width: 80px;
			top: 50%;
			background: #343a40;
			right: -50px;
			transform: translate(50%, -50%);
			transition: right 0.5s ease-in-out;
		}
		
		#mails-datatable tr:hover .tool-cnt {
			background: #3a444e;
			right: 8px;
		}

		#mails-datatable tr:hover .time-cnt {
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
		</div>

		<table id="mails-datatable" class="table w-100 nowrap js-remove-table-classes">
			<thead class="d-none">
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">
						<div class='icheck-primary d-inline'>
							<input type='checkbox' id='select-all-mails' autocomplete='off'>
							<label for='select-all-mails'></label>
						</div>
					</th>
					<th class="text-center">Περιεχόμενο</th>
					<th class="text-center">Ημ. Αποστολής</th>
					<th class="text-center">Ημ. Αποστολής</th>
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
		</table>
	</div>

	<select class="form-control" id="status-filter">
		<option value="">Όλα τα Mail</option>
		{{-- einai i times apo RegEx min skefteis na ta pirakseis!!! --}}
		<option value="^(?!\s*$).+">Απεσταλμένα</option>
		<option value="^$">Πρόχειρο</option>
	</select>

@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/mail/email-main.js") }}"></script>

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
@if (session("saved"))
	<script>
		Swal.fire({
    	    toast: 'true',
    	    position: 'top-end',
    	    icon: "success",
    	    title: "Αποθηκεύτηκε",
    	    showConfirmButton: false,
    	    timer: 3000,
    	    timerProgressBar: true
    	});
	</script>
@endif
	
@endsection