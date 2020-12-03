@extends("layouts.app")



@section("style")
    <style>
        .header-custom {
            overflow: initial;
        }
        .content-custom {
            overflow: initial;
        }
        .wrapper-custom {
            overflow: initial;
        }
        .stick {
            position: sticky;
            top: 55px;
            z-index: 1000;
        }
        footer{
            display: none;

        }

    </style>
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-3 discussions-left">
                <x-index.discussions.sidebar-menu :courses=$courses></x-index.discussions.sidebar-menu>
            </div>
            <div class="col-md-9 discussions-right">
                <x-index.discussions.discussions-main :posts=$posts :courses=$courses></x-index.discussions.discussions-main>
            </div>
        </div>

    </div>
@endsection


@section("script")

    <script src="{{ mix('js/index/discussions/discussions.js') }}"></script>


@endsection

