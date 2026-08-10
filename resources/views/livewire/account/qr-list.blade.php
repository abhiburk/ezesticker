<div class="table-responsive">
    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr wire:ignore>
                <th scope="col">QR Code</th>
                <th scope="col">Primary Contact</th>
                <th scope="col" >Views <i class="fa fa-info-circle" title="Total visits by any users on this QR Sticker." data-toggle="tooltip" ></i></th>
                <th scope="col" >Call Impressions <i class="fa fa-info-circle" title="Attempts made by any user to call this QR Sticker." data-toggle="tooltip" ></i></th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($qr_details as $item)
                <tr>
                    <td id="{{ route('qr.show_details', Helper::encodeIdForQr($item->qr_code_id) ) }}">
                        {!! QrCode::size(50)->generate(route('qr.show_details', Helper::encodeIdForQr($item->qr_code_id) )); !!}
                    </td>
                    <td>{{ auth()->user()->phone }}</td>
                    <td>{{ $item->page_views }}</td>
                    <td>{{ $item->call_impressions }}</td>
                    <td>
                        <span class="badge {{ $item->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td >
                        <a href="{{ route('account.qr_sticker.edit', Helper::encodeIdForQr($item->qr_code_id)) }}" data-toggle="tooltip" title="Edit QR Sticker" class="btn btn-sm btn-outline-warning m-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('qr.show_details', Helper::encodeIdForQr($item->qr_code_id) ) }}" data-toggle="tooltip" title="View QR Sticker" class="m-1 btn btn-sm btn-outline-warning">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">
                        You don't have any qr stickers yet. <br>
                        <a href="{{ route('shop') }}" class="btn btn-sm btn-warning mt-3">Shop Now</a>
                    </td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
    <div class="float-right mt-4">
        {{ $qr_details->onEachSide(5)->links() }}
    </div>
</div>