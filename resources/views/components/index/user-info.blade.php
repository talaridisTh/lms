<div class="background-material mb-3">
    <div class="col-md-12">
        <div class="row justify-content-between p-2 " >
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
    <div class="col-md-12 ">
        <div class="row ">
            <div class="col-md-2 p-0 pb-2 text-center">
                <img height="90" width="90" class="img-fluid  rounded-circle"
                     src="  {{$course->curator->cover}}"
                     alt=""></div>
            <div class="col-md-10 text-black d-flex flex-column justify-content-center ">
                <div class="row">
                    <div class="col-md-12 p-0 pr-2">
                        <h4> </h4>
                        <p class=""> {!! $course->curator->profil !!} </p>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
