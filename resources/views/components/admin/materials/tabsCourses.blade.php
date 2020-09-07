@include("components.admin.materials.filterTabCourses")
<table id="material-course-table" data-material-id="{{$material->id}}"  class="table w-100 nowrap center-not-second ">
    <thead>
    <tr>
        <th class="text-left ">
            <div class='icheck-primary d-inline'>
                <input type='checkbox' id='select-all-courses' autocomplete='off'>
                <label for='select-all-courses'></label>
            </div>
        </th>
        <th class="text-center">Τίτλος</th>
        <th class="text-center">topic</th>
        <th class="text-center">Εισηγητής</th>
        <th class="text-center">Τελ. Ενημέρωση</th>
        <th class="text-center">Ημ. Δημιουργίας</th>
        <th class="text-center">Ημ. Δημιουργίας-hid</th>
        <th class="text-center">active-hid</th>
    </tr>
    </thead>
    <tbody class="tables-hover-effect">
    </tbody>
    <tfoot>
    <tr>
        <th></th>
        <th class="text-center">Τίτλος</th>
        <th class="text-center">topic</th>
        <th class="text-center">Εισηγητής</th>
        <th class="text-center">Τελ. Ενημέρωση</th>
        <th class="text-center">Ημ. Δημιουργίας</th>
        <th class="text-center">Ημ. Δημιουργίας-hid</th>
        <th class="text-center">active-hid</th>
    </tr>
    </tfoot>
</table>
