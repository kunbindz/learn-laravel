<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
            'image' => 'nullable|url',
        ]);

        $defaultImage = 'https://img.freepik.com/premium-photo/man-with-gray-face-black-circle-with-white-background_745528-3178.jpg';

        $productData = [
            "title"        => $validated['title'],
            "vendor"       => $validated['vendor'],
            "product_type" => $validated['product_type'],
            "price"        => (string)$validated['price'],
            "tags"         => $validated['tags'],
            "status"       => $validated['status'],
            "image"        => isset($validated['image']) ? $validated['image'] : $defaultImage
        ];


        try {
            $product = new Product();
            $product->title = $productData['title'];
            $product->vendor = $productData['vendor'];
            $product->product_type = $productData['product_type'];
            $product->price = $productData['price'];
            $product->tags = $productData['tags'];
            $product->status = $productData['status'];
            $product->image = $productData['image'];

            // Save the product to the database
            $product->save();

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
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
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
