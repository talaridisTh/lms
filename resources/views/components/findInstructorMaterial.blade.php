@php($c=0)
@if($userIs =="instructor")

    @if($InstructorCourses)
        @foreach($InstructorCourses->materials as $instructor)
         @foreach($instructor->courses as  $courses)

            <div class="accordion custom-accordion" id="custom-accordion-one">
                <div class="card mb-0">
                    <div class="card-header" id="headingFour">
                        <h5 class="m-0">
                            <a class="custom-accordion-title d-block py-1"
                               data-toggle="collapse" href="#collapse-{{$c}}"
                               aria-expanded="true" aria-controls="collapseFour">
                                <div class="d-flex ">
                                <i class="mdi mdi-cards-variant mr-1"></i>
                                    <span style="flex: 1">{{$courses->name}}</span>

                                </div>

                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                            </a>
                        </h5>
                    </div>

                    <div id="collapse-{{$c++}}" class="collapse "
                         aria-labelledby="headingFour"
                         data-parent="#custom-accordion-one">

                            <div class="tab-content">
                                <!-- Materials table tab-->
                                <div class="tab-pane show active mt-3" id="materials">
                                    <table  class="course-materials-list table w-100 nowrap custom-center-table ">
                                        <thead>
                                        <tr>
                                            <th >Όνομα</th>
                                            <th>Τύπος</th>
                                            <th>Τελ. Ανανέωση</th>
                                            <th>Ημ. Δημιουργίας</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tables-hover-effect">
                                        @foreach($courses->materials as $material)
                                            <tr>

                                                <td>{{ $material['name'] }}</td>
                                                <td>{{ $material['type']}}</td>
                                                <td>{{ $material['updated_at'] }}</td>
                                                <td>{{ $material['created_at'] }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Όνομα</th>
                                            <th>Τύπος</th>
                                            <th>Τελ. Ανανέωση</th>
                                            <th>Ημ. Δημιουργίας</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div><!-- end material tab-pane -->
                                <!-- end about me section content -->

                                <!-- Course edit form tab-pane -->

                                <!-- end settings content-->
                            </div> <!-- end tab-content -->

                    </div>
                </div>
            </div>

        @endforeach
        @endforeach
    @endif
@endif

