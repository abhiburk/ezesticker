@extends('layouts.backend.app')
@section('title', 'QR Codes')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 float-right">
            <div class="d-flex">
                <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#qrCodeGenerateModal">
                    <i class="fa fa-plus"></i> Generate QR Code
                </button>
                <select name="sort_qr" class="form-control mx-2" id="qr" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="{{ Request::url() }}?sort=default" {{ request()->sort == 'default' ? 'selected' : ''}}>Default</option>
                    <option value="{{ Request::url() }}?sort=new" {{ request()->sort == 'new' ? 'selected' : ''}}>Newest</option>
                    <option value="{{ Request::url() }}?sort=verified" {{ request()->sort == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="{{ Request::url() }}?sort=old" {{ request()->sort == 'old' ? 'selected' : '' }}>Oldest</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <form method="post">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d">
                        <h6 class="m-0 font-weight-bold text-primary">All QR Codes</h6> 
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>URL</th>
                                        <th>Type</th>
                                        <th>QR Verified By</th>
                                        <th>QR Verified At</th>
                                        <th>Created At</th>
                                        {{-- @role('admin')
                                            <th>Action</th>
                                        @endrole --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($qr_codes as $item)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration + $qr_codes->firstItem() - 1 }}</td>
                                            <td id="{{ route('qr.show_details', Helper::encodeIdForQr($item->id) ) }}">
                                                {!! QrCode::size(100)->generate(route('qr.show_details', Helper::encodeIdForQr($item->id) )); !!}
                                            </td>
                                            <td><a href="{{ route('qr.show_details', Helper::encodeIdForQr($item->id) ) }}">{{ route('qr.show_details', Helper::encodeIdForQr($item->id) ) }}</a></td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->qr_detail->user->name ?? "-" }}</td>
                                            <td>{{ $item->qr_verified_at ?? "-" }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            {{-- @role('admin')
                                                <td class="d-flex align-items-center">
                                                    <form class="delete-form" action="{{ route('qrcode.destroy', ['qrcode' => Helper::encodeIdForQr($item->id)] ) }}" method="POST">
                                                        {{ method_field('DELETE') }}
                                                        {!! csrf_field() !!}
                                                        <button type="button" class="btn btn-link confirm-delete">Delete</button>
                                                    </form>
                                                </td>
                                            @endrole --}}
                                        </tr>
                                    @empty 
                                        <tr class="text-center">
                                            <td colspan="7">No Record</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                            
                        <div class="d-flex justify-content-end">
                            {{ $qr_codes->links() }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="qrCodeGenerateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="qrCodeGenerateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('qrcode.store') }}" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="qrCodeGenerateLabel">Generate QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            @php $field = 'no_of_qrcode'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">No. of QR to Generate</label>
                            <input type="number" name="{{ $field }}" id="{{ $field }}" value="{{ old($field)? old($field) : 1  }}" class="form-control" placeholder="Default to 1">
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            @php $field = 'type'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Type of QR Code</label>
                            <select name="type" class="custom-select">
                                <option value="">Select option</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->slug }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @php
                            $urls = [
                                'http://127.0.0.1:8000',
                                'testing.ezesticker.com',
                                'https://ezesticker.com'
                            ]
                        @endphp
                        <div class="form-group col-lg-12">
                            @php $field = 'url'; @endphp
                            <label for="{{ $field }}" class="font-weight-bold">Select URL</label>
                            <select name="url" class="custom-select">
                                <option value="">Select option</option>
                                @foreach ($urls as $item)
                                    <option>{{ $item }}</option>
                                @endforeach
                            </select>
                            @error($field)
                                <small id="error_{{ $field }}" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        // Listen for click on toggle checkbox
        $('.select_all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>
@endpush
