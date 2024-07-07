<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        $data = array();
        if(Session::has('loginId')) {
            $data = User::where('id', Session::get('loginId'))->first();
        }

        $client = new Client(['allow_redirects' => true]);
        $request = new \GuzzleHttp\Psr7\Request('GET', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json?vendor=partners-demo", [
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
        ]);
        $response = $client->send($request);
        $content = $response->getBody()->getContents();
        $shopifyData = json_decode($content, true);

        return view('dashboard', compact('data', 'shopifyData'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $product = [
//            "products"  =>  array(
//                "first_name"        => $user->first_name,
//                "last_name"         => $user->last_name,
//                "email"             => $user->email,
//                "phone"             => empty($user->phone) ? '' : $user->phone,
//                "verified_email"    => true,
//                "accepts_marketing" => true,
//                "tag"              => $data->tag,
//                "addresses" => array(
//                    array(
//                        "address1"   => empty($user->address) ? 'null' : $user->address,
//                        "city"       => empty($user->city) ? 'null' : $user->city,
//                        "zip"        => empty($user->zipcode) ? '' : $user->zipcode,
//                        "country"    => empty($user->country) ? '' : $user->country
//                    )
//                )
//            )
        ];
        $client = new Client(['allow_redirects' => true]);
        $request = new \GuzzleHttp\Psr7\Request('POST', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json", [
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
            'Content-Type' => 'application/json'
        ], json_encode(
            $product
        ));
        echo"success create user";
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
