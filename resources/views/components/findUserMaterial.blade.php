@if($userCourses)
    <div class="table-responsive">
            <table data-id="{{ $user['id'] }}" class="course-materials-list table w-100 nowrap custom-center-table ">
                <thead>
                <tr>
                    <th >Επιλογη</th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="tables-hover-effect">
                </tbody>
                <tfoot>
                <tr>
                    <th >Επιλογη</th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
    </div>
    <div class="d-flex justify-content-end my-2">
        <div class="btn-group mb-2 ">
            <a id="material-modal-shown-btn" type="button" class="btn btn-primary mr-2 "
               style="color: white"
               data-toggle="modal"
               data-target="#primary-header-modal">
                <i class="mdi mdi-plus-circle mr-2"></i>
                Προσθήκη COURSES
            </a>
        </div>
        <div class="btn-group mb-2 ">
            <button type="button" class="btn btn-secondary dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Επιλογές
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item js-chexbox-delete" href="#">Διαγραφή επιλεγμένων</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Export</a>
            </div>
        </div>
    </div>
@endif

