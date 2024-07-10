
@extends('layout')
@section('content')
    @extends('header')

    <div class="mx-auto max-w-7xl p-6 lg:px-8">
         <h1>hi <strong>{{session('user')->name}}</strong>, welcome to Dashboard !</h1>
        {{-- Table--}}

        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pt-2 pb-2 bg-white dark:bg-gray-900">
            <div>
                <a href={{route('products.create')}}>
                    <button  class="inline-flex items-center text-white bg-blue-500 font-medium rounded-lg text-sm px-3 py-1.5" type="button">
                        Create product
                    </button>
                </a>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">

            <div class="h-[75vh] ">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 w-full" style="position: sticky; top: 0">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Vendor
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Tags
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Product type
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Pricing
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody >

                    @if(count($shopifyData['products']) !== 0)
                        @foreach($shopifyData['products'] as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 ">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" src="{{$product['image']['src'] ?? 'https://img.freepik.com/premium-photo/man-with-gray-face-black-circle-with-white-background_745528-3178.jpg'}}" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{$product['title']}}</div>
                                        <div class="font-normal text-gray-500"> ID: {{$product['id']}}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{$product['vendor']}}
                                </td>
                                <td class="px-6 py-4">
                                    <span class=" {{ $product['tags'] === 'men' ? 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300' : 'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300' }}">{{$product['tags']}}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $product['product_type']}}
                                </td>
                                <td class="px-6 py-4">
                                    ${{$product['variants'][0]['price']}}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($product['status'] === 'active')
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                        @else
                                            <div class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2"></div>
                                        @endif
                                        {{$product['status'] === 'active' ? "Active" : "Draft"}}
                                    </div>
                                </td>

                                <td class="px-6 py-4 flex gap-3">

                                    <form action="{{ route('products.edit', ['product' => $product['id']]) }}" method="POST" style=" margin-bottom: 0" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('EDIT')
                                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit</button>
                                    </form>

                                    <form action="{{ route('products.destroy', ['product' => $product['id']]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-6 py-4 text-center" colspan="4"> No product found.</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
