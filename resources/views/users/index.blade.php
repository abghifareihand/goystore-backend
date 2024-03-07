<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create User
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full border border-gray-300 shadow-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 border-b border-gray-300 py-3">ID</th>
                            <th class="px-6 border-b border-gray-300 py-3">Name</th>
                            <th class="px-6 border-b border-gray-300 py-3">Email</th>
                            <th class="px-6 border-b border-gray-300 py-3">Roles</th>
                            <th class="px-6 border-b border-gray-300 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user as $item)
                            <tr>
                                <td class="px-6 py-4 text-center">{{ $item->id }}</td>
                                <td class="px-6 py-4 ">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->roles }}</td>
                                <td class="px-6 py- text-center">
                                    <a href="{{ route('users.edit', $item->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!}
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded inline-block">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border text-center p-5">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $user->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
