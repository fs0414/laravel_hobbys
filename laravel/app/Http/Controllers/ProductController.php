<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product.index')->with('products', $products);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return view('product.show')->with('product', $product);
    }
}
