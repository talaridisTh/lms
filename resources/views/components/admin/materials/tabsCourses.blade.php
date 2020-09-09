@include("components.admin.materials.filterTabCourses")
<table id="material-course-table" data-material-id="{{isset($material)? $material->id:null}}"  class="table w-100 nowrap center-not-second ">
    <div class=" d-flex justify-content-end mb-3">
        {{--        <button id="material-modal-shown-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-materials-modal">--}}
        {{--            <i class="mdi mdi-plus-circle mr-2"></i>--}}
        {{--            Προσθήκη Υλικού--}}
        {{--        </button>--}}
        <div class="dropdown ml-2">
            @include("components.admin.materials.bulkActionCouseInsideMaterial")
        </div>
    </div>
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

<div class="row mt-3">
    <div class="col-sm-1">
    </div>
</div>
