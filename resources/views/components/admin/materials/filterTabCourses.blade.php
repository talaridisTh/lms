<select id="topicFilterMaterialCourses">
    <option value="">Όλα τα Type</option>
    @foreach(App\Models\Topic::all() as $topic)
        <option value="{{$topic->title}}">{{$topic->title}}</option>
    @endforeach
</select>

<select id="userFilterMaterialCourses">
    <option value="">Όλοι οι εισηγητές</option>
    @foreach($instructors as $instructor)
        <option value="{{$instructor->fullName}}">{{$instructor->fullName}}</option>
    @endforeach
</select>




<select id="activeFilterMaterialCourses">
    <option value="">Όλες οι Καταστάσεις</option>
    <option value="1">Ενεργά</option>
    <option value="0">Μη Ενεργά</option>
</select>
