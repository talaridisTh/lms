<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<form action="{{route('delete.database.id',[request()->segment(2),request()->segment(3),request()->segment(4)])}}"
      id="database-form" method="POST">
    @csrf
    @if(Session::has('message'))
        <div class="password-msg" style="display: none">
            {{Session::get('message')}}
        </div>
    @endif

    <input type="hidden" name="password" id="password" value="">
    <button class="" hidden name="archive" type="submit">
        <i class="fa fa-archive"></i>
        Archive
    </button>
</form>


<script>
    window.onload = archiveFunction;

    async function archiveFunction() {
        event.preventDefault();
        const form = document.querySelector('#database-form');
        let message = document.querySelector(".password-msg")

        if (message) {
            message = document.querySelector(".password-msg").innerHTML
        } else {
            message = "";
        }

        const url = window.location.pathname.split("/");

        const {value: password} = await Swal.fire({
            title: 'Εισάγετε το password',
            input: 'password',
            html: `<p style="margin-top: 0px" ">Το πεδιο με
            <span style="color: red ;text-transform: uppercase;font-weight: bold; ">${url[3]} - ${url[4]}
            </span> του πίνακα <span style="color: red ;text-transform: uppercase;font-weight: bold; "> ${url[2]}
            </span> θα διαγράφη <br><br> <span style="color: red;  ">${message}</span></p>`,
            inputPlaceholder: 'Εισάγετε το password',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        })
        if (password || typeof password == 'string') {
            document.querySelector("#password").value = password
            form.submit();
            // return window.location.href = `/showDB/${table}/${password}`;
        } else {
            return window.location.href = `/`;
        }

    }
</script>