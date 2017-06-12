@extends('layouts.app')
@section('content')

<div class="container">
	<h1>Bierkoerier Producten</h1>
	<div class="panel panel-default">
		<div class="panel-heading">Acties</div>
		<div class="panel-body">
			<a href="{{route('create-product')}}" class="btn btn-primary">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Product Toevoegen
			</a>
		</div>
	</div>
	<table class="table table-bordered" style="background-color: white">
		<tr>
			<th>#</th>
			<th>Naam</th>
			<th>Beschrijving</th>
			<th>Acties</th>
		</tr>
		@foreach ($products as $product)
		<tr>
			<td>{{ $product->id }}</td>
			<td>{{ $product->name }}</td>
			<td>{{ $product->description }}</td>
			<td>
	          <a href="{{route('edit-product', ['id' => $product->id]) }}" class="btn btn-primary">
	              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> edit
	          </a>
	          <a href="{{route('delete-product', ['id' => $product->id]) }}" class="btn btn-danger">
	              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> delete
	          </a>
         </td>
		</tr>
		@endforeach
	</table>
</div>

@endsection
