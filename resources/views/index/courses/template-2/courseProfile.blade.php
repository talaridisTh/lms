@extends("layouts.app")
@section("style")
    <style>
        .dz-preview, .dz-file-preview {
            display: none;
        }

        .filepond--drop-label {
            background: lightgray;
            border-radius: 8px;
        }
    </style>
@endsection
@section("content")


    <x-index.courses.section-header
            :course="$course"
            :announcements="$announcements"
            :sumMaterial="$sumMaterial"
    />


    <article class="mdc:container lg:container max-w-1xl mx-auto flex flex-wrap mt-7">
        <x-index.courses.section-tabs
                :curator=$curator
                :fields="$fields"
                :model="$course"
        />


        <x-index.courses.section-materials
                :course="$course"
                :lessons="$lessons"
                :isSectionExist="$isSectionExist"
                :sections="$sections"
                :countSection="$countSection"
        />


    </article>

    <x-index.courses.section-modal :announcements="$announcements"/>
@endsection

@section("script")
    <script src="{{ mix('js/index/courses/indexCourses.js') }}"></script>


@endsection
