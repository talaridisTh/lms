<div class=" select2-container form-group ragneButton" style="width: 179px!important;">
    <input type="text" class="form-control date" v placeholder="Επιλέξτε ημερομηνίες..." id="daterange"
       autocomplete="off" />
</div>

<select id="activeFilterMaterial">
    <option value="">Όλες οι Καταστάσεις</option>
    <option value="1">Ενεργοί</option>
    <option value="0">Μη Ενεργοί</option>
</select>

<select id="typeFilterMaterial">
    <option value="">Όλα τα Type</option>
    <option value="Announcement">Announcement</option>
    <option value="Lesson">Lesson</option>
    <option value="Link">Link</option>
    <option value="PDF">PDF</option>
    <option value="Video">Video</option>
</select>

{{-- <select id="courseFilterMaterial">
    <option value="">Όλα τα Courses</option>
    @foreach(App\Models\Course::all() as $course)
    <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select> --}}
