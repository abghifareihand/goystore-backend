<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; {{ $product->name }} &raquo; Gallery
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('product.gallery.create', $product->id) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 sm:rounded-lg">
                    + Upload Photos
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-auto w-full">
                    <thead class="bg-gray-200 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Photos</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gallery as $item)
                            <tr>
                                <td class="px-6 py-4 text-center">{{ $item->id }}</td>
                                <td class="px-6 py-4 text-center" style="vertical-align: middle;">
                                    <img src="{{ $item->image_url }}" style="max-width: 150px; display: block; margin: 0 auto;">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('product.gallery.destroy', ['product' => $product->id, 'gallery' => $item->id]) }}" method="POST"
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
                                <td colspan="3" class="border text-center p-5">
                                    Data Photo Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-5">
                {{-- {{ $gallery->links() }} --}}
            </div>
        </div>
    </div>
</x-app-layout>
