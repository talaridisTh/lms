@extends('layouts.dashboard')

@section('css')

@endsection

@section('content')
    <form id="buttonUser" class="px-4" action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-group  col-md-6">
                <label for="firstName">Όνομα</label>
                <input class="form-control  @error('first_name') is-invalid @enderror"  name="first_name" type="text" id="firstName">
                @error("first_name")
                <div class="invalid-feedback d-block">{{$message}}</div>@enderror
            </div>

            <div class="form-group  col-md-6">
                <label for="lastName">Επίθετο</label>
                <input class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text" id="lastName">
                @error("last_name")
                <div class="invalid-feedback d-block">{{$message}}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group  col-md-6">
                <label for="email">Email</label>
                <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" id="email">
                @error("email")
                <div class="invalid-feedback d-block">{{$message}}</div>@enderror
            </div>

            <div class="form-group col-md-6">
                <label for="email">avatar</label>
                <select class="form-control " name="role">
                    @foreach($rolesName as $roleName)
                        <option value="{{$roleName->name}}">{{$roleName->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group ">
            <label>Avatar</label>
            <div class="form-group">
                <label class="custom-file-label" for="avatar">Choose file</label>
                <input type="file" class="form-control " name="avatar" id="avatar">
            </div>
        </div>


        <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Εγγραφη</button>
        </div>

    </form>
@endsection

@section('scripts')

@endsection
