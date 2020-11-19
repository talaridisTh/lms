@extends('layouts.dashboard')

@section('css')
<style type="text/css" media="screen">
	.editor-container {
		position: relative;
		width: 100%;
		padding-top: 50%;
	}

    #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
@endsection

@section('content')
{{-- @dump($title) --}}
	<!-- start page title -->
	<div class="container content-width mt-2">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<div class="page-title-right mb-0">
						<ol class="breadcrumb m-0 pb-0">
							<li class="breadcrumb-item"><a href="/" class="custom-link-primary">Home</a></li>
							<li class="breadcrumb-item"><a href="/dashboard" class="custom-link-primary">Dashboard</a></li>
							<li class="breadcrumb-item active">{{ $option->name }}</li>
						</ol>
					</div>
					<h4 id="page-title" class="page-title" data-option-id="{{ $option->id }}">{{ $option->name }}</h4>
				</div>
			</div>
		</div>
	</div><!-- end page title -->
	
	
	<div class="container content-width">
		<div class="d-flex justify-content-end" style="margin-bottom: 29px">
			<button id="update-btn" class="btn btn-info">
				Update
			</button>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="editor-container">
					<div id="editor">{{ $value }}</div>
				</div>

			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ asset("assets/plugins/ace/src-min-noconflict/ace.js") }}"></script>
	<script src="{{ mix("js/dashboard/settings/options.js") }}"></script>
@endsection