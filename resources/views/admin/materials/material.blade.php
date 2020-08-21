@extends('layouts.dashboard')

@section('css')
	
@endsection

@section('content')

<div class="container">
	<h1>{{ $material['name'] }}</h1>

	<form id="edit-material-form" data-material-id="{{ $material->id }}" action="/dashboard/materials/update/{{ $material->id }}" method="POST"enctype="multipart/form-data" autocomplete="off">
			
			@csrf

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputEmail4">Όνομα</label>
					<input name="title" type="text" class="form-control" id="inputEmail4" value="{{ $material->title }}" placeholder="Δώστε όνομα...">
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
				<label for="description">Περιγραφή</label>
				<textarea id="description" type="text" name="description" class="form-control" placeholder="Δώστε περιγραφή...">{{ $material->description }}</textarea>
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
				<textarea id="material-content" type="text" class="form-control"  placeholder="Περιεχόμενο...">{{ $material->content }}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">Αποθήκευση</button>
		</form>
	</div>

@endsection

@section('scripts')

<script src="{{ asset('js/dashboard/materials/material.js') }}"

@endsection