@if($userCourses)
    <div class="table-responsive">
            <table class="course-materials-list table w-100 nowrap custom-center-table ">
                <thead>
                <tr>
                    <th>Όνομα</th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </thead>
{{--                <tbody class="tables-hover-effect">--}}
{{--                @foreach($userCourses as $course)--}}
{{--                <tr>--}}
{{--                    <td>{{$course->name}}</td>--}}
{{--                    <td>{{$user->getCountStudent($course->id)}}</td>--}}
{{--                    <td><h3><i class="mdi text-danger mdi-delete-circle"></i></h3></td>--}}
{{--                </tr>--}}
{{--                @endforeach--}}

{{--                </tbody>--}}
                <tfoot>
                <tr>
                    <th>Όνομα</th>
                    <th>Όνομα</th>
                    <th>Συμμετοχη</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
    </div>
@endif

