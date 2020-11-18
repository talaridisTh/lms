@php(  $counter = 0)
@extends("layouts.app")

@section("style")
@endsection

@section("content")
    <x-alertMsg :msg="'create'"></x-alertMsg>
    <div class="container">
        <table class="table table-centered mb-0">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th>Link</th>
                <th>Καθηγητής</th>
                <th>Course</th>
                <th>Απομενουν</th>
            </tr>
            </thead>
            <tbody>

            @hasanyrole('instructor|partner')

            @foreach($userCurent as $u)
                <tr>
                    <td>
                        <button class="copyBtn btn btn-primary btn-sm" data-text="{{$u->pivot->user_link}}">
                            Αντιγραφη
                        </button>
                    </td>
                    <td>{{\Str::limit($u->pivot->user_link,50)}}</td>
                    <td>{{auth()->user()->fullName}}</td>
                    <td>{{$u->name}}</td>
                    <td>{{$usersLeft[$counter++]}}</td>
                </tr>
            @endforeach
            @endhasanyrole

            {{--                //admin can see all users --}}
            @hasanyrole('super-admin|admin')
            @foreach($usersOnlyAdmin as  $user)
                @foreach($user as  $u)
                    <tr>
                        <td>
                            <button class="copyBtn btn btn-primary btn-sm" data-text="{{$u->pivot->user_link}}">
                                Αντιγραφη
                            </button>
                        </td>
                        <td>{{\Str::limit($u->pivot->user_link,50)}}</td>
                        <td>{{App\User::findOrFail($u->pivot->user_id)->fullName}}</td>
                        <td>{{$u->name}}</td>
                        <td>{{$usersLeft[$counter++]}}</td>
                    </tr>
                @endforeach
            @endforeach
            @endhasanyrole


            </tbody>
        </table>


    </div>
@endsection



@section("script")
    <script src="/assets/js/pages/demo.form-wizard.js"></script>

    <script>


        const copyBtn = document.querySelectorAll('.copyBtn');

        copyBtn.forEach((btn) => {
            btn.addEventListener('click', e => {
                const input = document.createElement('input');
                input.value = btn.dataset.text;
                console.log(btn.dataset.text)
                document.body.appendChild(input);
                input.select();
                if (document.execCommand('copy')) {
                    sweetAlert("Το url αντιγράφηκε " , 'success')
                    document.body.removeChild(input);
                }
            });
        })

        let sweetAlert = (title, icon) => {
            Swal.fire({
                toast: 'true',
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

        }

    </script>
@endsection




