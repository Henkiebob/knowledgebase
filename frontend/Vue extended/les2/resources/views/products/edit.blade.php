@extends('layouts.app')
@section('content')
<div class="container">
	<h1>Product admin</h1>
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<form method="POST">
	{{ method_field('PUT') }}
	    <div class="form-group">
	        <label for="name">Naam</label>
	        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" />
	    </div>
	        <div class="form-group">
	        <label for="description">Beschrijving</label>
	        <textarea name="description" id="description" class="form-control"/>{{ $product->description }}</textarea>
	    </div>
	    <div class="form-group">
	        <label for="price">Prijs</label>
	        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" />
	    </div>
	    <div class="form-group">
	        <div class="checkbox">
	            <label for="status"><input type="checkbox" value="{{ $product->status ? 1 : 0 }}" name="status" checked>Actief</label>
	        </div>
	    </div>

	    {{ csrf_field() }}
	    <input type="submit" name="submit" class="btn btn-succes" value="Opslaan">
	</form>
</div>
@endsection
