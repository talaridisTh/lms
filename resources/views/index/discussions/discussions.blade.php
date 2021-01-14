@extends("layouts.discussion")



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
            padding: 10px;
            position: sticky;
            top: 110px;
            z-index: 1000;
        }

        footer {
            display: none;

        }

    </style>
@endsection

@section("content")
    <div class="container"
         style="max-width: 1100px">
        <div class="row space-x-10 ">
            <div class="w-1/4 discussions-left">
                <x-index.discussions.sidebar-menu :courses=$courses></x-index.discussions.sidebar-menu>
            </div>
            <div class="w-7/10 discussions-right">
                <x-index.discussions.discussions-main :posts=$posts
                                                      :courses=$courses></x-index.discussions.discussions-main>
            </div>
        </div>

    </div>
@endsection


@section("script")

    <script src="{{ mix('js/index/discussions/discussions.js') }}"></script>


@endsection

