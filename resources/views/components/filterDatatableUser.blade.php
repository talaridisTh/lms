<div class=" select2-container form-group ragneButton" style="width: 179px!important;" >
    <input type="text" class="form-control  date"   id="daterange" name="daterange" data-toggle="date-picker" data-cancel-class="btn-warning" />
</div>
<select id="activeFilter">
    <option value="">Καθαρισμος</option>
    <option value="1">Ενεργοι</option>
    <option value="0">Μη ενεργοι</option>
</select>

<select id="fullNameFilter">
    <option value="">Καθαρισμος</option>
    @foreach(App\Course::all() as $course)
        <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select>

<select id="rolesFilter">
    <option value="">Καθαρισμος</option>
    @foreach(App\Role::all() as $role)
        <option value="{{$role->name}}">{{$role->name}}</option>
    @endforeach
</select>


