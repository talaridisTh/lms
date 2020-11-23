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
			bottom: 0px;
			z-index: 100;
			background-color: #343a40 !important;
		}

	</style>
@endsection

@section('content')

	<!-- sections additionnal content modal -->
	<div class="modal fade" id="new-option-txt-modal" tabindex="-1" aria-labelledby="new-option-txt-modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header modal-colored-header bg-primary">
					<h5 class="modal-title" id="new-option-txt-modalLabel">New Option</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="create-option" action="/dashboard/option/store" method="post" autocomplete="off">

						@csrf
						<div class="form-group">
							<label for="txt-title">Title</label>
							<input type="text" class="form-control" id="txt-title" name="name" placeholder="Εισάγετε τίτλο...">
						</div>
						<div class="form-group">
							<label for="txt-value">Content</label>
							<textarea type="text" class="form-control" id="txt-value" name="value" rows="1" placeholder="Εισάγετε περιεχόμενο..."></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button form="create-option" type="submit" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-light" data-dismiss="modal">Έξοδος</button>
				</div>
			</div>
		</div>
	</div><!-- ./additionnal content modal -->

	<!-- start page title -->
	<div class="container content-width">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">Options</li>
						</ol>
					</div>
					<h4 class="page-title">Options</h4>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="container table-cnt content-width">

		<div class="text-sm-right mb-2">
			<a href="/dashboard/option/create-json" class="btn btn-primary mb-2">
				Νέο Json
			</a>
			<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#new-option-txt-modal">
				Νέο Text
			</a>
		</div>

		<table id="options-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
			<thead>
				<tr>
					<th class="text-center" style="width: 40px;">ID</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center" style="width: 100px;">Τελ. Ενημέρωση</th>
					{{-- <th class="text-center"></th> --}}
				</tr>
			</thead>
			<tbody class="tables-hover-effect"></tbody>
			<tfoot>
				<tr>
					<th class="text-center" style="width: 40px;">ID</th>
					<th class="text-center">Τίτλος</th>
					<th class="text-center" style="width: 100px;">Τελ. Ενημέρωση</th>
					{{-- <th class="text-center"></th> --}}
				</tr>
			</tfoot>
		</table>

	</div>


@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script src="{{ mix("js/dashboard/settings/settings-index.js") }}"></script>


@endsection
