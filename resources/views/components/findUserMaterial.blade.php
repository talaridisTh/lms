<select id="VersionFilterMaterial">
    <option value="">Όλες οι Εκδόσεις</option>
    <option value="Normal">Normal</option>
    <option value="Trial">Trial</option>
</select>

<select id="statusFilterMaterial">
    <option value="">Status</option>
    <option value="Published">Published</option>
    <option value="Scheduled">Scheduled</option>
    <option value="Draft">Draft</option>
</select>

<div class="table-responsive">
    @include("components.admin.users.bulkActionUserProfil")
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
            <th>Συμμετοχη</th>
            <th>Publish</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody class="tables-hover-effect">
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>Όνομα</th>
            <th>Έκδοση</th>
            <th>Συμμετοχη</th>
            <th>Publish</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>

