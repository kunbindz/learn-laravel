@extends('layout')
@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-20 w-auto rounded-lg" src="https://cdn.shopify.com/app-store/listing_images/9c2f67b482aeae04937fd544c0bfe6a8/icon/CMjv-JmUpv0CEAE=.png" alt="Uppromote">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create an account !</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{route('register-user')}}" method="POST">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">Success!</span> {{\Illuminate\Support\Facades\Session::get('success')}}
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::has('fail'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">Error!</span> {{\Illuminate\Support\Facades\Session::get('fail')}}
                    </div>
                @endif

                @csrf
                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" value="{{old('name')}}" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span class="text-red-600">@error('name') {{$message}} @enderror</span>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" value="{{old('email')}}"  class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span class="text-red-600">@error('email') {{$message}} @enderror</span>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" value="{{old('password')}}" autocomplete="current-password"  class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span class="text-red-600">@error('password') {{$message}} @enderror</span>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    <div class="mt-2">
                        <input id="password" name="confirmPassword" type="password" value="{{old('confirmPassword')}}" autocomplete="current-password"  class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span class="text-red-600">@error('confirmPassword') {{$message}} @enderror</span>
                    </div>

                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 px-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register account</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already registered!
                <a href="/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login here</a>
            </p>
        </div>
    </div>
@endsection
