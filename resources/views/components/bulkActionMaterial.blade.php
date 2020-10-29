<div class="btn-group mb-2">
    <button id="course-bulk-action-btn" disabled type="button"
            class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Επιλογές (0)
    </button>

    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated py-0">
{{--        <div class="btn-group dropleft w-100">--}}
{{--            <button type="button" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                Προσθήκη σε course--}}
{{--            </button>--}}
{{--            <div class="dropdown-menu py-0">--}}
{{--                @foreach($activeCourses as $courses)--}}
{{--                    <a class="dropdown-item js-multiple-update cursor-pointer py-2" data-courses-id="{{$courses->id}}">{{$courses->title}}</a>--}}
{{--					<div class="dropdown-divider my-0"></div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}

		<div class="dropdown-divider my-0"></div>

        <div class="btn-group dropleft w-100">
            <button type="button" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Αλλαγή κατάστασης
            </button>
            <div class="dropdown-menu py-0">
				<a class="dropdown-item js-multiple-change cursor-pointer py-2" data-courses-change="on">Ενεργά</a>
				<div class="dropdown-divider my-0"></div>
				<a class="dropdown-item js-multiple-change cursor-pointer py-2" data-courses-change="off">Μη ενεργά</a>
            </div>
        </div>

		<div class="dropdown-divider my-0"></div>

        <div class="btn-group dropleft w-100">
            <button type="button" class="dropdown-item dropdown-toggle py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Export
            </button>
            <div class="dropdown-menu py-0">
                <a class="dropdown-item py-2" href="#">Print</a>
				<div class="dropdown-divider my-0"></div>
                <a class="dropdown-item button-Excel py-2" href="{{route('export.usersAll')}}">Excel</a>
				<div class="dropdown-divider my-0"></div>
                <a class="dropdown-item py-2" href="#">CVS </a>
            </div>
        </div>

        <div class="dropdown-divider my-0"></div>


        <a class="dropdown-item js-multiple-delete py-2" href="#">Διαγραφή επιλεγμένων</a>
    </div>
</div>
