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

	<hr>
	<article>

		<h2>Weet je zeker dat je {{ $product->name }} wilt verwijderen?</h2>
		<form method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<input type="submit" name="submit" class="btn btn-danger" value="Ja">
		</form>
	</article>
	

</div>
@endsection
