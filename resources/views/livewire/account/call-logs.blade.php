<div class="table-responsive">
    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr wire:ignore>
                <th scope="col">#</th>
                {{-- <th scope="col">Call From</th>
                <th scope="col" >Call To</th> --}}
                <th scope="col" >Start Time</th>
                <th scope="col">Status</th>
                <th scope="col">Bill Sec</th>
                <th scope="col">{{ INR }}Credits</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($call_logs as $item)
                <tr>
                    <td>
                        {{ $loop->iteration + $call_logs->firstItem() - 1 }}
                    </td>
                    @if (!empty($item->call_report))
                        {{-- <td>+{{ $item->call_report->callee }}</td>
                        <td>+{{ $item->call_report->caller }}</td> --}}
                        <td>{{ Carbon::createFromTimestamp($item->call_report->starttime)->format('Y-m-d h:i:s a') }}</td>
                        <td>
                            <span class="badge {{ $item->call_report->status == 'ANSWER' ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->call_report->status == 'ANSWER' ? $item->call_report->status : 'FAILED/CANCEL' }}
                            </span>
                        </td>
                        <td>{{ $item->call_report->billsec }}</td>
                        <td>{{ round($item->call_report->credits, 4) }}</td>
                    @else 
                        <td colspan="6">
                            Call Report Unavailable
                        </td>
                    @endif
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="7">
                        You don't have any receive calls
                    </td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
    <div class="float-right mt-4">
        {{ $call_logs->onEachSide(5)->links() }}
    </div>
</div>