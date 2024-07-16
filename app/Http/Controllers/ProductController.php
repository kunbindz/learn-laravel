<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            // Search the products table based on the query
            $products = Product::where('title', 'LIKE', "%$query%")
                ->orWhere('vendor', 'LIKE', "%$query%")
                ->orWhere('product_type', 'LIKE', "%$query%")
                ->orWhere('id', 'LIKE', "%$query%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // If no search query, get all products
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('dashboard', compact('products', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'vendor' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'price' => 'required|string',
            'tags' => 'nullable|string',
            'status' => 'required|string',
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $defaultImage = 'https://img.freepik.com/premium-photo/man-with-gray-face-black-circle-with-white-background_745528-3178.jpg';

        try {
            $productData = $request->all();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = $file->store('uploads', 'public');
                $productData['image'] = $filePath;
            }
            $product = Product::create($productData);

            // Redirect with a success message
            return redirect('/products')->with('success', 'Product created successfully');
        } catch (GuzzleException $e) {
            return $e;
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'vendor' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'tags' => 'nullable|string',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);
            $productData = $request->only(['title', 'vendor', 'product_type', 'price', 'tags', 'status']);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($product->image) {
                    Storage::delete('public/' . $product->image);
                }
                $filePath = $request->file('image')->store('uploads', 'public');
                $productData['image'] = $filePath;
            }

            // Update the product in the database
            $product->update($productData);

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('fail', 'Something wrong');
        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $deleted = Product::destroy($id);

        if ($deleted) {
            return redirect('/products')->with('success', 'Product deleted successfully');
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }


    }
}
