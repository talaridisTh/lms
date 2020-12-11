<select id="activeFilter">
    <option value="">Όλες οι Καταστάσεις</option>
    <option value="1">Ενεργοί</option>
    <option value="0">Μη Ενεργοί</option>
</select>

<select id="course-filter">
    <option value="">Όλα τα Courses </option>
    @foreach(App\Models\Course::all() as $course)
        <option value="{{$course->title}}">{{$course->title}}</option>
    @endforeach
</select>

<select id="rolesFilter">
    <option value="">Όλοι οι ρόλοι</option>
    <option value="admin">Admin</option>
    <option value="instructor">Εισηγητές</option>
    <option value="student">Μαθητές</option>
    <option value="partner">Partners</option>
    
</select>

