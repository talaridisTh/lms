@extends('layouts.dashboard')

@section('css')
	
@endsection

@section('content')

<div class="container">
	<h1>{{ $material['name'] }}</h1>

		<form action="" autocomplete="off">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputEmail4">Όνομα</label>
					<input type="text" class="form-control" id="inputEmail4" value="{{ $material->name }}" placeholder="Δώστε όνομα...">
				</div>
				<div class="form-group col-md-6">
					<label for="course-cover">Cover Εικόνα</label>
					<div class="input-group">
					    <div class="custom-file">
							<input id="course-cover-input" type="file" class="custom-file-input" name="cover">
							<label id="course-cover-label" class="custom-file-label file-search-label-primary" for="course-cover-input">{{ $material->cover }}</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="small-description">Απλή περιγραφή</label>
				<textarea id="small-description" type="text" class="form-control"  placeholder="Δώστε περιγραφή...">{{ $material->small_description }}</textarea>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="topic">Topic</label>
					<select id="topic" class="form-control">
						@foreach ($topics as $topic)
							<option value="{{ $topic['id'] }}" {{ $topic->id == $material->topics[0]['id'] ? "selected" : "" }}>
								{{ $topic['name'] }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="state">Κατάσταση</label>
					<select id="state" class="form-control">
						<option value="1" {{ $material['active'] == 1 ? "selected" : "" }}>Ενεργό</option>
						<option value="0" {{ $material['active'] == 0 ? "selected" : "" }}>Ανενεργό</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="material-content">Περιεχόμενο</label>
				<textarea id="material-content" type="text" class="form-control"  placeholder="Περιεχόμενο...">{{ $material->description }}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">Sign in</button>
		</form>
	</div>

@endsection

@section('scripts')

<script src="{{ asset('js/dashboard/materials/material.js') }}"

@endsection