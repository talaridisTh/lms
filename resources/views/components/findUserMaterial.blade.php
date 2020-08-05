@if($userIs =="student")
    @if($userCourses)
    @foreach($userCourses as $users)
        <div class="accordion custom-accordion" id="custom-accordion-one">
            <div class="card mb-0">
                <div class="card-header" id="headingFour">
                    <h5 class="m-0">
                        <a class="custom-accordion-title d-block py-1"
                           data-toggle="collapse" href="#collapseFour"
                           aria-expanded="true" aria-controls="collapseFour">

                            <i class="mdi mdi-cards-variant mr-1"></i>
                            {{--                                                        {{$user->courses->first() == true ? $user->courses->first()->name : '' }}--}}
                            {{$users->name}}

                            <i class="mdi mdi-chevron-down accordion-arrow"></i>
                        </a>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse show"
                     aria-labelledby="headingFour"
                     data-parent="#custom-accordion-one">
                    <div class="card-body">
                        <div class="table-responsive">
                                @foreach($allMaterials as $key =>   $materials )
                                    @if ($loop->parent->index ==$key)
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
                                                    @foreach($materials as $material)
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
                                    @endif
                                @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@endif
@endif
