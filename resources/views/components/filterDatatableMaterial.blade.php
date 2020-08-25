<div class=" select2-container form-group ragneButton" style="width: 179px!important;" >
    <input type="text" class="form-control  date"   id="daterange" name="daterange" data-toggle="date-picker" data-cancel-class="btn-warning" />
</div>

<select id="activeFilterMaterial">
    <option value="">Καθαρισμος</option>
    <option value="1">Ενεργοι</option>
    <option value="0">Μη ενεργοι</option>
</select>

<select id="typeFilterMaterial">
    <option value="">Καθαρισμος</option>
    @foreach(App\Material::all()->unique('type') as $course)
        <option value="{{$course->type}}">{{$course->type}}</option>
    @endforeach
</select>

<select id="courseFilterMaterial">
    <option value="">Καθαρισμος</option>
    @foreach(App\Course::all() as $course)
        <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select>




