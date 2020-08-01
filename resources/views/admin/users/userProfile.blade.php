@extends('layouts.dashboard')

@section('css')
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="container" style="max-width:1400px">
        <div class="content">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src=" https://robohash.org/set_set3/bgset_bg1/3.14159?size=500x500" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">

                            <h4 class="mb-0 mt-2">Dominic Keller</h4>
                            <p class="text-muted font-14">Founder</p>

                            <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>


                            <div class="text-left mt-3">
                                <h4 class="font-13 text-uppercase">About Me : </h4>
                                <p class="text-muted font-13 mb-3">
                                    Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the
                                    1500s, when an unknown printer took a galley of type.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">Geneva
                                                    D. McKnight</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">(123)
                                                    123 1234</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">user@email.domain</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span class="ml-2">USA</span></p>
                                <div class="text-right">
                                <button type="button" class="btn btn-danger btn-sm mb-2 ">Διαγραφη Onoma user</button>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->


                </div> <!-- end col-->

                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                        About
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                        Timeline
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                        Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="aboutme">

                                    <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                        Projects</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-nowrap mb-0">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Clients</th>
                                                <th>Project Name</th>
                                                <th>Start Date</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><img src="https://robohash.org/24.218.243.24.png" alt="table-user" class="mr-2 rounded-circle" height="24"> Halette Boivin</td>
                                                <td>App design and development</td>
                                                <td>01/01/2015</td>
                                                <td>10/15/2018</td>
                                                <td><span class="badge badge-info-lighten">Work in Progress</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div> <!-- end tab-pane -->

                                <div class="tab-pane show active" id="timeline">

                                    <div class="timeline-alt pb-0">
                                        <div class="timeline-item">
                                            <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                            <div class="timeline-item-info">
                                                <h5 class="mt-0 mb-1">Lead designer / Developer</h5>
                                                <p class="font-14">websitename.com <span class="ml-2 font-12">Year: 2015 - 18</span></p>
                                                <p class="text-muted mt-2 mb-0 pb-3">Everyone realizes why a new common language
                                                    would be desirable: one could refuse to pay expensive translators.
                                                    To achieve this, it would be necessary to have uniform grammar,
                                                    pronunciation and more common words.</p>
                                            </div>
                                        </div>

                                        <div class="timeline-item">
                                            <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
                                            <div class="timeline-item-info">
                                                <h5 class="mt-0 mb-1">Senior Graphic Designer</h5>
                                                <p class="font-14">Software Inc. <span class="ml-2 font-12">Year: 2012 - 15</span></p>
                                                <p class="text-muted mt-2 mb-0 pb-3">If several languages coalesce, the grammar
                                                    of the resulting language is more simple and regular than that of
                                                    the individual languages. The new common language will be more
                                                    simple and regular than the existing European languages.</p>

                                            </div>
                                        </div>

                                        <div class="timeline-item">
                                            <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                            <div class="timeline-item-info">
                                                <h5 class="mt-0 mb-1">Graphic Designer</h5>
                                                <p class="font-14">Coderthemes Design LLP <span class="ml-2 font-12">Year: 2010 - 12</span></p>
                                                <p class="text-muted mt-2 mb-0 pb-2">The European languages are members of
                                                    the same family. Their separate existence is a myth. For science
                                                    music sport etc, Europe uses the same vocabulary. The languages
                                                    only differ in their grammar their pronunciation.</p>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end timeline -->

                                </div>

                                <div class="tab-pane" id="settings">
                                    <form>
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">First Name</label>
                                                    <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="userbio">Bio</label>
                                                    <textarea class="form-control" id="userbio" rows="4" placeholder="Write something..."></textarea>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Email Address</label>
                                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                                    <span class="form-text text-muted"><small>If you want to change email please <a href="javascript: void(0);">click</a> here.</small></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userpassword">Password</label>
                                                    <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                                    <span class="form-text text-muted"><small>If you want to change password please <a href="javascript: void(0);">click</a> here.</small></span>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building mr-1"></i> Company Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="companyname">Company Name</label>
                                                    <input type="text" class="form-control" id="companyname" placeholder="Enter company name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cwebsite">Website</label>
                                                    <input type="text" class="form-control" id="cwebsite" placeholder="Enter website url">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth mr-1"></i> Social</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-fb">Facebook</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-fb" placeholder="Url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-tw">Twitter</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-tw" placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-insta">Instagram</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-insta" placeholder="Url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-lin">Linkedin</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-lin" placeholder="Url">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-sky">Skype</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-sky" placeholder="@username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="social-gh">Github</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="mdi mdi-github-circle"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="social-gh" placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end settings content-->

                            </div> <!-- end tab-content -->
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- End Content -->


    </div> <!-- content-page -->

@endsection

@section('scripts')
    <script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script>

    </script>
@endsection
