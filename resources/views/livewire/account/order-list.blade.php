<div class="table-responsive">
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Type</th>
                <th scope="col">Total</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $item)
                <tr>
                    <td>#{{ $item->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-F-Y') }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ INR }}{{ $item->total }}</td>
                    <td>
                        <a href="{{ route('account.order.show', $item->id) }}" class="btn btn-warning">View</a>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">
                        You don't have any orders yet. <br>
                        <a href="{{ route('shop') }}" class="btn btn-sm btn-warning mt-3">Shop Now</a>
                    </td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
    <div class="float-right mt-4">
        {{ $orders->onEachSide(5)->links() }}
    </div>
</div>