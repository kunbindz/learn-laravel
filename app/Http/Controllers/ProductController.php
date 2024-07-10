<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $client = new Client(['allow_redirects' => true]);
        $request = new \GuzzleHttp\Psr7\Request('GET', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json?vendor=partners-demo", [
            'X-Shopify-Access-Token' => config('myconfig.access_token'),
        ]);
        $response = $client->send($request);
        $content = $response->getBody()->getContents();
        $shopifyData = json_decode($content, true);

        return view('dashboard', compact('shopifyData'));
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
        $data = $request->all();

        $product = [
            "product" => [
                "title"        => $data['title'] ?? null,
                "vendor"       => $data['vendor'] ?? null,
                "product_type" => $data['product_type'] ?? null,
                "tags"         => $data['tags'] ?? null,
                "status"       => $data['status'] ?? null,
                "image"        => isset($data['image']) ? ['src' => $data['image']] : ['src' => 'https://img.freepik.com/premium-photo/man-with-gray-face-black-circle-with-white-background_745528-3178.jpg'],
            ]
        ];

        $client = new Client(['allow_redirects' => true]);
        $shopifyRequest = new \GuzzleHttp\Psr7\Request('POST', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json", [
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
            'Content-Type' => 'application/json'
        ], json_encode(
            $product
        ));
        try {
            $client->send($shopifyRequest);
            return redirect('/products')->with('success', 'Product created successfully');
        } catch (GuzzleException $e) {

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
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $client = new Client(['allow_redirects' => true]);

        // Prepare the DELETE request
        $removeProductRequest = new \GuzzleHttp\Psr7\Request(
            'DELETE',
            "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products/{$id}.json",
            [
                'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
            ]
        );

        try {
            // Send the request
            $client->send($removeProductRequest);

            // Redirect with success message
            return redirect('/products')->with('success', 'Product deleted successfully');
        } catch (GuzzleException $e) {
            // Handle the exception
            return redirect('/products')->with('error', 'Failed to delete the product');
        }

    }
}
