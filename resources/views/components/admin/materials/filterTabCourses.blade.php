<select id="topicFilterMaterialCourses">
    <option value="">Όλα τα Type</option>
    @foreach(App\Topic::all() as $topic)
        <option value="{{$topic->title}}">{{$topic->title}}</option>
    @endforeach
</select>

<select id="userFilterMaterialCourses">
    <option value="">Όλοι οι εισηγητές</option>
    @foreach(App\User::getInstructor() as $instructor)
        <option value="{{$instructor->fullName}}">{{$instructor->fullName}}</option>
    @endforeach
</select>




<select id="activeFilterMaterialCourses">
    <option value="">Όλες οι Καταστάσεις</option>
    <option value="1">Ενεργοί</option>
    <option value="0">Μη Ενεργοί</option>
</select>
