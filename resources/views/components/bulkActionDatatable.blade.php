<style>
    .dropdown-menu-animated.show{
        left: -35px!important;
    }
</style>
<div class="btn-group mb-2 mr-3">
    <button id="course-bulk-action-btn" disabled type="button"
            class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Επιλογές (0)
    </button>

    <div class="dropdown-menu dropdown-menu-animated" style="left: -80px!important;">
        <div class="btn-group dropleft">
            <div class="dropdown-divider"></div>
            <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Προσθήκη σε course
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($activeCourses as $courses)
                    <a class="dropdown-item js-multiple-update cursor-pointer"
                       data-courses-id="{{$courses->id}}">{{$courses->title}}</a>
                @endforeach
            </div>
        </div>


        <div class="dropdown-divider"></div>
        <div class="btn-group dropleft">
            <div class="dropdown-divider"></div>
            <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Αλλαγή κατάστασης
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item js-multiple-change cursor-pointer" data-courses-change="on">Ενεργά</a>
                <a class="dropdown-item js-multiple-change cursor-pointer" data-courses-change="off">Μη ενεργά</a>
            </div>
        </div>


        <div class="dropdown-divider"></div>
        <div class="btn-group dropleft">
            <div class="dropdown-divider"></div>
            <button type="button" id="dropdownMenuButton" class="dropdown-item dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Export
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Print</a>
                <a class="dropdown-item button-Excel" href="{{route('export.usersAll')}}">Excel</a>
                <a class="dropdown-item" href="#">CVS </a>
            </div>
        </div>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item js-detach-delete" href="#">Αφαίρεση άπο Course</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item js-multiple-delete" href="#">Διαγραφή επιλεγμένων</a>
    </div>
</div>
