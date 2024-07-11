<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class GetProductShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get_product_shopify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(['allow_redirects' => true]);
        $request = new \GuzzleHttp\Psr7\Request('GET', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json?vendor=partners-demo", [
            'X-Shopify-Access-Token' => config('myconfig.access_token'),
        ]);
        $response = $client->send($request);
        $content = $response->getBody()->getContents();
        $products = json_decode($content, true);


        foreach ($products['products'] as $product) {
            DB::table('products')->insert([
                "id" => $product['id'],
                'title' => $product['title'],
                'vendor' => $product['vendor'],
                'product_type' => $product['product_type'],

                'tags' =>  $product['tags'],
                'status' => $product['status'],
                'image' => isset($product['image']['src']) ? $product['image']['src'] : 'https://img.freepik.com/premium-photo/man-with-gray-face-black-circle-with-white-background_745528-3178.jpg',
                'created_at' => $product['created_at'],
                'updated_at' => $product['updated_at'],
            ]);
        }
    }
}
