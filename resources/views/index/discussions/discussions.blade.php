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
            /*z-index: 100;*/
        }

        footer {
            display: none;

        }

    </style>
@endsection

@section("content")
    <div class="container"
         style="max-width: 1100px">
        <div class="row md:space-x-7  space-x-0">
            <div class="md:w-1/4 w-full discussions-left">
                <x-index.discussions.sidebar-menu :courses=$courses></x-index.discussions.sidebar-menu>
            </div>
            <div class="md:w-7/10 w-full xs:m-0 p-4 discussions-right">
                <x-index.discussions.discussions-main :posts=$posts
                                                      :courses=$courses>
                </x-index.discussions.discussions-main>
            </div>
        </div>

    </div>
@endsection


@section("script")

    <script src="{{ mix('js/index/discussions/discussions.js') }}"></script>


@endsection

