@extends('layouts.dashboard')

@section('css')
	<link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> --}}
@endsection

@section('content')
    <div class="container" style="max-width:1370px">
        <div class="row mb-2">
            <div class="col-sm-4">
                {{-- <a href="javascript:void(0);" class="btn btn-primary mb-2"><i class="mdi mdi-plus-circle mr-2"></i>
					Νέο Course
				</a> --}}
            </div>
            <div class="col-sm-8">
                <div class="text-sm-right">
					<a href="courses/create" class="btn btn-secondary mb-2"><i class="mdi mdi-plus-circle mr-2"></i>
						Νέο Course
					</a>
					<div class="btn-group mb-2">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Επιλογές</button>
						<div class="dropdown-menu">
							<a id="delete-courses-btn" class="dropdown-item" href="#">Διαγραφή</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Προσθήκη σε Bundle</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Export</a>

						</div>
					</div>
                    {{--                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>--}}
                    {{--                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>--}}
				</div>
            </div>
        </div>

        <table id="courses-datatable" class="table w-100 nowrap custom-center-table remove-talbe-classes">
            <thead>
            	<tr>
            	    <th class="text-center option-column">Επιλογή</th>
            	    <th class="text-center">Όνομα</th>
            	    <th class="text-center">Ενεργό</th>
            	    <th class="text-center">Τελ. Ενημέρωση</th>
            	    <th class="text-center">Ημ. Δημιουργίας</th>
            	</tr>
            </thead>
            <tbody class="tables-hover-effect">

           {{--  @foreach ($courses as $course)
				<tr data-course-id="{{ $course['id'] }}">
                    <td class="pl-4">
						<div class="icheck-primary d-inline">
							<input class="js-course-checkbox" data-course-id="{{ $course['id'] }}" data-course-name="{{ $course['name'] }}" type="checkbox" id="{{ $course['slug'] }}" autocomplete="off">
							<label for="{{ $course['slug'] }}"></label>
						</div>
					</td>
                    <td class="cursor-pointer js-link">{{ $course['name'] }}</td>
                    <td>
						<input class="js-toggle" data-course-id="{{ $course['id'] }}" type="checkbox" id="{{ $course['slug'] }}-toggle-checkbox" {{ $course['active'] == 0 ? '' : 'checked' }} data-switch="bool" autocomplete="off"/>
						<label for="{{ $course['slug'] }}-toggle-checkbox" data-on-label="On" data-off-label="Off"></label>
					</td>
                    <td class="js-updated-at cursor-pointer js-link">{{ $course['updated_at'] }}</td>
                    <td class="cursor-pointer js-link">{{ $course['created_at']}}</td>
                </tr>
            @endforeach --}}

            </tbody>
            <tfoot>
            	<tr>
					{{-- <th class="text-left">Επιλογή</th> --}}
            	    <th class="text-center">Επιλογή</th>
            	    <th class="text-center">Όνομα</th>
            	    <th class="text-center">Ενεργό</th>
            	    <th class="text-center">Τελ. Ενημέρωση</th>
            	    <th class="text-center">Ημ. Δημιουργίας</th>
            	</tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>

<script>


	$("#courses-datatable").DataTable({
		scrollX:!0,
		"columnDefs": [{ 
			"width": "5%", "targets": 0 
		}],
		processing: true,
		serverSide: true,
		ajax: {
			url: "/api/courses/coursesdatatable",
			type: "post"
		},
		columnDefs: [
			{ orderable: false, "targets": [ 0, 2 ] },
			{ className: "js-link cursor-pointer", "targets": [ 1, 4 ] },
			{ className: "js-link cursor-pointer js-updated-at", "targets": [ 3 ] },
		],
		columns: [
			{data: 'action', name: 'action'},
			{data: 'name', name: 'name'},
			{data: 'active', name: 'active'},
			{data: 'updated_at', name: 'updated_at'},
			{data: 'created_at', name: 'created_at'},
		],
		language:{
			emptyTable: 		"Δεν υπάρχουν εγγραφές",
			info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
			infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
			lengthMenu: 		"_MENU_ Αποτελέσματα ανα σελίδα",
			loadingRecords: 	"Φόρτωση ...",
			processing: 		"Επεξεργασία ...",
			search: 			"Αναζήτηση: ",
			zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
			paginate:{
				previous:"<i class='mdi mdi-chevron-left'>",
				next:"<i class='mdi mdi-chevron-right'>"}
		},
		drawCallback:function(){
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
			$(".remove-talbe-classes > thead > tr > th").removeClass("js-link cursor-pointer js-updated-at");

			atLinkEventListener();
			toggleActive();
		}
	})

	$('#delete-courses-btn').click( function() {
		let checkedBoxes = $('.js-course-checkbox:checked');

		if ( checkedBoxes.length == 0 ) {
			Swal.fire('Δεν έχετε επιλέξει τίποτα');
			return;
		}

		let ids = [];

		for ( let i = 0; i < checkedBoxes.length; i++ ) {
			ids.push( checkedBoxes[i].dataset.courseId );
		}

		Swal.fire({
			title: 'Είστε σίγουρος;',
			text: `${checkedBoxes.length} ${checkedBoxes.length == 1 ? "αρχείο θα διαγραφεί" : " αρχεία θα διαγραφούν"}`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ναί, διαγραφή!',
			cancelButtonText: 'Άκυρο'
		}).then((result) => {
			if (result.value) {
				axios.delete(`/api/courses/massdestroy/${ids}`)
				.then(function (response) {
					Swal.fire({
						toast: 'true',
						position: 'top-end',
						icon: 'success',
						title: `${checkedBoxes.length == 1 ? "Διεγράφη" : "Διαγράφηκαν"}`,
						showConfirmButton: false,
						timer: 3000,
  						timerProgressBar: true
					});
					[...checkedBoxes].forEach(element => {
						element.parentElement.parentElement.parentElement.remove();
					});
				})
				.catch(function (error) {
					Swal.fire({
						toast: 'true',
						position: 'top-end',
						icon: 'error',
						title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
						showConfirmButton: false,
						timer: 3000,
  						timerProgressBar: true
					});
				});

			}
		})
	});

	function toggleActive() {
		$('.js-toggle').unbind();

		$('.js-toggle').on('change', function() {
			let courseCnt = this.parentElement.parentElement;
			let updatedAtElm = courseCnt.getElementsByClassName("js-updated-at")[0];

			axios.patch('/api/courses/active', {
				course: this.dataset.courseId,
				state: this.checked
			})
			.then( (res) => {
				Swal.fire({
					toast: 'true',
					position: 'top-end',
					icon: 'success',
					title: this.checked ? "Ενεργοποιήθηκε" : "Απενεργοποιήθηκε",
					showConfirmButton: false,
					timer: 3000,
  					timerProgressBar: true
				});
				updatedAtElm.textContent = "Μόλις τώρα";
			})
			.catch( (err) => {
				Swal.fire({
					toast: 'true',
					position: 'top-end',
					icon: 'error',
					title: "Παρουσιάστηκε κάποιο πρόβλημα ...",
					showConfirmButton: false,
					timer: 3000,
  					timerProgressBar: true
				});
			});
		});
	}

	

	function atLinkEventListener() {
		$('.js-link').click( function() {
			let courseId = this.parentElement.dataset.courseId;

			window.location = `course/${courseId}`;
		});
	}
	
</script>
@endsection
