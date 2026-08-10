@extends('layouts.backend.app')
@section('title', 'Coupon')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-end">
            <div>
                <a href="{{ route('coupon.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Coupon
                </a>
                
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
                        <h6 class="m-0 font-weight-bold text-primary">All Coupons</h6> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Target</th>
                                        <th>Value</th>
                                        <th>Start & End Date</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($coupons as $item)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration + $coupons->firstItem() - 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->target }}</td>
                                            <td>{{ $item->value }}</td>
                                            <td>{{ $item->start_date }} - {{ $item->end_date }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td class="d-flex align-items-center">
                                                <a href="{{ route('coupon.edit', Helper::encodeId($item->id)) }}" class="btn btn-link btn-sm">Edit</a>
                                                <form class="delete-form" action="{{ route('coupon.destroy', ['coupon' => Helper::encodeId($item->id)] ) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {!! csrf_field() !!}
                                                    <button type="button" class="btn btn-link text-danger btn-sm confirm-delete">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty 
                                        <tr class="text-center">
                                            <td colspan="8">No Record</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                            
                        <div class="d-flex justify-content-end">
                            {{ $coupons->links() }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
    </script>
@endpush
