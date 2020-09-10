
@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')

	<h1>Content</h1>
    {{-- <div class="row">
        <div class="col-md-12">

            <div id="mdb-lightbox-ui"></div>

            <div class="mdb-lightbox d-flex flex-wrap" >
               @foreach($allMedia as $media)
                   {{dd($media->getUrl())}}
                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(149).jpg" data-size="1600x1067">
                        <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(149).jpg" class="img-fluid" />
                    </a>
                </figure>
                @endforeach

            </div>

        </div>
    </div> --}}

@endsection

@section('scripts')
    {{-- <script>
        // MDB Lightbox Init
        $(function () {
            $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
        });
    </script> --}}

@endsection

