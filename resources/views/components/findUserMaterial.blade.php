<select id="VersionFilterMaterial">
	<option value="">Όλες οι Εκδόσεις</option>
	<option value="Normal">Normal</option>
	<option value="Trial">Trial</option>
</select>

<div class="table-responsive">

	<div class="text-right mb-3">
		<button id="material-modal-shown-btn" type="button" class="btn btn-primary"
			data-toggle="modal" data-target="#primary-header-modal">
			<i class="mdi mdi-plus-circle mr-2"></i>
			Προσθήκη
		</button>
		<button id="multiple-course-remove" type="button" class="btn btn-secondary"
			data-text="Αφαίρεση" data-enabled-color="btn-danger" disabled>
			Αφαίρεση (0)
		</button>
	</div>

	<table data-id="{{isset($user)? $user['id']:""}}" data-slug="{{isset($user)? $user['slug']:""}} "
		   class="course-materials-list table w-100 nowrap custom-center-table ">
		<thead>
			<tr>
				<th id='all-user-checkbox' class="text-left ">
					<div class='icheck-primary d-inline'>
						<input type='checkbox' id='select-all-courses' autocomplete='off'>
						<label for='select-all-courses'></label>
					</div>
				</th>
				<th>Όνομα</th>
				<th>Έκδοση</th>
				<th>Publish</th>
				<th>Publish</th><!-- hidden column -->
			</tr>
		</thead>
		<tbody class="tables-hover-effect"></tbody>
		<tfoot>
			<tr>
				<th></th>
				<th>Όνομα</th>
				<th>Έκδοση</th>
				<th>Publish</th>
				<th>Publish</th>
			</tr>
		</tfoot>
	</table>
</div>

