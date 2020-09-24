<div class="row background-material mb-3">
    <div class="col-md-12">
        <div class="row justify-content-between py-3 " style="padding-left:2.5rem!important ">
            <div class="col-md-6"><span class="font-weight-bold text-black">Εισηγητής </span>|
                {{$course->curator->first_name}}
            </div>
            <div class="col-md-6 text-right">
                <i class="{{$course->curator->facebook_link?"mdi cursor-pointer h3 mdi-facebook":""}}"></i>
                <i class="{{$course->curator->instagram_link?"mdi cursor-pointer h3 mdi-instagram":""}}"></i>
                <i class="{{$course->curator->youtube_link?"mdi cursor-pointer h3 mdi-youtube":""}}"></i>
                <i class="{{$course->curator->linkedin_link?"mdi cursor-pointer h3 mdi-linkedin":""}}"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 px-3">
        <div class="row mb-3 pl-1">
            <div class="col-md-2  text-center">
                <img height="80" width="80" class="img-fluid img-thumbnail rounded-circle"
                     src="  {{$course->curator->cover}}"
                     alt=""></div>
            <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                <div class="row">
                    <div class="col-md-12">
                        <h4> </h4>
                        <p class=""> {!! $course->curator->profil !!}
                        </p>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
