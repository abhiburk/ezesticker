@extends('layouts.backend.app')
@section('title', 'All Users')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('user.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Users</h6> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-inverse">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Referral Code</th>
                                    <th>Refer By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td scope="row">{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->affiliate_id }}</td>
                                        <td>{{ isset($item->referral->name)? $item->referral->name:'-' }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('user.edit', ['user' => Helper::encodeId($item->id)] ) }}" class="btn btn-link">Edit</a>
                                            
                                            @if(auth()->user()->id != $item->id) |
                                                <form class="delete-form" action="{{ route('user.destroy', ['user' => Helper::encodeId($item->id)] ) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                                    <button type="button" class="btn btn-link confirm-delete">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    
@endpush
