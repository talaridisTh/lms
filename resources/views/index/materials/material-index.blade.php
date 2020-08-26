@extends("layouts.app")

@section("style")
    <style>

        .wrapper-material {
            background-color: #1e1e1c;
        }
        .moretext {
            display: none;
        }

        .hidden-material{
            overflow: hidden;
            height: 100px;
        }
        .summary-material,.description-material,.content-material,.inscructor-material{
            margin-top: 20px;
            background-color: #ececec;
            border: 1px solid #dcdacb;
            border-radius: 4px;
            padding: 1.9rem 2.4rem ;

        }
        hr.style-two {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }

    </style>
@endsection

@section("content")

    <section class="container-fluid">
        <div class="wrapper-material my-4">
            <div class="container">
                <div class="row  position-relative py-4">
                    <div class="col-md-8 text-light">
                        <p>breadcrumb </p>
                        <h1 class="font-28">{{$materials->title}}</h1>
                        <p class="font-20">{{$materials->subtitle}}</p>
                        <span>Εισηγητές μαθήματος:</span>
                        @foreach($materials->users as $user)
                        <span class="font-14 font-italic cursor-pointer custom-link-primary">{{$user->fullName}},</span>
                        @endforeach
                        <div class="dateMaterial d-flex mt-3">
                            <p class="font-14 mr-3"><i class=" mr-1  mdi mdi-autorenew"></i>Τελευταία ενημέρωση: {{$materials->updated_at}}</p>
                            <p class="font-14"><i class="mdi mr-1 mdi-new-box"></i>Δημιουργήθηκε: {{$materials->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="https://via.placeholder.com/300x250" alt="{{$materials->title}}-logo">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-8  col-sm-12">
                <div class="summary-material ">
                    <h3 class="text-dark">Τι θα μάθετε</h3>
                    <div class="summary-redactor mb-3"> {!!$materials->summary !!}  </div>
                    <span class="moreless-button mt-2 cursor-pointer custom-link-primary" >Read more</span>
                </div>
                <hr class="style-two">
            </div>

        </div>

            <div class="row">

                <div class="col-md-8  col-sm-12 ">
                    <div class="contentmaterial ">
                        <h3 class="text-dark">Περιεχόμενο του μαθήματος</h3>
                        <div class="content-redactor mb-3"> {!!$materials->content !!}  </div>
                    </div>
                    <hr class="style-two">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8  col-sm-12 ">
                    <div class="description-material ">
                        <h3 class="text-dark">Περιγραφή μαθήματος</h3>
                        <div class="description-redactor mb-3"> {!!$materials->description !!}  </div>
                        <span class="moreless-desc-button mt-2 cursor-pointer  custom-link-primary " >Read more</span>
                    </div>

                </div>
            </div>
            @foreach($materials->users as $user)
            <div class="row">
                <div class="col-md-8  col-sm-12 ">
                    <div class="inscructor-material ">
                        <h3 class="text-dark">Πληροφορίες εισηγητή  </h3>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="image-insructor">
                                <img height="100" class=" rounded-circle " src="{{$user->avatar}}" alt="{{$user->avatar}}-logo">
                            </div>
                            <div class="">
                                <p class=" mb-1 font-14 font-weight-bold text-dark"><i class=" dripicons-user mr-2"></i> {{$user->fullName}}</p>
                                <p class="mb-1 font-14 font-weight-bold text-dark"><i class=" mdi mdi-email-sync mr-2"></i>{{$user->email}}</p>
                                <p class="mb-1 font-14 font-weight-bold text-dark"><i class="mr-2 mdi mdi-book-open-page-variant"></i>
                                    {{$user->materials->count()==1? $user->materials->count()." μάθημα": $user->materials->count()." μάθηματα"}}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

        </div>


    </section>



@endsection


@section("script")


    <script>

        // console.log($('.summary-redactor')[0].children[0].classList.add("hidden-material"))

        const moreLessButton =(hiddenElement,button)=> {
            $(hiddenElement)[0].classList.add("hidden-material")
            $(button).click(function() {
                // $(hiddenElement)[0].children[0].classList.remove("hidden-material")
                if ($(button).text() == "Read more") {
                    console.log($(hiddenElement)[0].classList.remove("hidden-material"))

                    $(this).text("Read less")
                } else {
                    console.log($(hiddenElement)[0].classList.add("hidden-material"))
                    $(this).text("Read more")
                }
            });
        }
        moreLessButton(".summary-redactor",".moreless-button")
        moreLessButton(".description-redactor",".moreless-desc-button")

    </script>

@endsection
