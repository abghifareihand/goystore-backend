<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-auto w-full">
                    <thead class="bg-gray-200 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3">Number</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Total Price</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaction as $item)
                            <tr>
                                <td class="px-6 py-4 text-center">{{ $item->transaction_number }}</td>
                                <td class="px-6 py-4">{{ $item->user->name }}</td>
                                <td class="px-6 py-4">IDR {{ number_format($item->total_price) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="{{ $item->payment_status === 'SUCCESS' ? 'bg-green-500 text-white font-bold py-2 px-4 sm:rounded-lg' : 'bg-red-500 text-white font-bold py-2 px-4 sm:rounded-lg' }}">{{ $item->payment_status }}</span>
                                </td>
                                <td class="px-6 py-4">{{ $item->created_at }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('transaction.show', $item->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 sm:rounded-lg">
                                        Show
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border text-center p-5">
                                    Data Transaksi Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $transaction->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
