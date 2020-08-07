@if($userCourses)
    <div class="table-responsive">
            <table data-id="{{ $user['id'] }}" class="course-materials-list table w-100 nowrap custom-center-table ">
                <thead>
                <tr>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="tables-hover-effect">
                </tbody>
                <tfoot>
                <tr>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
    </div>
@endif

