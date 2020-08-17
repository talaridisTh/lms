<form id="buttonUser" class="px-4" action="{{route('user.update',$user->id)}}"
      method="Post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="form-group  col-md-6">
            <label for="firstName">Όνομα</label>
            <input class="form-control @error('first_name') is-invalid @enderror" value="{{$user->first_name}}"
                   name="first_name" type="text" id="firstName">
            @error("first_name")
            <div
                class="invalid-feedback d-block">{{$message}}</div>@enderror
        </div>

        <div class="form-group  col-md-6">
            <label for="lastName">Επίθετο</label>
            <input class="form-control @error('last_name') is-invalid @enderror" value="{{$user->last_name}}"
                   name="last_name" type="text" id="lastName">
            @error("last_name")
            <div
                class="invalid-feedback d-block">{{$message}}</div>@enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group  col-md-6">
            <label for="email">Email</label>
            <input class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}" name="email"
                   type="email" id="email">
            @error("email")
            <div
                class="invalid-feedback d-block">{{$message}}</div>@enderror
        </div>

        <div class="form-group col-md-6">
            <label for="email">Ρολος</label>
            <select class="form-control" name="role">
                @foreach($rolesName as $key => $roleName)
                    <option
                        value="{{ $roleName->name }}" {{ $roleName->name == $user->getRoleNames()[0] ? 'selected' : '' }}>{{ $roleName->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group ">
        <label>Avatar</label>
        <div class="form-group">
            <input type="file" class="form-control" value="{{$user->avatar}}"
                   name="avatar" id="avatar">
        </div>
    </div>

    <div class="form-group text-center">
        <button class="btn btn-primary" type="submit">Ενημέρωση Χρήστη</button>
    </div>

</form>
