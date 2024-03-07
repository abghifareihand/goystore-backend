<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('category.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 sm:rounded-lg">
                    + Create Category
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-auto w-full">
                    <thead class="bg-gray-200 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Total Product</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($category as $item)
                            <tr>
                                <td class="px-6 py-4 text-center">{{ $item->id }}</td>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->products_count }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('category.edit', $item->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 sm:rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('category.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!}
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 inline-block sm:rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border text-center p-5">
                                    Data Category Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $category->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
