<!-- modal -->
<div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
	   <div class="modal-content">
		   <div class="modal-header modal-colored-header bg-primary">
			   <h4 class="modal-title" id="primary-header-modalLabel">Προσθήκη Course</h4>
			   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		   </div>
		   <div class="modal-body table-cnt">
				<table id="datatableAddCourse" class="table w-100 nowrap modal-table">
				    <thead>
				    	<tr>
				    	    <th class="text-center">
				    	        <div class='icheck-primary d-inline'>
				    	            <input type='checkbox' id='select-all-courses-profile' autocomplete='off'>
				    	            <label for='select-all-courses-profile'></label>
				    	        </div>
				    	    </th>
				    	    <th class="text-center">Όνομα</th>
				    	    <th class="text-center">Topics</th>
				    	    <th class="text-center">Action</th>
				    	</tr>
				    </thead>
				    <tbody class="tables-hover-effect"></tbody>
				    <tfoot>
				    	<tr>
				    	    <th class="text-center"></th>
				    	    <th class="text-center">Όνομα</th>
				    	    <th class="text-center">Topics</th>
				    	    <th class="text-center">Action</th>
				    	</tr>
				    </tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button id="add-multiple-courses-btn" type="button" class="btn btn-secondary"
					data-text="Προσθήκη Επιλογών" data-enabled-color="btn-primary"
					data-disabled-color="btn-secondary" class="btn btn-secondary" disabled>
					Προσθήκη Επιλογών (0)
				</button>
				<button type="button" class="btn btn-light modal-dismiss"
						data-dismiss="modal">
					Close
				</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->