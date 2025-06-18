<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }
    
    public function create()
    {
        return view('product.create');
    }

    // View a product by its ID
    public function read($id)
    {
        // Find a product by its ID
        $product = Product::find($id);

        if (!$product) {

            // Return the selected product
            return response()->with('message_error', 'Something Went Wrong!', 404);

        }
        // Return a JSON response with a 404 error message
        return view('product.read', compact('product'));
        
    }

    // Store a new product
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|numeric',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')
            ->with('message', 'Product Added Successfully.');
    }

    // Open Product edit form
    public function edit($id) {
        // Find the product by its ID
        $product = Product::find($id);

        return view('product.update', compact('product'));
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|numeric',
        ]);

        try {
            // Find the product
            $product = Product::find($id);
            
            if (!$product) {
                return redirect()->back()
                    ->with('message_error', 'Product not found')
                    ->withInput();
            }

            // Update the product directly
            $product->name = $validatedData['name'];
            $product->description = $validatedData['description'];
            $product->price = $validatedData['price'];
            $product->save();

            return redirect()->route('products.index')
                ->with('message', 'Product updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()
                ->with('message_error', 'Error updating product')
                ->withInput();
        }
    }

    // Delete a product
    public function delete($id)
    {

        // // Find the product by its ID
        $product = Product::find($id);

        // 
        if (!$product) {
            return response()->with('message_error', 'Something Went Wrong!', 404);
        }

        // Delete the product
        $product->delete();

        return redirect('/')->with('message', 'Product Deleted Successfully', 200);

    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('products.index')->with('message', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('message_error', 'Error deleting product');
        }
    }
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('message_error', 'Product not found');
        }
        
        return view('product.read', compact('product'));
    }
}