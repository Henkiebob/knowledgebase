<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;


class ProductsController extends Controller
{

	// public function __construct() {
	//
	//      $this->middleware('auth');
	// }

    public function index() {

    	$products = Product::all();

	  	return view('products.index', compact('products'));
	}

	public function show($id) {

    	$product = Product::find($id);

	  	return view('products.show', compact('product'));
	}



	public function create() {

		return view('products.new');
	}

	public function edit($id) {

		$product = Product::find($id);
		// /$result = Product::find($product);
		return view('products.edit', compact('product'));
	}

	public function update(Request $request, $id) {

		$product = Product::find($id);

	    $this->validate($request,
	    [
	        'name' => 'required|max:255',
	        'price' => 'required|max:5',
	        'description' => 'max:255',
	        'status' => 'required',
	    ]);


	    $product->name = $request->name;
	    $product->price = $request->price;
	    $product->status = $request->status;
	    $product->description = $request->description;
	    $product->save();

	    return redirect('/products');
	}

	public function store(Request $request) {

	    $product = new Product;

	    $this->validate($request,
	    [
	        'name' => 'required|max:255',
	        'price' => 'required|max:5',
	        'description' => 'max:255',
	        'status' => 'required',
	    ]);

	    $product->name = $request->name;
	    $product->price = $request->price;
	    $product->status = $request->status;
	    $product->description = $request->description;
	    $product->save();

	    return redirect('/products');
	}

	public function delete($id)
	{
		$product = Product::find($id);

	  	return view('products.delete', compact('product'));
	}

	public function destroy($id)
	{
		$product = Product::find($id);

		$product->delete();
        return redirect('/products');
	}
}
