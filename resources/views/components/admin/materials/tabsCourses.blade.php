@include("components.admin.materials.filterTabCourses")

<div class=" d-flex justify-content-end mb-3">
	{{--        <button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-materials-modal">--}}
	{{--            <i class="mdi mdi-plus-circle mr-2"></i>--}}
	{{--            Προσθήκη Υλικού--}}
	{{--        </button>--}}
	<div class="dropdown ml-2">
		@include("components.admin.materials.bulkActionCouseInsideMaterial")
	</div>
</div>
<table id="material-course-table" data-material-id="{{isset($material)? $material->id:null}}"  class="table w-100 nowrap center-not-second ">
    <thead>
    <tr>
        <th class="text-left ">
            <div class='icheck-primary d-inline'>
                <input type='checkbox' id='select-all-courses' autocomplete='off'>
                <label for='select-all-courses'></label>
            </div>
        </th>
        <th class="text-center">Τίτλος</th>
        <th class="text-center">Εισηγητής</th>
        <th class="text-center">Τελ. Ενημέρωση</th>
        <th class="text-center">Ημ. Δημιουργίας</th>

    </tr>
    </thead>
    <tbody class="tables-hover-effect">
    </tbody>
    <tfoot>
    <tr>
        <th></th>
        <th class="text-center">Τίτλος</th>
        <th class="text-center">Εισηγητής</th>
        <th class="text-center">Τελ. Ενημέρωση</th>
        <th class="text-center">Ημ. Δημιουργίας</th>
    </tr>
    </tfoot>
</table>

<div id="add-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-course-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="add-course-modalLabel">Προσθήκη Υλικού</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body table-cnt">
                <select id="versionFilterMaterial">
                    <option value="">Όλες οι Εκδόσεις</option>
                    <option value="Normal">Normal</option>
                    <option value="Trial">Trial</option>
                </select>
                <table id="remaining-course-material-table" class=" table w-100 nowrap modal-table center-not-second js-remove-table-classes">
                    <thead>
                    <tr>
                        <th class="text-center">
                            <div class='icheck-primary d-inline'>
                                <input class='js-course-checkbox' type='checkbox' id='all-remainings-checkbox' autocomplete='off'>
                                <label for='all-remainings-checkbox'></label>
                            </div>
                        </th>
                        <th class="text-center">Τίτλος</th>
                        <th class="text-center">Εἰσηγητής</th>
                        <th class="text-center">Τύπος</th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody class="tables-hover-effect"></tbody>
                    <tfoot>
                    <tr>
                        <th class="text-center">Επιλογή</th>
                        <th class="text-center">Τίτλος</th>
                        <th class="text-center">Εἰσηγητής</th>
                        <th class="text-center">Τύπος</th>
                        <th class="text-center"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button id="add-remaingings-btn"
                        data-text="Προσθήκη Επιλογών" data-enabled-color="btn-primary"
                        data-disabled-color="btn-secondary" class="btn btn-secondary" disabled>
                    Προσθήκη Επιλογών (0)
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row mt-3">
    <div class="col-sm-1">
    </div>
</div>
