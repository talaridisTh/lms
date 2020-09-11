


    <div class="table-responsive">
 @include("components.admin.users.bulkActionUserProfil")
            <table data-id="{{isset($user)? $user['id']:""}} " data-slug="{{isset($user)? $user['slug']:""}} " class="course-materials-list table w-100 nowrap custom-center-table ">
                <thead>
                <tr>
                    <th id='all-user-checkbox' class="text-left ">
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' id='select-all-courses' autocomplete='off'>
                            <label for='select-all-courses'></label>
                        </div>
                    </th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="tables-hover-effect">
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
    </div>

