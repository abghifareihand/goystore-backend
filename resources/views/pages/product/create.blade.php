<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Product &raquo; Create') !!}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    </div>
                @endif
                <form class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6"
                    action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="grid-last-name">
                                Name
                            </label>
                            <input value="{{ old('name') }}" name="name"
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="grid-last-name" type="text">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="grid-last-name">
                                Price
                            </label>
                            <input value="{{ old('price') }}" name="price"
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="grid-last-name" type="number">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="grid-last-name">
                                Description
                            </label>
                            <textarea name="description"
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="grid-last-name" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="grid-last-name">
                                Tags
                            </label>
                            <input value="{{ old('tags') }}" name="tags"
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="grid-last-name" type="text">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="grid-last-name">
                                Categories
                            </label>
                            <select name="categories_id"
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="grid-last-name">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 sm:rounded-lg">
                                Save Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
