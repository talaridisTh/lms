@extends("layouts.app")

@section("style")
@endsection

@section("content")
    <div class="container">
        <table class="table table-centered mb-0">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th>Link</th>
                <th>Καθηγητής</th>
                <th>Course</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user as $u)
                <tr>
                    <td><button id="copyBtn" class=" btn btn-primary btn-sm" data-text="{{$u->pivot->user_link}}">Αντιγραφη</button></td>
                    <td>{{\Str::limit($u->pivot->user_link,50)}}</td>
                    <td>{{auth()->user()->fullName}}</td>
                    <td>{{$u->name}}</td>
                    <td>
                        <i class='{{ App\User::ifExistUrl($u)==" Ενεργο"?  'mdi mdi-circle text-success': 'mdi mdi-circle text-danger'}}'></i>
                        {{App\User::ifExistUrl($u)}}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>


    </div>
@endsection



@section("script")
    <script src="/assets/js/pages/demo.form-wizard.js"></script>

    <script>
        const copyBtn = document.querySelector('#copyBtn');
        copyBtn.addEventListener('click', e => {
            const input = document.createElement('input');
            input.value = copyBtn.dataset.text;
            document.body.appendChild(input);
            input.select();
            if(document.execCommand('copy')) {
                alert('Text Copied');
                document.body.removeChild(input);
            }
        });
    </script>
@endsection




