<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
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

        }

    }
}
