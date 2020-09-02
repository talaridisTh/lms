<div class=" select2-container form-group ragneButton" style="width: 179px!important;" >
    <input type="text" class="form-control  date" placeholder="Επιλέξτε ημερομηνίες..."   autocomplete="off"   id="daterange"   />
</div>
<select id="activeFilter">
    <option value="">Όλες οι Καταστάσεις</option>
    <option value="1">Ενεργοί</option>
    <option value="0">Μη Ενεργοί</option>
</select>

<select id="fullNameFilter">
    <option value="">Όλα τα Courses </option>
    @foreach(App\Course::all() as $course)
        <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select>

<select id="rolesFilter">
    <option value="">Όλοι οι ρόλοι</option>
    @foreach(App\Role::all() as $role)
        <option value="{{$role->name}}">{{$role->name}}</option>
    @endforeach
</select>

