<div class=" select2-container form-group ragneButton" style="width: 179px!important;">
    <input type="text" class="form-control date" v placeholder="Επιλέξτε ημερομηνίες..." id="daterange"
       autocomplete="off" />
</div>

<select id="activeFilterMaterial">
    <option value="">Καθαρισμός</option>
    <option value="1">Ενεργοί</option>
    <option value="0">Μη Ενεργοί</option>
</select>

<select id="typeFilterMaterial">
    <option value="">Καθαρισμός</option>
    @foreach(App\Material::all()->unique('type') as $course)
    <option value="{{$course->type}}">{{$course->type}}</option>
    @endforeach
</select>

<select id="courseFilterMaterial">
    <option value="">Καθαρισμός</option>
    @foreach(App\Course::all() as $course)
    <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select>
