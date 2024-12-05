
<x-app-layout>
    @include('components.header')
    @include('components.breadcrumb')
    <div class="container mx-auto lg:w-2/3 p-5">
        <h1 class="text-3xl font-bold mb-2">My Orders</h1>
        <div class="bg-white rounded-lg p-3 overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                <tr class="border-b-2">
                    <th class="text-left p-2">Order #</th>
                    <th class="text-left p-2">Date</th>
                    <th class="text-left p-2">Status</th>
                    <th class="text-left p-2">SubTotal</th>
                    <th class="text-left p-2">Items</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="py-1 px-2">
                            <a
                                href="{{ route('order.view', $order) }}"
                                class="text-purple-600 hover:text-purple-500"
                            >
                                #{{$order->id}}
                            </a>
                        </td>
                        <td class="py-1 px-2 whitespace-nowrap">{{$order->created_at}}</td>
                        <td class="py-1 px-2">
                            <small class="text-white py-1 px-2 rounded
                                {{$order->isPaid() ? 'bg-emerald-500' : 'bg-gray-400' }}">
                                {{$order->status}}
                            </small
                            >
                        </td>
                        <td class="py-1 px-2">${{$order->total_price}}</td>
                        <td class="py-1 px-2 whitespace-nowrap">{{$order->items_count}} item(s)</td>                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
    @include('components.footer')
    @include('components.js')
</x-app-layout>