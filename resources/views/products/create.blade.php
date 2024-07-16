@extends('layout')
@section('content')
    @extends('header')

    <div class="mx-auto max-w-7xl p-6 lg:px-8">

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2>
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Image</label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img class="h-16 w-16 object-contain rounded-full"  id="image-preview" src="https://t3.ftcdn.net/jpg/04/60/01/36/360_F_460013622_6xF8uN6ubMvLx0tAJECBHfKPoNOR5cRa.jpg" alt="Image Preview" />
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage();" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                  "/>
                                </label>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">PNG, JPG SVG and WEBP are Allowed.</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Title</label>
                            <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Product name" required="">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Type</label>
                            <input type="text" name="product_type" id="name"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Product type" required="">
                        </div>
                        <div class="w-full">
                            <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor</label>
                            <input type="text" name="vendor" id="vendor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Vendor" required="">
                        </div>
                        <div class="w-full">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                            <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$299" required="">
                        </div>
                        <div>
                            <label for="tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tag</label>
                            <select id="tag" name="tags" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="" value="men">Men</option>
                                <option value="women">Women</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="" value="active">Active</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>

                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-500 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-blue-800">
                        Add product
                    </button>
                </form>
            </div>
        </section>
    </div>

@endsection
<script>
    function previewImage() {
        var file = document.getElementById("image").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            var imagePreview = document.getElementById("image-preview");
            imagePreview.src = reader.result;
            imagePreview.style.display = "block";
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            var imagePreview = document.getElementById("image-preview");
            imagePreview.src = "";
            imagePreview.style.display = "none";
        }
    }
</script>
