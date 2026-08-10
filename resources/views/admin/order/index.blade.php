@extends('layouts.backend.app')
@section('title', 'All Orders')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Orders</h6> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-inverse">
                            <thead>
                                <tr>
                                    <th>#OrderID</th>
                                    <th>Name</th>
                                    <th>Deliverey</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $item)
                                    <tr>
                                        <td scope="row">{{ $item->id }}</td>
                                        <td> {{ $item->user->name }} {!! $item->user->hasRole('Reseller') ? '<span class="badge badge-success">Reseller</span>' : '' !!}</td>
                                        <td> {{ $item->address->pincode ?? '' }} </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('order.show', $item->id) }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @empty 
                                    <tr class="text-center">
                                        <td colspan="6">No Record</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
