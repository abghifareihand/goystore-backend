<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; #{{ $transaction->transaction_number }} {{ $transaction->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Details</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-10">
                <table class="table-auto w-full">

                    <tbody>
                        <tr>
                            <th class="border px-6 py-4 text-right">Name</th>
                            <td class="border px-6 py-4">{{ $transaction->user->name }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Email</th>
                            <td class="border px-6 py-4">{{ $transaction->user->email }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Address</th>
                            <td class="border px-6 py-4">{{ $transaction->address }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-4 text-right">Total Price</th>
                            <td class="border px-6 py-4">{{ number_format($transaction->total_price) }}</td>
                        </tr>
                        <tr>
                            <th class="border px-6 py-4 text-right">Payment</th>
                            <td class="border px-6 py-4">
                                @if ($transaction->payment_status === 'SUCCESS')
                                <span class="bg-green-500 text-white font-bold py-2 px-4 sm:rounded-lg">SUCCESS</span>
                                @else
                                    <a href="{{ $transaction->payment_url }}"><button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 sm:rounded-lg">PENDING</button></a>
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="border px-6 py-4 text-right">Status</th>
                            <td
                                class="border px-6 py-4 font-semibold @if ($transaction->payment_status === 'SUCCESS') text-green-500 @else text-red-500 @endif">
                                {{ $transaction->payment_status }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>


            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Items</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-auto w-full">
                    <thead class="bg-gray-200 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Quantity</th>
                            <th class="px-6 py-3">Total Price</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-center">{{ $item->product->id }}</td>
                                <td class="px-6 py-4">{{ $item->product->name }}</td>
                                <td class="px-6 py-4">IDR {{ number_format($item->product->price) }}</td>
                                <td class="px-6 py-4">{{ $item->quantity }} items</td>
                                <td class="px-6 py-4">IDR {{ number_format($item->product->price * $item->quantity) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
