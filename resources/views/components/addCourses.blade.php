<table id="datatableAddCourse" class="">
    <thead>
    <tr>
        <th class="text-left">Όνομα</th>
        <th class="text-left">Ενεργό</th>
    </tr>
    </thead>
    <tbody class="tables-hover-effect">


    @foreach ($courses as $course)
        <tr class="tablesTr" data-course-id="{{ $course['id'] }}" data-user-id="{{ $user['id'] }}">

            <td class="cursor-pointer js-link">{{ $course['name'] }}</td>
            <td>
                <input class="btn btn-info  js-button" value="Προσήκη"  data-course-id="{{ $course['id'] }}" data-user="{{$user->id}}" type="submit" id="" />
                <label for="{{ $course['slug'] }}" ></label>
            </td>
        </tr>
    @endforeach

    </tbody>
    <tfoot>
    <tr>

        <th class="text-left">Όνομα</th>
        <th class="text-left">Ενεργό</th>
    </tr>
    </tfoot>
</table>
