<div class="btn-group mb-2">
    <button type="button" hidden class="btn btn-secondary dropdown-toggle bulk-action" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Επιλογές
    </button>
    <div class="dropdown-menu dropdown-menu-animated">
        <div class="dropdown-divider"></div>
        <div class="btn-group dropleft">
            <div class="dropdown-divider"></div>
            <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Προσθήκη σε course
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($activeCourses as $courses)
                    <a class="dropdown-item js-multiple-update cursor-pointer" data-courses-id="{{$courses->id}}">{{$courses->title}}</a>
                @endforeach
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="btn-group dropleft">
            <div class="dropdown-divider"></div>
            <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Export
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Print</a>
                <a class="dropdown-item button-Excel" href="{{route('export.usersAll')}}">Excel</a>
                <a class="dropdown-item" href="#">CVS </a>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item js-multiple-delete" href="#">Διαγραφή επιλεγμένων</a>
    </div>
</div>
